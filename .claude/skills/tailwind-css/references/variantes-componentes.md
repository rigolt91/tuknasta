# Variantes de Componentes — clsx y class-variance-authority (cva)

## clsx — combinaciones simples de clases condicionales

Úsalo cuando el componente tiene una o dos condiciones simples, sin múltiples dimensiones de variante combinadas.

```tsx
import clsx from 'clsx';

function Alert({ variant, children }: { variant: 'success' | 'error'; children: React.ReactNode }) {
  return (
    <div
      className={clsx(
        'p-4 rounded-lg border',
        variant === 'success' && 'bg-green-50 border-green-200 text-green-800',
        variant === 'error' && 'bg-red-50 border-red-200 text-red-800'
      )}
    >
      {children}
    </div>
  );
}
```

## class-variance-authority (cva) — múltiples dimensiones de variante

Úsalo cuando el componente combina varias dimensiones (ej. tamaño + color + estado) — cva mantiene esas combinaciones organizadas y tipadas, evitando un árbol de condicionales anidados con clsx.

```tsx
import { cva, type VariantProps } from 'class-variance-authority';

const button = cva('inline-flex items-center justify-center rounded-lg font-medium transition-colors', {
  variants: {
    variant: {
      primary: 'bg-primary-600 text-white hover:bg-primary-700',
      secondary: 'bg-gray-100 text-gray-900 hover:bg-gray-200',
      ghost: 'bg-transparent hover:bg-gray-100',
    },
    size: {
      sm: 'px-3 py-1.5 text-sm',
      md: 'px-4 py-2 text-base',
      lg: 'px-6 py-3 text-lg',
    },
  },
  defaultVariants: {
    variant: 'primary',
    size: 'md',
  },
});

type ButtonProps = React.ButtonHTMLAttributes<HTMLButtonElement> & VariantProps<typeof button>;

function Button({ variant, size, className, ...props }: ButtonProps) {
  return <button className={clsx(button({ variant, size }), className)} {...props} />;
}
```

```tsx
<Button variant="secondary" size="sm">Cancelar</Button>
<Button variant="primary" size="lg">Confirmar</Button>
```

## Combinar cva con clases custom del consumidor

Siempre permite que el componente reciba una prop `className` adicional y la combine (no la reemplace) con las clases generadas por cva, para que el consumidor del componente pueda ajustar casos puntuales sin duplicar todo el componente:

```tsx
<Button className="w-full">Guardar</Button> // combina con las clases de variant/size ya definidas
```

## Cuándo NO usar cva

Para un componente con una sola variante simple (ej. un badge con 2 colores posibles), `clsx` directo es más simple y suficiente — no introduzcas cva para casos donde agrega ceremonia sin beneficio real. Usa cva cuando el número de combinaciones (variant × size × state) empieza a ser difícil de mantener con condicionales sueltos.
