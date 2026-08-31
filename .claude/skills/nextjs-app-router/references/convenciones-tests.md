# Convenciones de Tests — Next.js App Router

## Framework a usar

Detecta cuál usa el proyecto (revisa `package.json`): Vitest o Jest, ambos combinados con React Testing Library. Si el proyecto es nuevo, Vitest es la opción recomendada por defecto (arranque más rápido, config más simple con Next.js) salvo que el usuario prefiera Jest.

## Qué testear y cómo

### Server Components (async, sin interactividad)

No necesitan un test de "renderiza correctamente" trivial. Enfócate en:
- Que la función de fetching de datos (extraída a `lib/data/`) devuelva/transforme los datos correctamente, testeada de forma aislada (mockeando `fetch`).
- Casos de error del fetching (ej. la API externa responde 500 → la función lanza o devuelve el estado esperado).

```ts
// lib/data/products.test.ts
import { getProducts } from './products';

it('lanza un error si la API responde con fallo', async () => {
  global.fetch = vi.fn().mockResolvedValue({ ok: false });
  await expect(getProducts()).rejects.toThrow();
});
```

### Client Components (interactivos)

Usa React Testing Library + `userEvent` para simular interacción real, no `fireEvent` de bajo nivel salvo necesidad puntual.

```tsx
// components/ProductForm.test.tsx
import { render, screen } from '@testing-library/react';
import userEvent from '@testing-library/user-event';
import { ProductForm } from './ProductForm';

it('muestra un error si el nombre está vacío', async () => {
  render(<ProductForm />);
  await userEvent.click(screen.getByRole('button', { name: /guardar/i }));
  expect(await screen.findByText(/el nombre es requerido/i)).toBeInTheDocument();
});
```

### Server Actions

Extrae la lógica de validación/transformación a una función testeable por separado de la Server Action en sí (que solo orquesta `formData` → función → respuesta). Testea esa función directamente, sin necesidad de simular el ciclo completo de request de Next.js.

```ts
// lib/actions/products.ts
export function parseProductInput(formData: FormData) {
  return { name: formData.get('name'), price: Number(formData.get('price')) };
}

'use server';
export async function createProduct(formData: FormData) {
  const data = parseProductInput(formData);
  // ...
}
```

```ts
// lib/actions/products.test.ts
it('convierte el precio a número', () => {
  const fd = new FormData();
  fd.set('name', 'Silla');
  fd.set('price', '49.90');
  expect(parseProductInput(fd)).toEqual({ name: 'Silla', price: 49.9 });
});
```

## Qué NO testear

- No testees que Next.js renderiza el HTML correctamente (eso es responsabilidad del framework, no de tu código).
- No repliques tests end-to-end completos con RTL — para flujos de varias pantallas, considera Playwright si el proyecto lo necesita, pero eso está fuera del alcance de esta skill.
