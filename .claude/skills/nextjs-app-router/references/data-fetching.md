# Data Fetching — Next.js App Router

## Fetching en Server Components (patrón por defecto)

```tsx
// app/products/page.tsx — Server Component, sin 'use client'
async function getProducts() {
  const res = await fetch('https://api.miapp.com/products', {
    next: { revalidate: 3600 }, // revalida cada hora (ISR)
  });
  if (!res.ok) throw new Error('No se pudieron cargar los productos');
  return res.json();
}

export default async function ProductsPage() {
  const products = await getProducts();
  return <ProductList products={products} />;
}
```

- El componente de página/ruta puede ser `async` directamente — no necesitas `useEffect` ni estado de loading manual para la carga inicial.
- Usa `loading.tsx` en el mismo segmento para el estado de carga (Next.js lo muestra automáticamente vía Suspense mientras el Server Component async resuelve).

## Estrategias de caché de `fetch`

| Opción | Comportamiento | Cuándo usarla |
|--------|------------------|-----------------|
| `{ cache: 'force-cache' }` (default) | Cachea indefinidamente hasta rebuild/invalidación manual | Datos que casi nunca cambian |
| `{ next: { revalidate: N } }` | Revalida cada N segundos (ISR) | Datos que cambian pero no necesitan tiempo real |
| `{ cache: 'no-store' }` | Sin caché, siempre fresco | Datos por-usuario, dashboards en tiempo real |

No uses `no-store` por defecto en todo — eso renuncia a las ventajas de rendimiento del App Router sin necesidad real.

## Route Handler vs. Server Action

- **Route Handler** (`app/api/.../route.ts`): cuando el endpoint debe ser consumido por un cliente externo (app móvil, webhook de un tercero, otro servicio), o cuando necesitas control fino sobre el método HTTP/headers de la respuesta.
- **Server Action**: cuando la mutación se dispara desde la propia UI de la app (un formulario, un botón) — evita crear un endpoint innecesario solo para que el propio frontend lo llame.

```ts
// app/api/webhooks/stripe/route.ts — Route Handler, consumido por Stripe
export async function POST(request: Request) {
  const payload = await request.json();
  // procesar webhook
  return Response.json({ received: true });
}
```

```ts
// lib/actions/products.ts — Server Action, disparada desde un <form> propio
'use server';

export async function createProduct(formData: FormData) {
  const name = formData.get('name');
  // validar y guardar
  revalidatePath('/products'); // invalida el caché de la ruta afectada
}
```

## Invalidación de caché tras una mutación

Después de una Server Action que cambia datos, invalida explícitamente lo que quedó cacheado:

- `revalidatePath('/products')` — invalida el caché de una ruta específica.
- `revalidateTag('products')` — invalida por tag, si el `fetch` original se etiquetó con `{ next: { tags: ['products'] } }`. Preferible cuando el mismo dato aparece en varias rutas.

No dejes una Server Action que muta datos sin invalidar el caché correspondiente — es la causa más común de "datos viejos" en producción con App Router.
