---
name: nextjs-app-router
description: >
  Implementa aplicaciones Next.js (App Router) siguiendo las mejores prácticas del framework: Server Components por defecto con Client Components solo donde se necesita interactividad, fetching de datos en el servidor, Route Handlers y Server Actions para lógica de backend propio, estructura de carpetas estándar, manejo de formularios, y tests con Vitest/Jest + React Testing Library. Usa esta skill SIEMPRE que el usuario pida crear, modificar o revisar una página, componente, layout, Route Handler o Server Action en un proyecto Next.js con App Router — ya sea consumiendo una API externa o como full-stack con su propio backend.
---

# Desarrollo Next.js — App Router

Esta skill aplica las convenciones y buenas prácticas del App Router de Next.js (v13+), tanto para proyectos donde Next.js es solo frontend (consumiendo una API externa, ej. Laravel) como para proyectos full-stack donde Next.js también resuelve su propio backend vía Route Handlers/Server Actions.

Si llegas a esta skill dentro de la cadena de análisis (idea → requisitos → arquitectura → base de datos → diseño UX/UI → Scrum), usa el documento de arquitectura para confirmar el rol de Next.js en el proyecto (frontend puro vs. full-stack) y el documento de diseño UX/UI como fuente de verdad para pantallas, flujos y sistema de diseño — no los reinterpretes.

## Principios que debe seguir siempre

1. **Server Components por defecto.** Todo componente es Server Component salvo que necesite interactividad real en el navegador (estado, efectos, eventos, APIs del navegador) — en ese caso, y solo en ese caso, márcalo con `'use client'`. No agregues `'use client'` "por si acaso" a un componente entero cuando solo una parte pequeña necesita interactividad — extrae esa parte a un Client Component chico y deja el resto como Server Component.
2. **Fetching de datos en el servidor.** Prefiere hacer `fetch`/consultas a base de datos directamente en Server Components (o en Route Handlers/Server Actions), no en `useEffect` del cliente. Esto reduce el JS enviado al navegador y evita cascadas de loading innecesarias.
3. **Route Handlers para endpoints consumidos por terceros o webhooks**; **Server Actions para mutaciones disparadas desde formularios/interacciones de la propia UI**. No uses un Route Handler + fetch del cliente cuando una Server Action resuelve lo mismo con menos código y sin exponer un endpoint innecesario.
4. **Formularios progresивos.** Usa el atributo `action` de un `<form>` apuntando a una Server Action como patrón por defecto (funciona sin JS, se mejora con `useFormStatus`/`useActionState` para estados de carga/error) en vez de manejar todo con `onSubmit` + `fetch` del cliente, salvo que el caso realmente lo requiera (ej. formularios muy dinámicos).
5. **Estructura de carpetas por feature dentro de `app/`**, no todo en un mismo nivel — cada ruta con sus componentes específicos co-ubicados cuando no se reutilizan en otras rutas.
6. **Manejo explícito de estados de carga y error** usando `loading.tsx` y `error.tsx` por segmento de ruta, no spinners manuales repetidos en cada componente.
7. **Tipado estricto con TypeScript** en todo el proyecto — props, respuestas de fetch, Server Actions — nunca `any` como salida fácil.

## Flujo de trabajo

### 1. Entender qué se está construyendo

Si hay documentos previos de la cadena (arquitectura, diseño UX/UI), léelos para confirmar el rol de Next.js, las pantallas esperadas, y el sistema de diseño. Si no los hay, trabaja con lo que el usuario describe.

### 2. Revisar el proyecto existente antes de escribir código

Revisa la estructura ya presente en `app/`, qué librería de estado usa (si alguna), convenciones de estilos (Tailwind, CSS Modules), y si ya tiene un cliente de datos configurado (ORM, SDK de la API externa). Sigue lo existente — no introduzcas una librería o patrón nuevo sin que el usuario lo pida.

### 3. Decidir Server vs. Client Component

Antes de escribir un componente nuevo, pregúntate: ¿necesita `useState`, `useEffect`, manejadores de evento, o APIs del navegador? Si no, es Server Component. Si sí, aísla la parte interactiva en su propio Client Component y mantén el resto (layout, texto, fetching) como Server Component alrededor.

### 4. Implementar en el orden correcto

Para una funcionalidad nueva:
1. Ruta/segmento (`app/.../page.tsx`), con su `layout.tsx` si aplica
2. Fetching de datos (Server Component directo, o función en `lib/`/`data/` si se reutiliza)
3. Componentes de presentación (Server Components primero, Client Components solo donde haga falta)
4. `loading.tsx` y `error.tsx` del segmento
5. Route Handler o Server Action si hay mutación de datos
6. Tests

### 5. Escribir tests junto con el código

Usa Vitest (o Jest si el proyecto ya lo tiene configurado) + React Testing Library. Cubre:
- Renderizado correcto de Server Components con datos mockeados (sin necesidad de un servidor real corriendo)
- Comportamiento de Client Components interactivos (clicks, cambios de formulario) con `@testing-library/react` y `userEvent`
- Server Actions probadas como funciones puras cuando sea posible (extrayendo la lógica de validación/mutación a una función testeable, no solo dentro del cuerpo de la action)

Consulta `references/convenciones-tests.md` para la estructura exacta.

### 6. Verificar antes de dar por terminado

- Corre los tests y el linter del proyecto (ESLint con la config de Next.js).
- Verifica que no quede `'use client'` en componentes que no lo necesitan.
- Confirma que las variables de entorno sensibles (claves de API, secretos) no se usen accidentalmente en un Client Component (ahí terminan expuestas en el bundle del navegador) — solo variables prefijadas `NEXT_PUBLIC_` son seguras del lado del cliente.

## Referencias

- `references/estructura-proyecto.md` — organización de `app/`, dónde va cada pieza.
- `references/data-fetching.md` — patrones de fetching en servidor, caché básica de `fetch`, y cuándo usar Route Handler vs. Server Action.
- `references/convenciones-tests.md` — estructura y buenas prácticas para tests con Vitest + React Testing Library.
- `assets/ejemplo-feature-completa.md` — ejemplo de referencia de una feature completa (ruta → fetching → componentes → Server Action → tests).
