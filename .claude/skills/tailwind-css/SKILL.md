---
name: tailwind-css
description: >
  Aplica las convenciones técnicas de Tailwind CSS al escribir o modificar UI: organización y orden de clases, configuración del tema (colores, tipografía, espaciado) vía tokens de diseño, responsive y dark mode, extracción de patrones repetidos a componentes en vez de `@apply` indiscriminado, y manejo de variantes de componente con clsx/cva. Es agnóstica de framework (React/Next.js, Blade, HTML plano). Usa esta skill SIEMPRE que el usuario escriba o edite markup con clases de Tailwind, configure `tailwind.config`, o pida ayuda con responsive, dark mode, o variantes de un componente.
---

# Tailwind CSS

Esta skill cubre las convenciones **técnicas** de Tailwind: cómo organizar clases, configurar el tema, manejar responsive/dark mode, y estructurar variantes de componente. Es complementaria a la skill `frontend-design` (que cubre decisiones **estéticas** — paleta, tipografía, evitar looks genéricos de IA): usa `frontend-design` primero para decidir qué se ve bien, y esta skill para implementarlo con las convenciones correctas de Tailwind.

Es agnóstica de framework — aplica igual en componentes React/Next.js, vistas Blade de Laravel, o HTML plano.

## Principios que debe seguir siempre

1. **El tema de Tailwind (`tailwind.config`) es la fuente de verdad de los tokens de diseño**, no valores arbitrarios repetidos por todo el código. Si un color, espaciado o tipografía se usa más de un par de veces, debe estar en la configuración del tema, no como valor arbitrario (`bg-[#3b82f6]`) repetido en múltiples archivos.
2. **Orden de clases consistente**, para que los componentes sean legibles y comparables entre sí (ver `references/orden-clases.md`). No es solo estética — un orden consistente hace mucho más fácil detectar duplicación o inconsistencia entre componentes similares.
3. **Extraer a componente, no a `@apply` indiscriminado.** Cuando un patrón de clases se repite, la solución por defecto es extraer un componente reutilizable (React/Blade/partial), no crear una clase custom con `@apply` que reintroduce el problema que Tailwind resuelve (separar estilos del markup). Reserva `@apply` para casos muy puntuales (ver `references/cuando-usar-apply.md`).
4. **Mobile-first siempre.** Escribe las clases base pensando en mobile, y añade prefijos (`md:`, `lg:`) solo para los cambios que aplican en pantallas más grandes — nunca al revés (clases base para desktop y modificadores para mobile).
5. **Dark mode con la estrategia ya configurada en el proyecto** (`class` o `media`) — revisa `tailwind.config` antes de agregar clases `dark:`, no asumas una estrategia sin confirmar cuál está activa.
6. **No mezcles unidades arbitrarias con la escala del tema sin razón.** Usa la escala de espaciado/tamaño del tema (`p-4`, `text-lg`) por defecto; usa valores arbitrarios (`p-[13px]`) solo cuando hay una razón real (ej. alinear con un elemento externo de tamaño fijo), no como atajo para evitar pensar en la escala.

## Flujo de trabajo

### 1. Confirmar el tema antes de escribir markup

Antes de escribir clases nuevas, revisa `tailwind.config` (colores, fuentes, espaciados custom ya definidos) para usar los tokens existentes en vez de reinventar valores. Si el proyecto viene de la skill `frontend-design` con un sistema de tokens ya definido (paleta de 4-6 colores, tipografías de roles), refleja esos tokens en el tema de Tailwind, no los dejes solo como valores sueltos en el markup.

### 2. Escribir el markup con orden de clases consistente

Sigue el orden de `references/orden-clases.md`: layout → espaciado → tipografía → color/fondo → bordes/sombras → estados/responsive/dark mode. Esto hace que dos componentes similares sean fáciles de comparar a simple vista.

### 3. Manejar variantes de componente

Para componentes con variantes (tamaño, color, estado), usa `clsx` para combinaciones simples de clases condicionales, o `class-variance-authority` (cva) cuando el componente tiene varias dimensiones de variante (ej. tamaño + color + estado combinados). Ver `references/variantes-componentes.md`.

### 4. Responsive y dark mode

- Escribe primero el estado mobile sin prefijo, luego agrega los breakpoints necesarios (`sm:`, `md:`, `lg:`, `xl:`) solo donde el diseño realmente cambia.
- Para dark mode, agrega el par `dark:` junto a cada clase de color relevante en la misma línea (no en una regla CSS separada), para que ambos estados del componente sean visibles de un vistazo.

### 5. Verificar antes de dar por terminado

- ¿Hay clases repetidas 3+ veces en el mismo archivo o en archivos similares que deberían extraerse a un componente?
- ¿Hay valores de color/espaciado arbitrarios que deberían estar en el tema en su lugar?
- ¿El markup es legible en mobile antes de aplicar los modificadores de breakpoint?
- ¿Los estados interactivos (`hover:`, `focus:`, `disabled:`) están cubiertos donde corresponde, no solo el estado normal?

## Referencias

- `references/orden-clases.md` — orden consistente de categorías de clases para legibilidad.
- `references/configuracion-tema.md` — cómo extender `tailwind.config` con tokens de diseño (colores, tipografía, espaciado) en vez de valores arbitrarios dispersos.
- `references/cuando-usar-apply.md` — los pocos casos donde `@apply` es la herramienta correcta, y por qué no debe ser el default.
- `references/variantes-componentes.md` — patrones con clsx y class-variance-authority (cva) para componentes con variantes.
