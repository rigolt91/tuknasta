---
name: diseno-base-datos
description: >
  Convierte un documento de requisitos y/o arquitectura (o una idea de proyecto ya descrita) en un documento profesional de diseño de base de datos para proyectos web y/o móviles: elección justificada entre SQL y NoSQL según el caso, diagrama entidad-relación (ER), y descripción completa de tablas/colecciones con sus campos, tipos y relaciones. Usa esta skill SIEMPRE que el usuario pida "diseñar la base de datos", "modelar los datos", "crear el diagrama ER", "definir las tablas", "diseñar el esquema", o cuando ya exista un documento de arquitectura (de la skill arquitectura-solucion) y el siguiente paso natural sea el modelo de datos. Es el tercer eslabón de la cadena idea → requisitos → arquitectura → base de datos → diseño UX → Scrum.
---

# Diseño de Base de Datos

Esta skill toma los requisitos y/o la arquitectura ya definidos y produce el modelo de datos concreto: qué entidades existen, cómo se relacionan, y en qué tipo de base de datos deben vivir. Es el insumo directo para la siguiente etapa (diseño UX/UI, que necesita saber qué datos existen para diseñar las pantallas).

## Cuándo usarla

- Ya existe un documento de requisitos y/o de arquitectura (de las skills anteriores de esta cadena, o proporcionados directamente por el usuario).
- El usuario pide modelar datos, diseñar tablas, crear un diagrama ER, o elegir SQL vs. NoSQL para el proyecto.
- Se está pasando de "cómo se construye el sistema" a "cómo se estructuran sus datos".

No uses esta skill para escribir migraciones o código de ORM real del proyecto (eso es implementación, no diseño) — el output es el modelo conceptual/lógico, no el código final.

## Principio central: SQL vs. NoSQL sin preferencia previa

A diferencia de la skill de arquitectura (que prioriza monolito modular por defecto), aquí **no hay preferencia de partida**. Decide caso por caso, evaluando:

- **Favorece SQL (relacional)** cuando: los datos tienen relaciones claras y consistentes (pedidos-productos-clientes), se requieren transacciones fuertes (pagos, inventario), o el esquema es relativamente estable.
- **Favorece NoSQL (documental/clave-valor)** cuando: los datos son muy variables entre registros (catálogos con atributos dinámicos), se necesita escritura/lectura masiva de baja latencia (mensajería, feeds), o el esquema cambiará mucho durante el desarrollo temprano.
- **Modelo híbrido**: en proyectos con módulos de naturaleza distinta (ej. catálogo de productos en NoSQL + transacciones de venta en SQL) es válido recomendarlo, pero solo si aporta un beneficio real — no compliques la arquitectura por defecto.

Siempre justifica la elección en 2-3 líneas, igual que se justifica el stack en la skill de arquitectura.

**Preservar IDs de etapas anteriores.** Si el documento de requisitos y/o arquitectura usa identificadores (RF-XX, RNF-XX, HU-XX), consérvalos exactamente al referenciarlos aquí — nunca los renumeres. Esto es lo que permite que `revision-calidad` pueda verificar consistencia entre etapas más adelante.

## Flujo de trabajo

### 1. Leer el input

Lee el documento de requisitos y/o arquitectura si el usuario los proporciona (usa `view` si son archivos). Identifica:
- Todas las entidades mencionadas o implícitas (usuarios, roles, productos, pedidos, pagos, etc.)
- Los requisitos no funcionales relevantes (volumen de datos esperado, consistencia, disponibilidad)
- El tipo de base de datos ya sugerido en la arquitectura, si existe (tómalo como punto de partida, pero valida que siga teniendo sentido a nivel de modelo de datos)

Si no hay documentos previos, trabaja a partir de la descripción del usuario y señala los supuestos.

### 2. Identificar entidades y relaciones

Antes de escribir el documento final, enumera mentalmente (o en un borrador) las entidades principales, sus atributos clave, y el tipo de relación entre ellas (uno-a-uno, uno-a-muchos, muchos-a-muchos). Presta atención a:
- Entidades de unión para relaciones muchos-a-muchos (ej. tabla intermedia pedido_producto)
- Campos de auditoría estándar (created_at, updated_at) salvo que el proyecto indique lo contrario
- Claves foráneas y su comportamiento ante borrado (cascada, restricción, etc.) cuando sea relevante

### 3. Preguntas de aclaración (solo si son decisivas)

Usa `ask_user_input_v0` solo si hay ambigüedad que cambie el modelo de forma importante, por ejemplo:
- ¿Un usuario puede tener más de un rol simultáneamente, o un rol único?
- ¿Se necesita historial/versionado de algún dato crítico (ej. precios, estados de pedido)?

Si el documento de requisitos ya lo responde, no preguntes.

### 4. Redactar el documento

Sigue la estructura de `assets/plantilla-base-datos.md`:

1. **Resumen de la decisión** — SQL, NoSQL o híbrido, y por qué, en 1 párrafo.
2. **Diagrama Entidad-Relación** — en sintaxis Mermaid (`erDiagram`), ver `references/guia-diagrama-er.md` para convenciones.
3. **Descripción de entidades** — por cada tabla/colección: nombre, propósito, y tabla de campos (nombre, tipo, restricciones, descripción breve).
4. **Relaciones** — listado explícito de cada relación, su cardinalidad, y comportamiento ante borrado/actualización si aplica.
5. **Consideraciones de diseño** — normalización aplicada (o desnormalización deliberada y por qué), campos calculados/derivados si los hay, e índices recomendados a alto nivel (sin llegar a estrategia de rendimiento detallada).
6. **Supuestos y preguntas abiertas** — igual que en documentos anteriores de la cadena.

### 5. Entregar el archivo

Crea el documento como Markdown con `create_file`, guárdalo en `/mnt/user-data/outputs/`, nómbralo `base-datos-<nombre-proyecto>.md`, y compártelo con `present_files`.

Al terminar, recuerda al usuario que este documento alimenta la siguiente etapa (diseño UX/UI) cuando esa skill esté lista.

## Referencias

- `assets/plantilla-base-datos.md` — estructura exacta del documento.
- `references/guia-diagrama-er.md` — convenciones para el diagrama Mermaid `erDiagram`.
