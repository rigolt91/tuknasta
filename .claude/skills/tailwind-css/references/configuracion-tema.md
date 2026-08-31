# Configuración del Tema — Tailwind CSS

## Por qué extender el tema en vez de usar valores arbitrarios

Un color o espaciado usado en un solo lugar puede ser un valor arbitrario (`bg-[#3b82f6]`) sin problema. Pero en cuanto se repite, debería vivir en el tema — así un cambio de marca (ej. actualizar el color primario) se hace en un solo lugar, no buscando y reemplazando en todo el proyecto.

## Extender colores (Tailwind v3 — `tailwind.config.js`)

```js
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#3b82f6',
          50: '#eff6ff',
          500: '#3b82f6',
          600: '#2563eb',
          900: '#1e3a8a',
        },
      },
    },
  },
};
```

```html
<button class="bg-primary-600 hover:bg-primary-700">Guardar</button>
```

## Tailwind v4 — configuración vía CSS (`@theme`)

Si el proyecto usa Tailwind v4, la configuración de tema se hace directamente en CSS, no en un archivo JS:

```css
/* app.css */
@import "tailwindcss";

@theme {
  --color-primary-500: #3b82f6;
  --color-primary-600: #2563eb;
  --font-display: "Cal Sans", sans-serif;
}
```

Confirma qué versión usa el proyecto (revisa `package.json` — v4 no tiene `tailwind.config.js` por defecto, usa el bloque `@theme` en CSS) antes de asumir el formato de configuración.

## Tipografía

```js
theme: {
  extend: {
    fontFamily: {
      display: ['"Cal Sans"', 'sans-serif'],
      body: ['Inter', 'sans-serif'],
    },
  },
},
```

Si viene un sistema de diseño de la skill `frontend-design` (roles de tipografía: display, cuerpo, utilitaria), refleja esos mismos roles aquí como `font-display`, `font-body`, etc., en vez de usar `font-sans`/`font-serif` genéricos.

## Espaciado y breakpoints custom

Solo agrega valores custom de espaciado/breakpoints cuando la escala por defecto de Tailwind realmente no cubre una necesidad recurrente del diseño — no agregues un valor custom para un caso aislado que un valor arbitrario puntual ya resuelve.

```js
theme: {
  extend: {
    spacing: {
      18: '4.5rem', // solo si se repite varias veces en el proyecto
    },
    screens: {
      xs: '480px', // solo si el diseño realmente necesita un breakpoint entre mobile y sm
    },
  },
},
```

## Content/purge

Confirma que `content` (v3) o la detección automática (v4) cubra todos los archivos donde se escriben clases de Tailwind (incluye `.tsx`, `.blade.php`, según el proyecto) — clases no detectadas en el build no se generan y el estilo simplemente no aparece, un error silencioso común.
