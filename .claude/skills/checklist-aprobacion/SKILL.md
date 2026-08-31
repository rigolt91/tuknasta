---
name: checklist-aprobacion
description: >
  Genera un resumen técnico de aprobación por etapa (requisitos, arquitectura, base de datos, diseño UX/UI, o Scrum) para uso interno del desarrollador: qué se decidió, qué queda pendiente de confirmar, y qué implica aprobar esta etapa antes de pasar a la siguiente. No aprueba nada por sí misma — solo prepara el material para que el usuario tome la decisión. Usa esta skill SIEMPRE que el usuario pida "preparar la aprobación", "resumen para decidir", "¿qué falta antes de avanzar?", "checklist de aprobación", o cuando haya terminado una etapa de la cadena idea → requisitos → arquitectura → base de datos → diseño UX → Scrum y quiera confirmar antes de continuar con la siguiente.
---

# Checklist de Aprobación

Esta skill prepara el material que el usuario necesita para decidir, de forma informada, si una etapa está lista para darse por cerrada y pasar a la siguiente. No sustituye el criterio del usuario ni aprueba nada — solo organiza la decisión.

## Cuándo usarla

- Se completó una etapa de la cadena (requisitos, arquitectura, base de datos, diseño UX/UI, o Scrum) y el usuario quiere confirmar antes de avanzar.
- El usuario pide explícitamente un resumen de aprobación o un checklist de qué falta.

Esta skill es complementaria a `revision-calidad`, no un reemplazo: la revisión de calidad busca *problemas* en el documento; esta skill resume el *estado de la decisión* (qué se decidió, qué implica, qué falta confirmar) para que avanzar sea una elección consciente, no automática. Si el usuario aún no corrió `revision-calidad` sobre el documento y hay señales de que podría tener problemas de completitud, sugiere hacerlo primero — pero sin bloquear ni insistir si el usuario prefiere seguir sin eso.

## Principio central: preparar la decisión, no tomarla

Esta skill nunca dice "aprobado" o "rechazado". Su output es siempre un resumen + checklist para que el usuario firme su propia decisión. Usa lenguaje como "queda pendiente confirmar" o "esto implica que ya no se puede cambiar fácilmente X", nunca "se aprueba" o "no se aprueba".

## Flujo de trabajo

### 1. Identificar la etapa y leer el documento

Determina qué etapa se está cerrando (requisitos, arquitectura, base de datos, UX/UI, o Scrum) y lee el documento completo. Si existe también un informe de `revision-calidad` sobre este documento, incorpóralo — no repitas ese trabajo, resume sus hallazgos de mayor severidad en este documento en vez de re-auditar desde cero.

### 2. Resumir las decisiones clave de la etapa

Extrae, en lenguaje técnico directo, las 4-6 decisiones más importantes que este documento fija (ej. en arquitectura: "monolito modular en Node.js + PostgreSQL"; en base de datos: "modelo relacional con 8 entidades principales"). Estas son las decisiones que se vuelven más costosas de cambiar una vez que se avanza a la siguiente etapa.

### 3. Señalar las implicaciones de avanzar

Por cada decisión clave, indica brevemente qué tan reversible es después de pasar a la siguiente etapa (ej. "cambiar el motor de base de datos después de este punto implica rehacer gran parte del diseño de la capa de datos en la siguiente etapa"). Esto ayuda al usuario a calibrar cuánta atención darle antes de seguir.

### 4. Listar lo pendiente de confirmar

Reúne, del propio documento, todo lo que quedó como "supuesto" o "pregunta abierta" (estas secciones existen en las plantillas de todas las skills de la cadena). Preséntalo como una lista clara de pendientes, no como un detalle menor.

### 5. Redactar el documento

Sigue la estructura de `assets/plantilla-checklist-aprobacion.md`:

1. **Etapa y documento revisado** — cuál y de qué proyecto.
2. **Decisiones clave de esta etapa** — lista de 4-6 decisiones con su implicación de reversibilidad.
3. **Hallazgos relevantes de revisión de calidad** — si existe ese informe, resumen de los de severidad Alta/Media (omitir esta sección si no se corrió esa skill).
4. **Pendientes de confirmar** — lista de supuestos y preguntas abiertas del documento.
5. **Checklist final para decidir** — lista de preguntas tipo sí/no que el usuario debería poder responder antes de avanzar (ej. "¿Los supuestos listados son aceptables o necesitan confirmarse con el cliente primero?").

### 6. Entregar el archivo

Crea el documento como Markdown con `create_file`, guárdalo en `/mnt/user-data/outputs/`, nómbralo `aprobacion-<etapa>-<nombre-proyecto>.md`, y compártelo con `present_files`.

## Referencias

- `assets/plantilla-checklist-aprobacion.md` — estructura exacta del documento.
