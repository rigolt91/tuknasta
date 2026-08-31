# Estructura de Proyecto — Next.js App Router

## Organización recomendada

```
app/
  (marketing)/              # Route group — no afecta la URL, agrupa páginas públicas
    page.tsx
    layout.tsx
  dashboard/
    layout.tsx
    page.tsx
    loading.tsx
    error.tsx
    settings/
      page.tsx
    products/
      page.tsx
      [id]/
        page.tsx
      _components/         # Componentes privados de esta ruta, no reutilizados fuera
        ProductCard.tsx
  api/
    webhooks/
      stripe/
        route.ts            # Route Handler para webhook externo
components/                 # Componentes compartidos entre varias rutas
  ui/                        # Componentes base de UI (botón, input, card)
lib/                         # Funciones de fetching, utilidades, clientes de API/DB
  data/                      # Funciones que obtienen datos (ej. getProducts, getUser)
  actions/                   # Server Actions, agrupadas por dominio
types/                       # Tipos TypeScript compartidos
```

## Route Groups y carpetas privadas

- Usa `(nombre)` para agrupar rutas sin afectar la URL (ej. separar `(marketing)` de `(app)` con layouts distintos).
- Usa `_nombre` (prefijo guion bajo) para carpetas que Next.js debe ignorar como rutas (ej. `_components/` co-ubicados con una página específica).

## Cuándo co-ubicar vs. compartir

- Un componente usado solo por una ruta específica vive en `_components/` dentro de esa ruta.
- Un componente usado por 2+ rutas distintas se mueve a `components/` en la raíz.
- No muevas algo a `components/` compartido "por si se reutiliza después" — hazlo cuando la segunda ruta que lo necesita realmente aparece (YAGNI aplica igual aquí que en backend).

## Server Actions

Agrúpalas por dominio en `lib/actions/` (ej. `lib/actions/products.ts`), no todas en un solo archivo gigante ni dispersas inline en cada componente si se reutilizan.

```ts
'use server';

export async function createProduct(formData: FormData) {
  // validación + mutación
}
```

## Variables de entorno

- Sin prefijo (`API_SECRET_KEY`): solo accesible en el servidor (Server Components, Route Handlers, Server Actions). Nunca la importes en un Client Component.
- Con prefijo `NEXT_PUBLIC_`: se incluye en el bundle del navegador — solo para datos que es aceptable exponer (ej. una URL pública de API, un ID de analytics).
