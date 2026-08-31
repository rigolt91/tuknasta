# Ejemplo de Modelo Completo — Producto (Prisma)

## 1. Schema

```prisma
// schema.prisma
model User {
  id       String    @id @default(cuid())
  email    String    @unique
  name     String
  products Product[]
}

model Category {
  id       String    @id @default(cuid())
  name     String
  products Product[]
}

model Product {
  id         String   @id @default(cuid())
  name       String
  price      Decimal  @db.Decimal(10, 2)
  userId     String
  user       User     @relation(fields: [userId], references: [id], onDelete: Cascade)
  categoryId String?
  category   Category? @relation(fields: [categoryId], references: [id])
  createdAt  DateTime @default(now())
  updatedAt  DateTime @updatedAt

  @@index([userId])
  @@unique([userId, name]) // un usuario no puede tener dos productos con el mismo nombre
}
```

## 2. Migración

```bash
npx prisma migrate dev --name add_product_model
npx prisma generate
```

## 3. Cliente singleton

```ts
// lib/prisma.ts
import { PrismaClient } from '@prisma/client';

const globalForPrisma = globalThis as unknown as { prisma: PrismaClient };
export const prisma = globalForPrisma.prisma ?? new PrismaClient();
if (process.env.NODE_ENV !== 'production') globalForPrisma.prisma = prisma;
```

## 4. Funciones de datos (`lib/data/products.ts`)

```ts
import { prisma } from '@/lib/prisma';
import { Prisma } from '@prisma/client';

export async function getProductsByUser(userId: string) {
  return prisma.product.findMany({
    where: { userId },
    select: { id: true, name: true, price: true, category: { select: { name: true } } },
    orderBy: { createdAt: 'desc' },
  });
}

export async function createProduct(data: { name: string; price: number; userId: string; categoryId?: string }) {
  try {
    return await prisma.product.create({ data });
  } catch (error) {
    if (error instanceof Prisma.PrismaClientKnownRequestError && error.code === 'P2002') {
      throw new Error('Ya tienes un producto con ese nombre');
    }
    throw error;
  }
}
```

## 5. Uso en Next.js (Server Action) — igual aplicaría en un Route Handler o backend Node genérico

```ts
'use server';

import { createProduct } from '@/lib/data/products';
import { revalidatePath } from 'next/cache';

export async function createProductAction(formData: FormData) {
  const name = String(formData.get('name'));
  const price = Number(formData.get('price'));

  await createProduct({ name, price, userId: /* de la sesión */ 'user-1' });
  revalidatePath('/products');
}
```

## 6. Tests

```ts
import { beforeEach, it, expect } from 'vitest';
import { prisma } from '@/lib/prisma';
import { createProduct, getProductsByUser } from '@/lib/data/products';

beforeEach(async () => {
  await prisma.product.deleteMany();
  await prisma.user.deleteMany();
  await prisma.user.create({ data: { id: 'user-1', email: 'a@a.com', name: 'Ana' } });
});

it('crea un producto y lo lista', async () => {
  await createProduct({ name: 'Silla', price: 49.9, userId: 'user-1' });
  const products = await getProductsByUser('user-1');

  expect(products).toHaveLength(1);
  expect(products[0].name).toBe('Silla');
});

it('rechaza un nombre duplicado para el mismo usuario', async () => {
  await createProduct({ name: 'Silla', price: 49.9, userId: 'user-1' });

  await expect(createProduct({ name: 'Silla', price: 39.9, userId: 'user-1' }))
    .rejects.toThrow('Ya tienes un producto con ese nombre');
});
```

Nota cómo la función de datos (`lib/data/products.ts`) es independiente del framework que la consuma — la misma función serviría igual desde un Route Handler, una Server Action, o un controlador de Express, que es justamente el punto de mantener Prisma desacoplado de la capa de presentación.
