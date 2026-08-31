# Ejemplo de Feature Completa — Lista y Creación de Productos

Este ejemplo ilustra el orden y la forma esperada de cada pieza para una feature simple con lectura (Server Component) y escritura (Server Action).

## 1. Función de fetching (`lib/data/products.ts`)

```ts
export type Product = { id: string; name: string; price: number };

export async function getProducts(): Promise<Product[]> {
  const res = await fetch('https://api.miapp.com/products', {
    next: { revalidate: 3600, tags: ['products'] },
  });
  if (!res.ok) throw new Error('No se pudieron cargar los productos');
  return res.json();
}
```

## 2. Página (Server Component) — `app/products/page.tsx`

```tsx
import { getProducts } from '@/lib/data/products';
import { ProductList } from './_components/ProductList';
import { CreateProductForm } from './_components/CreateProductForm';

export default async function ProductsPage() {
  const products = await getProducts();

  return (
    <div>
      <CreateProductForm />
      <ProductList products={products} />
    </div>
  );
}
```

## 3. Estados de carga y error

```tsx
// app/products/loading.tsx
export default function Loading() {
  return <p>Cargando productos...</p>;
}
```

```tsx
// app/products/error.tsx
'use client';

export default function Error({ reset }: { reset: () => void }) {
  return (
    <div>
      <p>Ocurrió un error al cargar los productos.</p>
      <button onClick={reset}>Reintentar</button>
    </div>
  );
}
```

## 4. Componente de presentación (Server Component) — `app/products/_components/ProductList.tsx`

```tsx
import type { Product } from '@/lib/data/products';

export function ProductList({ products }: { products: Product[] }) {
  if (products.length === 0) {
    return <p>Aún no hay productos. Crea el primero arriba.</p>;
  }

  return (
    <ul>
      {products.map((p) => (
        <li key={p.id}>{p.name} — ${p.price}</li>
      ))}
    </ul>
  );
}
```

## 5. Server Action — `lib/actions/products.ts`

```ts
'use server';

import { revalidateTag } from 'next/cache';

export function parseProductInput(formData: FormData) {
  return {
    name: String(formData.get('name') ?? ''),
    price: Number(formData.get('price')),
  };
}

export async function createProduct(formData: FormData) {
  const data = parseProductInput(formData);

  if (!data.name) {
    return { error: 'El nombre es requerido' };
  }

  const res = await fetch('https://api.miapp.com/products', {
    method: 'POST',
    body: JSON.stringify(data),
    headers: { 'Content-Type': 'application/json' },
  });

  if (!res.ok) {
    return { error: 'No se pudo crear el producto' };
  }

  revalidateTag('products');
  return { success: true };
}
```

## 6. Client Component con el formulario — `app/products/_components/CreateProductForm.tsx`

```tsx
'use client';

import { useActionState } from 'react';
import { createProduct } from '@/lib/actions/products';

export function CreateProductForm() {
  const [state, formAction, isPending] = useActionState(createProduct, null);

  return (
    <form action={formAction}>
      <input name="name" placeholder="Nombre del producto" required />
      <input name="price" type="number" step="0.01" required />
      <button type="submit" disabled={isPending}>
        {isPending ? 'Guardando...' : 'Crear producto'}
      </button>
      {state?.error && <p role="alert">{state.error}</p>}
    </form>
  );
}
```

## 7. Tests

```ts
// lib/actions/products.test.ts
import { parseProductInput } from './products';

it('convierte el precio a número', () => {
  const fd = new FormData();
  fd.set('name', 'Silla');
  fd.set('price', '49.90');
  expect(parseProductInput(fd)).toEqual({ name: 'Silla', price: 49.9 });
});
```

```tsx
// app/products/_components/CreateProductForm.test.tsx
import { render, screen } from '@testing-library/react';
import userEvent from '@testing-library/user-event';
import { CreateProductForm } from './CreateProductForm';

it('muestra el botón en estado de carga al enviar', async () => {
  render(<CreateProductForm />);
  await userEvent.type(screen.getByPlaceholderText(/nombre/i), 'Silla');
  await userEvent.click(screen.getByRole('button', { name: /crear producto/i }));
  expect(screen.getByRole('button')).toBeDisabled();
});
```

Nota cómo el fetching vive fuera del componente (reutilizable y testeable), la Server Action separa la lógica pura (`parseProductInput`) de la mutación en sí, y el Client Component se limita a la parte que realmente necesita interactividad (el formulario), dejando el resto de la página como Server Component.
