# Orden de Clases — Tailwind CSS

Un orden consistente hace que dos componentes similares sean comparables a simple vista y facilita detectar inconsistencias. Sigue este orden de categorías (de izquierda a derecha en el string de clases):

1. **Layout** — `flex`, `grid`, `block`, `absolute`, `relative`, `inset-0`
2. **Flexbox/Grid interno** — `flex-col`, `items-center`, `justify-between`, `gap-4`, `grid-cols-3`
3. **Tamaño** — `w-full`, `h-screen`, `max-w-lg`, `min-h-0`
4. **Espaciado** — `p-4`, `px-6`, `m-2`, `space-y-4`
5. **Tipografía** — `text-lg`, `font-semibold`, `leading-tight`, `tracking-wide`
6. **Color y fondo** — `text-gray-900`, `bg-white`
7. **Bordes y sombras** — `border`, `border-gray-200`, `rounded-lg`, `shadow-md`
8. **Estados interactivos** — `hover:bg-gray-50`, `focus:ring-2`, `disabled:opacity-50`
9. **Responsive** — `md:flex-row`, `lg:px-8` (el modificador de breakpoint envuelve la clase que modifica, se coloca cerca de su clase base equivalente sin breakpoint, no todas juntas al final)
10. **Dark mode** — `dark:bg-gray-900`, `dark:text-white` (junto a su contraparte de modo claro, no en un bloque separado)

## Ejemplo aplicando el orden

```html
<button
  class="flex items-center justify-center gap-2 w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 disabled:opacity-50 md:w-auto dark:bg-blue-500 dark:hover:bg-blue-600"
>
  Guardar
</button>
```

## Formateo automático

Si el proyecto no tiene ya un ordenador automático de clases, sugiere instalar `prettier-plugin-tailwindcss` — ordena las clases automáticamente según las convenciones oficiales de Tailwind, evitando que el orden dependa de la disciplina manual de cada desarrollador. Si el proyecto ya lo tiene configurado, confía en su output en vez de reordenar manualmente.
