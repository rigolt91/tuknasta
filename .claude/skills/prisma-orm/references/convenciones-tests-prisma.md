# Convenciones de Tests — Prisma

## Estrategia general

Prefiere probar contra una base de datos de test real (no un mock completo del cliente) para la mayoría de los casos — Prisma genera SQL real y un mock no detecta errores de constraint, tipos, o relaciones mal definidas. Reserva los mocks para lógica de negocio que no depende del resultado exacto de la consulta.

## Base de datos de test

- **SQLite en memoria**: rápida para tests unitarios/de integración ligeros, pero ten en cuenta que no soporta todos los tipos/features que Postgres/MySQL sí (ej. algunos tipos de columna, funciones específicas) — si el proyecto usa features específicas del motor de producción, esto puede dar falsos positivos.
- **Instancia real de test (Postgres/MySQL en Docker)**: más fiel al comportamiento de producción, recomendado si el proyecto ya usa Docker para desarrollo. Ejecuta las migraciones contra esta base antes de correr los tests (`prisma migrate deploy` apuntando a la URL de test).

Limpia el estado entre tests (transacción revertida al final de cada test, o `truncate` de tablas) para que no haya dependencia de orden entre ellos.

## Ejemplo (Vitest, con base de datos de test real)

```ts
import { beforeEach, afterAll, it, expect } from 'vitest';
import { prisma } from '@/lib/prisma';

beforeEach(async () => {
  await prisma.orderItem.deleteMany();
  await prisma.order.deleteMany();
  await prisma.product.deleteMany();
});

afterAll(async () => {
  await prisma.$disconnect();
});

it('crea un producto correctamente', async () => {
  const product = await prisma.product.create({
    data: { name: 'Silla', price: 49.9, userId: 'user-1' },
  });

  expect(product.name).toBe('Silla');
});

it('rechaza un producto duplicado por constraint único', async () => {
  await prisma.product.create({ data: { name: 'Silla', price: 49.9, userId: 'user-1' } });

  await expect(
    prisma.product.create({ data: { name: 'Silla', price: 39.9, userId: 'user-1' } })
  ).rejects.toThrow();
});
```

## Mocking para lógica que no depende del resultado exacto de Prisma

Cuando testeas una función que orquesta lógica de negocio y solo necesitas verificar que llamó a Prisma con los argumentos correctos (no el resultado real de la base de datos), mockea el cliente:

```ts
vi.mock('@/lib/prisma', () => ({
  prisma: {
    product: {
      create: vi.fn().mockResolvedValue({ id: '1', name: 'Silla' }),
    },
  },
}));
```

Usa esto con moderación — si abusas del mock, terminas probando que tu código llama a Prisma como esperabas, no que el comportamiento real (constraints, relaciones) funciona.
