# Cliente Singleton — Prisma

## El problema

`PrismaClient` abre un pool de conexiones a la base de datos. Instanciarlo en cada request o función agota las conexiones disponibles rápidamente. Siempre debe existir una única instancia reutilizada en toda la app.

## Backend Node genérico (Express, Nest, u otro proceso de larga duración)

```ts
// lib/prisma.ts
import { PrismaClient } from '@prisma/client';

export const prisma = new PrismaClient();
```

En un proceso de servidor tradicional que no se reinicia por cada request, una instancia simple exportada desde un módulo es suficiente — Node.js cachea el módulo y todos los imports reciben la misma instancia.

## Next.js (caso especial por hot reload en desarrollo)

En desarrollo, Next.js recarga módulos frecuentemente, lo que puede crear múltiples instancias de `PrismaClient` si no se maneja explícitamente. El patrón estándar usa una variable global:

```ts
// lib/prisma.ts
import { PrismaClient } from '@prisma/client';

const globalForPrisma = globalThis as unknown as { prisma: PrismaClient };

export const prisma = globalForPrisma.prisma ?? new PrismaClient();

if (process.env.NODE_ENV !== 'production') {
  globalForPrisma.prisma = prisma;
}
```

- En producción este patrón es inofensivo (el proceso no recarga módulos en caliente), pero sigue usándose igual para mantener un solo archivo válido en ambos entornos.
- Importa siempre `prisma` desde este módulo (`import { prisma } from '@/lib/prisma'`), nunca instancies `new PrismaClient()` directamente en un Route Handler, Server Action o Server Component.

## Entornos serverless (si aplica)

Si el proyecto se despliega en un entorno serverless con muchas invocaciones concurrentes (ej. Vercel con funciones serverless, no Edge), considera Prisma Accelerate o un pool de conexiones externo (ej. PgBouncer) si empiezas a ver errores de "too many connections" — esto es una optimización de infraestructura, no algo que se resuelva solo con el patrón de código de arriba. Señálalo como una consideración a evaluar si el proyecto crece a ese punto, sin implementarlo de forma preventiva sin necesidad real.
