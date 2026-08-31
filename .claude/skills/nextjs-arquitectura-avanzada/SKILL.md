---
name: nextjs-arquitectura-avanzada
description: >
  Aplica prácticas avanzadas de arquitectura y seguridad en proyectos Next.js que ya usan `nextjs-app-router` y `nextjs-avanzado`: internacionalización (i18n), seguridad de headers y CSP, Server Actions seguras contra CSRF/abuso, monorepos y organización multi-app, y decisiones de runtime (Edge vs. Node) y despliegue. Usa esta skill SIEMPRE que el usuario mencione soportar varios idiomas, endurecer la seguridad de headers/CSP, proteger Server Actions de abuso, organizar un monorepo, o decidir entre Edge Runtime y Node.js Runtime para una parte de la app.
---

# Next.js — Arquitectura Avanzada y Seguridad

Esta skill es la tercera pieza del conjunto Next.js, complementaria a `nextjs-app-router` (estructura base) y `nextjs-avanzado` (streaming, caché, auth, middleware). Cubre decisiones que aparecen cuando el proyecto necesita escalar en alcance (varios idiomas, varios proyectos relacionados) o requiere un endurecimiento de seguridad más allá de lo básico.

## Cuándo usarla

- El proyecto necesita soportar más de un idioma.
- Se necesita configurar headers de seguridad (CSP, HSTS, etc.) o revisar la superficie de ataque de Server Actions.
- El usuario está organizando varios proyectos relacionados (ej. web + panel admin + landing) y pregunta cómo estructurarlos.
- Hay que decidir explícitamente entre Edge Runtime y Node.js Runtime para una ruta o middleware.

Si la tarea es una página o feature estándar, usa `nextjs-app-router`; si es sobre streaming/caché/auth/middleware básico, usa `nextjs-avanzado`.

## Internacionalización (i18n)

Con App Router, el patrón estándar es un segmento dinámico de idioma en la raíz de las rutas:

```
app/
  [locale]/
    layout.tsx
    page.tsx
    dashboard/
      page.tsx
middleware.ts   # detecta/redirige al locale correcto
```

```ts
// middleware.ts (fragmento)
const locales = ['es', 'en'];
const defaultLocale = 'es';

export function middleware(request: NextRequest) {
  const pathnameHasLocale = locales.some((locale) =>
    request.nextUrl.pathname.startsWith(`/${locale}`)
  );
  if (pathnameHasLocale) return;

  const locale = defaultLocale; // o detectarlo por Accept-Language/cookie
  request.nextUrl.pathname = `/${locale}${request.nextUrl.pathname}`;
  return NextResponse.redirect(request.nextUrl);
}
```

- Usa una librería madura (`next-intl` es la opción más común con App Router) para manejo de traducciones, formateo de fechas/números — no reinventes esto a mano salvo un caso muy simple de 1-2 textos.
- Los textos van en archivos de traducción por idioma (`messages/es.json`, `messages/en.json`), nunca hardcodeados en el componente ni siquiera "temporalmente".
- Las rutas de metadata (`generateMetadata`) también deben traducirse — no dejes el `<title>`/`description` solo en el idioma por defecto.

## Seguridad de headers y CSP

Configura headers de seguridad en `next.config.js` (o middleware si necesitan ser dinámicos):

```js
// next.config.js
const securityHeaders = [
  { key: 'X-Frame-Options', value: 'DENY' },
  { key: 'X-Content-Type-Options', value: 'nosniff' },
  { key: 'Referrer-Policy', value: 'strict-origin-when-cross-origin' },
  {
    key: 'Content-Security-Policy',
    value: "default-src 'self'; img-src 'self' data: https:; script-src 'self' 'unsafe-inline';",
  },
];

module.exports = {
  async headers() {
    return [{ source: '/:path*', headers: securityHeaders }];
  },
};
```

- Empieza el CSP restrictivo (`default-src 'self'`) y ábrelo solo para los orígenes que realmente necesitas (CDN de imágenes, scripts de analítica) — no partas de una política permisiva "para que funcione" y la endurezcas después, casi nunca se vuelve a hacer.
- Prueba el CSP en modo `Content-Security-Policy-Report-Only` primero si el proyecto ya está en producción, para detectar qué rompería antes de aplicarlo de forma estricta.

## Server Actions seguras

Las Server Actions son endpoints HTTP implícitos — trátalas con el mismo cuidado que un Route Handler:

- **Revalida sesión/permisos dentro de la Action misma**, no asumas que el hecho de que la UI no muestre el botón a un usuario sin permiso es suficiente — cualquiera puede invocar la action directamente con el ID de la función.
- **Valida y sanitiza el input** igual que en un Route Handler — una Server Action no tiene validación automática solo por ser "interna".
- **Rate limiting en Server Actions sensibles** (ej. las que envían emails, generan recursos costosos) usando el mismo mecanismo que usarías en un Route Handler (ej. `@upstash/ratelimit` u otra solución ya presente en el proyecto).

## Monorepo y organización multi-app

Cuando el proyecto crece a varias apps relacionadas (web pública, panel admin, landing de marketing):

```
apps/
  web/          # Next.js — app principal
  admin/        # Next.js — panel administrativo
  landing/      # Next.js — marketing, posiblemente estático
packages/
  ui/           # Componentes compartidos
  config/       # ESLint/TS config compartida
  lib/          # Utilidades compartidas (tipos, clientes de API)
```

- Usa un monorepo (Turborepo es la opción más común en el ecosistema Next.js) solo cuando realmente hay 2+ apps relacionadas que comparten código — no lo introduzcas para un proyecto de una sola app "por si crece después".
- Comparte tipos y componentes de UI vía `packages/`, no copiando y pegando entre apps.

## Edge Runtime vs. Node.js Runtime

| | Edge Runtime | Node.js Runtime |
|---|---|---|
| Arranque | Más rápido (cerca del usuario) | Más lento (cold start mayor) |
| APIs disponibles | Subconjunto limitado (sin acceso a filesystem, ciertos módulos de Node) | Todas las APIs de Node.js |
| Uso típico | Middleware, lógica ligera y sensible a latencia | Route Handlers/Server Actions con acceso a DB tradicional, librerías pesadas |

- El middleware siempre corre en Edge — diséñalo asumiendo esa limitación.
- Para Route Handlers, usa Edge (`export const runtime = 'edge'`) solo si la lógica es ligera y no depende de librerías Node-only; si usa un ORM tradicional o SDKs que requieren Node, usa el runtime Node.js (default).

## Referencias

- `references/checklist-i18n-seguridad.md` — checklist rápido antes de considerar la app lista para producción con múltiples idiomas y headers de seguridad configurados.
