# Cuándo Usar `@apply` — Tailwind CSS

## Por qué no es el default

`@apply` reintroduce el problema que Tailwind resuelve: separar los estilos del markup en una hoja de CSS aparte, con nombres de clase que hay que inventar y mantener sincronizados. Cuando un patrón de clases se repite, la solución por defecto es **extraer un componente** (React, Blade partial, etc.), no una clase CSS custom con `@apply` — el componente además encapsula el markup y el comportamiento, no solo el estilo.

```html
<!-- Evitar: @apply para "reutilizar" un botón -->
<style>
  .btn-primary {
    @apply bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700;
  }
</style>
<button class="btn-primary">Guardar</button>
```

```tsx
// Preferir: componente reutilizable
function Button({ children, ...props }: ButtonProps) {
  return (
    <button
      className="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700"
      {...props}
    >
      {children}
    </button>
  );
}
```

## Los pocos casos donde `@apply` sí tiene sentido

- **Estilos base globales** que no corresponden a un componente específico (ej. estilos de `<h1>`-`<h6>` en contenido generado dinámicamente, como el HTML renderizado de un CMS o Markdown, donde no puedes envolver cada elemento en un componente).

```css
/* Contenido dinámico sin control sobre el markup, ej. de un editor WYSIWYG */
.prose-content h2 {
  @apply text-2xl font-bold mt-6 mb-2;
}
```

- **Proyectos sin un sistema de componentes** (HTML plano/Blade sin componentes reutilizables) donde extraer un "componente" no es una opción real del stack — ahí una clase de utilidad compuesta puede ser el mejor compromiso disponible, aunque sigue siendo preferible una partial/include de Blade si el framework lo soporta, antes que `@apply`.

En cualquier otro caso donde el proyecto ya tiene un sistema de componentes disponible (React, Vue, Blade components), usa el componente — no `@apply`.
