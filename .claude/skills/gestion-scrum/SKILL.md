---
name: gestion-scrum
description: >
  Convierte las historias de usuario de un documento de requisitos (y opcionalmente arquitectura, base de datos y diseño UX/UI) en un backlog priorizado con estimación en puntos de historia (Fibonacci), división propuesta en sprints, y plantillas de las ceremonias Scrum (planning, daily, review, retrospectiva). Usa esta skill SIEMPRE que el usuario pida "armar el backlog", "planificar sprints", "priorizar historias", "estimar el proyecto", "organizar el trabajo en Scrum", o cuando ya existan los documentos anteriores de la cadena (requisitos, arquitectura, base de datos, diseño UX/UI) y el siguiente paso natural sea la gestión del desarrollo. Es el quinto y último eslabón de la cadena idea → requisitos → arquitectura → base de datos → diseño UX → Scrum.
---

# Gestión Scrum

Esta skill toma todo lo definido en las etapas anteriores y lo convierte en trabajo organizado y ejecutable: backlog priorizado, sprints, y las ceremonias para llevar el proyecto adelante. Es el último eslabón de la cadena — su output es lo que el equipo (o el usuario en solitario) ejecuta día a día.

## Cuándo usarla

- Ya existen historias de usuario (del documento de requisitos, típicamente generado por `analisis-requisitos`), y opcionalmente los documentos de arquitectura, base de datos y/o diseño UX/UI.
- El usuario pide armar el backlog, planificar sprints, estimar el trabajo, u organizar el desarrollo en Scrum.
- Se está pasando de "qué se va a construir y cómo" a "en qué orden y con qué ritmo se construye".

## Principios

1. **Estimación en puntos de historia, escala Fibonacci** (1, 2, 3, 5, 8, 13, 21). No uses horas ni tamaños S/M/L salvo que el usuario lo pida explícitamente para un caso puntual.
2. **Duración de sprint configurable.** Pregunta o infiere la duración según el contexto del proyecto (equipo pequeño/solo → sprints más cortos de 1 semana suelen funcionar mejor; equipos con más coordinación → 2 semanas es más común). No asumas una duración fija sin señal del proyecto.
3. **Priorización con criterio, no solo orden de aparición.** Prioriza combinando valor para el usuario/negocio, dependencias técnicas (ej. autenticación antes que funcionalidades que la requieren) y riesgo (validar lo incierto primero). Explica brevemente el criterio de orden, no solo entregues la lista.
4. **El backlog debe ser accionable**, no una copia literal de las historias de usuario del documento de requisitos — divide historias grandes ("épicas") en historias más pequeñas y estimables si es necesario.
5. **Preservar IDs del documento de requisitos.** Si una historia del backlog corresponde a una HU-XX ya numerada en requisitos, mantén ese mismo ID como referencia (aunque la dividas en sub-historias, ej. HU-03a, HU-03b) — nunca renumeres desde cero. Esto es lo que permite que `revision-calidad` pueda verificar que el backlog cubre todas las historias originales.

## Flujo de trabajo

### 1. Leer el input

Lee el documento de requisitos (historias de usuario, RF/RNF) y, si existen, los documentos de arquitectura, base de datos y diseño UX/UI — estos últimos ayudan a detectar dependencias técnicas reales (ej. "el módulo de pagos depende del modelo de datos de pedidos").

### 2. Preguntas de aclaración (solo si son decisivas)

Usa `ask_user_input_v0` si falta algo que cambie la planificación de forma importante:
- ¿Duración de sprint para este proyecto (si no es obvio por el contexto)?
- ¿Tamaño del equipo o capacidad aproximada por sprint (cuántos puntos puede absorber)?
- ¿Existe una fecha límite o hito importante que deba condicionar la priorización?

Si el contexto ya lo responde (ej. el usuario mencionó que trabaja solo), no preguntes.

### 3. Construir el backlog

- Convierte cada historia de usuario del documento de requisitos en un ítem de backlog. Si una historia es muy grande, divídela en historias más pequeñas (indica que se dividió y por qué).
- Estima cada historia en puntos Fibonacci. Sé consistente: historias de complejidad similar deben tener puntaje similar.
- Ordena el backlog por prioridad, con una columna o nota breve del criterio (valor, dependencia, riesgo).

### 4. Planificar sprints

- Propón una división en sprints, respetando dependencias (no asignes una historia antes que aquello de lo que depende).
- Si no se definió la capacidad del equipo, asume una capacidad razonable y decláralo como supuesto (ej. "se asume una capacidad de X puntos por sprint dado un desarrollador full-time").
- Cada sprint debe tener un objetivo declarado en una frase (el "Sprint Goal"), no solo una lista de tareas.

### 5. Generar plantillas de ceremonias

Incluye plantillas reutilizables (no llenas de contenido específico, sino listas para usar en cada sprint futuro) para:
- **Sprint Planning**: agenda y preguntas guía.
- **Daily Standup**: formato de las 3 preguntas estándar.
- **Sprint Review**: estructura para mostrar lo construido y recoger feedback.
- **Retrospectiva**: formato (ej. Start/Stop/Continue o Mad/Sad/Glad) para que el equipo lo reutilice sprint tras sprint.

Estas plantillas van en `assets/plantillas-ceremonias.md` y se referencian desde el documento principal — no se repiten completas dentro de él.

### 6. Redactar el documento principal

Sigue la estructura de `assets/plantilla-scrum.md`:

1. **Resumen de planificación** — duración de sprint elegida, capacidad asumida, número de sprints estimado para el MVP.
2. **Backlog priorizado** — tabla: ID de historia, descripción breve, puntos, prioridad, criterio de orden.
3. **Plan de sprints** — por cada sprint: objetivo (Sprint Goal), historias asignadas, total de puntos.
4. **Ceremonias** — referencia a `assets/plantillas-ceremonias.md`, con una nota de cuándo usar cada una.
5. **Supuestos y riesgos de planificación** — igual que en documentos anteriores de la cadena, enfocado en supuestos de capacidad/velocidad.

### 7. Entregar los archivos

- Documento principal: `create_file` en `/mnt/user-data/outputs/`, nombrado `scrum-<nombre-proyecto>.md`.
- Si el usuario quiere las plantillas de ceremonias como archivo aparte reutilizable, entrégalas también.
- Comparte con `present_files`.

Este es el último documento de la cadena — al terminar, resume brevemente que el proyecto ya tiene su ciclo completo: requisitos → arquitectura → base de datos → diseño UX/UI → backlog y sprints listos para ejecutar.

## Referencias

- `assets/plantilla-scrum.md` — estructura exacta del documento principal.
- `assets/plantillas-ceremonias.md` — plantillas reutilizables de las 4 ceremonias Scrum.
