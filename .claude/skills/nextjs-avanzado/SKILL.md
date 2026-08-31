---
name: nextjs-avanzado
description: >
  Aplica prácticas avanzadas de Next.js que complementan una app App Router ya bien construida: streaming con Suspense, estrategias de revalidación e ISR más allá del default, autenticación y sesiones, middleware para rutas protegidas/redirects, optimistic updates, y optimización de imágenes/fuentes. Usa esta skill SIEMPRE que el usuario mencione streaming, carga progresiva, revalidación de caché, autenticación/sesiones, middleware, actualizaciones optimistas, o rendimiento de carga (imágenes, fuentes, Core Web Vitals) en un proyecto Next.js — como complemento a la skill `nextjs-app-router`, no como reemplazo.
---

# Next.js Avanzado

Esta skill es un complemento de `nextjs-app-router`, no un sustituto. Mientras esa skill cubre la estructura base (Server/Client Components, fetching, Server Actions), esta cubre las piezas que entran en juego cuando la app crece: carga progresiva, control fino de caché, autenticación, y rendimiento percibido.

## Cuándo usarla

- Una página tiene partes que cargan a distinta velocidad y no quieres bloquear todo el render por la más lenta.
- Necesitas control más fino de cuándo se revalida el caché que el default de la skill base.
- El proyecto necesita autenticación (sesiones, rutas protegidas).
- Necesitas interceptar requests antes de que lleguen a una página (redirects, headers, proteger rutas) — eso es middleware.
- Una mutación debería reflejarse en la UI antes de que el servidor confirme (optimistic update).
- Hay que optimizar imágenes, fuentes, o métricas de Core Web Vitals.

Si la tarea es una página o mutación estándar sin estas necesidades, usa `nextjs-app-router` — no fuerces estos conceptos donde no aportan valor.

## Streaming con Suspense

Cuando una parte de la página depende de un dato lento y el resto no debería esperarla:

```tsx
import { Suspense } from 'react';

export default function DashboardPage() {
  return (
    <div>
      <Header /> {/* rápido, se muestra de inmediato */}
      <Suspense fallback={<p>Cargando estadísticas...</p>}>
        <SlowStats /> {/* Server Component async, lento */}
      </Suspense>
    </div>
  );
}
```

- Usa esto cuando una sección es notablemente más lenta que el resto de la página, no envuelvas todo en Suspense "por si acaso".
- Cada `<Suspense>` es un límite de streaming independiente — el usuario ve el resto de la página mientras esa sección carga.

## Revalidación e ISR más allá del default

- `revalidatePath('/ruta')` / `revalidateTag('tag')`: invalidación bajo demanda tras una mutación (ver `nextjs-app-router` para el caso básico).
- **On-demand revalidation desde un webhook externo** (ej. un CMS headless notifica un cambio de contenido): expón un Route Handler que llame `revalidateTag()`/`revalidatePath()` al recibir el webhook, protegido con un secreto compartido.
- **`export const dynamic = 'force-dynamic'`** en una página: úsalo solo cuando la página realmente no puede cachearse en absoluto (ej. contenido único por request que no depende de parámetros cacheables) — es la excepción, no el default.

## Autenticación y sesiones

- Verifica la sesión en Server Components/Route Handlers directamente (no en `useEffect` del cliente redirigiendo después de montar — eso muestra contenido protegido brevemente antes de redirigir).
- Usa middleware (ver abajo) para proteger grupos de rutas completos de forma centralizada, en vez de repetir la verificación en cada página.
- Si el proyecto no tiene ya una librería de auth (NextAuth/Auth.js, Clerk, o similar) y se necesita, prefiere una solución probada antes que implementar sesiones a mano, salvo que el caso sea muy simple o haya una razón concreta para no usarla.

## Middleware

```ts
// middleware.ts
import { NextResponse } from 'next/server';
import type { NextRequest } from 'next/server';

export function middleware(request: NextRequest) {
  const session = request.cookies.get('session');

  if (!session && request.nextUrl.pathname.startsWith('/dashboard')) {
    return NextResponse.redirect(new URL('/login', request.url));
  }

  return NextResponse.next();
}

export const config = {
  matcher: ['/dashboard/:path*'],
};
```

- El middleware corre en el Edge Runtime — no uses ahí librerías que dependan de Node.js puro (ej. clientes de base de datos tradicionales); limita su lógica a verificaciones ligeras (cookies, headers, redirects).
- Usa `matcher` para acotar en qué rutas corre — no lo apliques globalmente si solo protege una sección.

## Optimistic Updates

Cuando la UI debe reflejar el cambio antes de la confirmación del servidor (ej. marcar un ítem como completado al instante):

```tsx
'use client';

import { useOptimistic } from 'react';

function TodoList({ todos, toggleTodo }: { todos: Todo[]; toggleTodo: (id: string) => Promise<void> }) {
  const [optimisticTodos, addOptimistic] = useOptimistic(todos, (state, id: string) =>
    state.map((t) => (t.id === id ? { ...t, done: !t.done } : t))
  );

  async function handleToggle(id: string) {
    addOptimistic(id);
    await toggleTodo(id);
  }

  return (
    <ul>
      {optimisticTodos.map((t) => (
        <li key={t.id} onClick={() => handleToggle(t.id)}>
          {t.done ? '✅' : '⬜'} {t.title}
        </li>
      ))}
    </ul>
  );
}
```

- Úsalo solo donde la latencia percibida realmente importa (listas interactivas, likes, checkboxes) — no lo apliques a mutaciones donde el usuario ya espera una confirmación explícita (ej. un pago).
- Si la mutación falla, `useOptimistic` revierte automáticamente al siguiente render con el estado real — asegúrate de mostrar el error correspondiente cuando eso pase.

## Optimización de imágenes y fuentes

- Usa siempre `next/image` en vez de `<img>` — maneja tamaño responsivo, lazy loading y formato óptimo automáticamente.
- Especifica `width`/`height` (o `fill` con un contenedor de tamaño definido) para evitar layout shift.
- Usa `next/font` para cargar fuentes (Google Fonts o locales) en vez de un `<link>` manual — evita el parpadeo de fuente (FOUT) y no bloquea el render.

## Referencias

- `references/checklist-rendimiento.md` — checklist de Core Web Vitals y streaming a revisar antes de dar por terminada una página con contenido pesado.
