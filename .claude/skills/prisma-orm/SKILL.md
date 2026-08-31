---
name: prisma-orm
description: >
  Diseña e implementa la capa de datos con Prisma ORM en proyectos Node.js/TypeScript, tanto dentro de Next.js (Route Handlers, Server Actions, Server Components) como en un backend Node genérico (Express, Nest, u otro): definición del schema, migraciones, cliente tipado, relaciones, transacciones, y patrones de consulta eficientes. Usa esta skill SIEMPRE que el usuario pida definir un modelo Prisma, escribir una migración, hacer una consulta con `prisma.*`, o cualquier tarea de capa de datos en un proyecto que use Prisma como ORM.
---

# Prisma ORM

Esta skill cubre el diseño y uso de Prisma como capa de datos, independiente del framework que lo consuma — aplica igual si el proyecto es Next.js full-stack (Route Handlers/Server Actions) o un backend Node genérico. Es el equivalente, para el ecosistema Node/TypeScript, a lo que `laravel-api-rest`/`patrones-eloquent` son para Laravel.

Si llegas a esta skill dentro de la cadena de análisis (idea → requisitos → arquitectura → base de datos → diseño UX/UI → Scrum), usa el documento de diseño de base de datos como fuente de verdad para modelos, campos y relaciones — el `schema.prisma` debe ser fiel a ese diseño, no reinterpretarlo. Si el proyecto usa Next.js, esta skill se complementa con `nextjs-app-router`/`nextjs-avanzado` (esos cubren dónde y cómo se invoca el cliente de Prisma; esta cubre el modelo de datos en sí).

## Principios que debe seguir siempre

1. **El `schema.prisma` es la fuente de verdad del modelo de datos.** Todo cambio de esquema pasa primero por el schema y una migración generada (`prisma migrate dev`), nunca se edita la base de datos a mano por fuera de Prisma.
2. **Un único `PrismaClient` reutilizado**, nunca instanciado en cada request/función. En Next.js, esto requiere un patrón específico para evitar múltiples instancias en desarrollo (hot reload) — ver `references/cliente-singleton.md`.
3. **Relaciones explícitas en el schema**, con el nombre de campo de relación reflejando el dominio (`author`, no `user2`), y `onDelete`/`onUpdate` declarados conscientemente, no dejados en el default sin pensarlo.
4. **`select`/`include` explícitos** en consultas que no necesitan el registro completo o sus relaciones — no traigas más datos de los que la función que llama realmente necesita.
5. **Transacciones explícitas** (`prisma.$transaction`) para cualquier operación que escriba en más de un modelo y deba ser atómica.
6. **Migraciones nunca editadas a mano después de aplicadas.** Si algo salió mal en una migración ya aplicada en otros entornos, se corrige con una migración nueva, no editando el archivo SQL generado previamente.
7. **Validación de entrada separada del schema de Prisma.** El schema define la forma de los datos en la base, no las reglas de validación de un formulario/endpoint — usa una librería de validación (Zod es la más común en el ecosistema TypeScript/Next.js) para eso, no intentes forzar esa responsabilidad dentro de Prisma.

## Flujo de trabajo

### 1. Entender qué se está modelando

Si hay un documento de diseño de base de datos previo, léelo y refleja exactamente las entidades, campos y relaciones ahí definidas en el `schema.prisma`. Si no lo hay, trabaja con lo que el usuario describe.

### 2. Revisar el schema existente antes de modificarlo

Antes de agregar un modelo o campo nuevo, revisa `schema.prisma` completo para mantener consistencia de convenciones (nombres en camelCase para campos, PascalCase para modelos, nombres de relación ya establecidos).

### 3. Definir o modificar el schema

```prisma
model Product {
  id        String   @id @default(cuid())
  name      String
  price     Decimal  @db.Decimal(10, 2)
  userId    String
  user      User     @relation(fields: [userId], references: [id], onDelete: Cascade)
  createdAt DateTime @default(now())
  updatedAt DateTime @updatedAt

  @@index([userId])
}
```

- Usa `cuid()` o `uuid()` para IDs (no autoincrementales) si el proyecto podría necesitar IDs no adivinables o generados fuera de la base — decide conscientemente, no por default automático.
- Declara índices (`@@index`) en campos usados frecuentemente en `where`/`orderBy`, especialmente claves foráneas usadas en filtros.

### 4. Generar la migración

```bash
npx prisma migrate dev --name add_product_model
```

- Revisa el SQL generado antes de confirmar que es correcto, especialmente en cambios que podrían perder datos (renombrar/eliminar columnas) — Prisma advierte sobre esto, no lo ignores.
- En producción, usa `prisma migrate deploy` (no `dev`), que no genera migraciones nuevas, solo aplica las ya creadas.

### 5. Escribir las consultas

Usa el cliente tipado de Prisma con `select`/`include` explícitos y evita el patrón N+1 igual que en cualquier ORM:

```ts
// Bien: una sola consulta con la relación necesaria
const products = await prisma.product.findMany({
  where: { userId },
  select: { id: true, name: true, price: true },
});

// Evitar: consultar la relación dentro de un loop
```

Consulta `references/patrones-consultas.md` para filtros, paginación, agregaciones y transacciones.

### 6. Escribir tests

Usa el framework de testing que ya tenga el proyecto (Vitest/Jest). Para tests que tocan la base de datos, usa una base de datos de test real (SQLite en memoria o una instancia de test de Postgres/MySQL) en vez de mockear Prisma por completo salvo en tests unitarios de lógica que no dependen del resultado exacto de la consulta. Consulta `references/convenciones-tests-prisma.md`.

### 7. Verificar antes de dar por terminado

- Corre `prisma generate` si cambiaste el schema, para que el cliente tipado quede actualizado.
- Verifica que no haya consultas dentro de loops que deberían ser una sola consulta con `findMany`/`in`.
- Confirma que las transacciones cubran todas las escrituras que deben ser atómicas juntas.

## Referencias

- `references/cliente-singleton.md` — patrón de instancia única de `PrismaClient`, especialmente el caso especial de Next.js en desarrollo.
- `references/patrones-consultas.md` — filtros, paginación, agregaciones, transacciones, y relaciones avanzadas (muchos-a-muchos explícito, auto-relaciones).
- `references/convenciones-tests-prisma.md` — estrategia de testing con base de datos real de test vs. mocks.
- `assets/ejemplo-modelo-completo.md` — ejemplo de referencia de un modelo completo (schema → migración → consultas CRUD → tests).
