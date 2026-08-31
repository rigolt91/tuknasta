# Checklist de Rendimiento — Next.js

Revisa esto antes de dar por terminada una página con contenido pesado o tráfico esperado alto.

## Carga y streaming

- [ ] ¿Alguna sección de la página es notablemente más lenta que el resto y podría envolverse en `<Suspense>` para no bloquear el render inicial?
- [ ] ¿`loading.tsx` está definido en los segmentos de ruta que hacen fetching lento?

## Caché

- [ ] ¿Los `fetch` usan la estrategia de caché adecuada (`revalidate`, `no-store`, default) según qué tan frecuentemente cambia el dato?
- [ ] ¿Toda Server Action que muta datos invalida el caché correspondiente (`revalidatePath`/`revalidateTag`)?
- [ ] ¿Se evitó `force-dynamic` salvo en los casos que realmente lo requieren?

## Imágenes y fuentes

- [ ] ¿Todas las imágenes usan `next/image` con `width`/`height` (o `fill` correctamente contenido)?
- [ ] ¿Las fuentes se cargan con `next/font` en vez de un `<link>` manual?

## Bundle de cliente

- [ ] ¿Hay algún `'use client'` en un componente grande que podría reducirse extrayendo solo la parte interactiva?
- [ ] ¿Alguna librería pesada (ej. una librería de gráficos) se importa de forma dinámica (`next/dynamic`) si solo se usa en una parte específica de la app?

## Middleware

- [ ] Si existe middleware, ¿su `matcher` está acotado a las rutas que realmente necesita proteger/interceptar, en vez de correr globalmente?
