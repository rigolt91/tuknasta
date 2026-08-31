# Patrones de Consultas — Prisma

## Filtros y `select`/`include` explícitos

```ts
const products = await prisma.product.findMany({
  where: {
    userId,
    price: { gte: 10, lte: 100 },
  },
  select: {
    id: true,
    name: true,
    price: true,
    category: { select: { name: true } },
  },
  orderBy: { createdAt: 'desc' },
});
```

- No uses `include` sin necesidad cuando `select` ya te permite elegir exactamente los campos de la relación que necesitas — `include` trae el objeto de relación completo, `select` anidado es más preciso.

## Paginación

**Offset-based** (simple, suficiente para la mayoría de los casos):

```ts
const products = await prisma.product.findMany({
  skip: (page - 1) * pageSize,
  take: pageSize,
});
```

**Cursor-based** (mejor para datasets grandes o listas infinitas, evita el costo creciente de `skip` en offsets altos):

```ts
const products = await prisma.product.findMany({
  take: pageSize,
  skip: cursor ? 1 : 0,
  cursor: cursor ? { id: cursor } : undefined,
  orderBy: { id: 'asc' },
});
```

Usa cursor-based cuando el listado puede crecer mucho (miles de registros) o cuando la UI es de scroll infinito; offset-based es más simple y suficiente para tablas paginadas convencionales de tamaño moderado.

## Agregaciones

```ts
const stats = await prisma.product.aggregate({
  where: { userId },
  _avg: { price: true },
  _count: true,
});

const byCategory = await prisma.product.groupBy({
  by: ['categoryId'],
  _count: { id: true },
});
```

## Transacciones

**Transacción secuencial** (varias operaciones dependientes, ejecutadas en orden dentro de una misma transacción):

```ts
await prisma.$transaction(async (tx) => {
  const order = await tx.order.create({ data: { userId, total } });
  await tx.orderItem.createMany({
    data: items.map((item) => ({ ...item, orderId: order.id })),
  });
  await tx.user.update({
    where: { id: userId },
    data: { creditBalance: { decrement: total } },
  });
});
```

**Transacción por lote** (varias operaciones independientes entre sí, ejecutadas atómicamente):

```ts
await prisma.$transaction([
  prisma.product.update({ where: { id: 1 }, data: { stock: { decrement: 1 } } }),
  prisma.auditLog.create({ data: { action: 'stock_decrement', productId: 1 } }),
]);
```

Usa la forma secuencial (callback) cuando una operación depende del resultado de la anterior (ej. necesitas el `order.id` recién creado); usa la forma de array cuando las operaciones son independientes entre sí.

## Relaciones muchos-a-muchos explícitas (con datos adicionales)

Cuando la relación necesita atributos propios (ej. cantidad en una línea de pedido), modela la tabla intermedia como un modelo explícito, no una relación implícita `@relation` simple:

```prisma
model Order {
  id    String      @id @default(cuid())
  items OrderItem[]
}

model Product {
  id    String      @id @default(cuid())
  items OrderItem[]
}

model OrderItem {
  orderId   String
  productId String
  quantity  Int
  order     Order   @relation(fields: [orderId], references: [id])
  product   Product @relation(fields: [productId], references: [id])

  @@id([orderId, productId])
}
```

## Auto-relaciones

Para jerarquías (ej. categorías con subcategorías):

```prisma
model Category {
  id       String     @id @default(cuid())
  name     String
  parentId String?
  parent   Category?  @relation("CategoryHierarchy", fields: [parentId], references: [id])
  children Category[] @relation("CategoryHierarchy")
}
```

## Manejo de errores de Prisma

Captura errores específicos de Prisma (`PrismaClientKnownRequestError`) para dar respuestas claras, en vez de dejar que se propaguen como error genérico:

```ts
import { Prisma } from '@prisma/client';

try {
  await prisma.product.create({ data });
} catch (error) {
  if (error instanceof Prisma.PrismaClientKnownRequestError && error.code === 'P2002') {
    // violación de constraint único
    throw new Error('Ya existe un producto con ese nombre');
  }
  throw error;
}
```
