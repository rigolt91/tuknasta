---
name: diseno-ux-ui
description: >
  Convierte los documentos de requisitos, arquitectura y/o base de datos (o una idea de proyecto ya descrita) en un documento profesional de diseño UX/UI para proyectos web y/o móviles: flujos de usuario, descripción de pantallas, sistema de diseño básico (color, tipografía, componentes), y estados de UI (carga, error, vacío). Cuando aplique, además genera un prototipo visual navegable como artifact HTML/React de las pantallas clave. Usa esta skill SIEMPRE que el usuario pida "diseñar las pantallas", "hacer los wireframes", "definir el flujo de usuario", "crear el sistema de diseño", "prototipar la app/web", o cuando ya existan documentos anteriores de la cadena (requisitos, arquitectura, base de datos) y el siguiente paso natural sea el diseño de interfaz. Es el cuarto eslabón de la cadena idea → requisitos → arquitectura → base de datos → diseño UX → Scrum.
---

# Diseño UX/UI

Esta skill toma lo definido en las etapas anteriores (qué hace el sistema, qué datos maneja) y define cómo se ve y se navega: flujos, pantallas, sistema de diseño, y estados de la interfaz. Es el insumo directo para la siguiente etapa (gestión Scrum, que convierte todo esto en backlog).

## Cuándo usarla

- Ya existen documentos de requisitos, arquitectura y/o base de datos (de las skills anteriores de esta cadena, o proporcionados por el usuario).
- El usuario pide wireframes, flujos de usuario, sistema de diseño, o un prototipo navegable.
- Se está pasando de "qué hace el sistema y cómo se estructura" a "cómo lo experimenta el usuario".

Esta skill entrega dos cosas complementarias, no una en lugar de la otra:
1. Un **documento Markdown** con flujos, descripción de pantallas, sistema de diseño y estados de UI.
2. Un **prototipo visual navegable** (artifact HTML o React) de las pantallas clave, cuando el alcance lo justifique — no hace falta prototipar cada pantalla del sistema, solo las más representativas del flujo principal.

## Flujo de trabajo

### 1. Leer el input

Lee los documentos disponibles (requisitos, arquitectura, base de datos) para entender: roles de usuario, módulos funcionales, entidades de datos (qué información se muestra/edita en cada pantalla), y cualquier restricción de plataforma (web, móvil, o ambas).

Si no hay documentos previos, trabaja a partir de la descripción del usuario y señala los supuestos.

### 2. Mapear los flujos de usuario

Antes de diseñar pantallas sueltas, identifica los flujos completos por rol: qué hace un usuario desde que entra hasta que completa su objetivo principal (ej. "vendedor: publicar un producto" o "cliente: realizar una compra"). Cada flujo es una secuencia de pantallas/pasos, no una lista de pantallas aisladas.

### 3. Preguntas de aclaración (solo si son decisivas)

Usa `ask_user_input_v0` solo si falta algo que cambie el diseño de forma importante, por ejemplo:
- ¿Hay una identidad visual/marca ya definida (colores, logo) que deba respetarse, o hay libertad de diseño?
- ¿El proyecto es más funcional/utilitario (prioriza velocidad y claridad) o también debe transmitir una personalidad de marca fuerte?

Si esto ya está definido en documentos previos o en la conversación, no preguntes.

**Preservar IDs de etapas anteriores.** Si el documento de requisitos usa identificadores (RF-XX, HU-XX), consérvalos exactamente al referenciar qué historia o requisito cubre cada pantalla o flujo — nunca los renumeres. Esto es lo que permite que `revision-calidad` pueda verificar consistencia entre etapas más adelante.

### 4. Redactar el documento

Sigue la estructura de `assets/plantilla-ux-ui.md`:

1. **Resumen de dirección de diseño** — tono general (funcional, cercano, premium, etc.) en 1 párrafo, y por qué encaja con el proyecto y su usuario.
2. **Flujos de usuario** — por cada rol principal, la secuencia de pantallas/pasos como lista numerada o diagrama Mermaid (`flowchart`).
3. **Sistema de diseño básico** — paleta de color (4-6 colores con su uso), tipografía (roles: display, cuerpo, utilitaria), y componentes base reutilizables (botones, inputs, cards, etc.) con sus estados (normal, hover, activo, deshabilitado).
4. **Descripción de pantallas** — por cada pantalla clave: propósito, elementos que contiene, y qué acción principal ofrece.
5. **Estados de UI** — cómo se ve cada pantalla relevante en carga, error, y vacío (sin datos), siguiendo el enfoque de "la vacío es una invitación a actuar, el error nunca es vago sobre qué pasó".
6. **Supuestos y preguntas abiertas** — igual que en documentos anteriores de la cadena.

### 5. Generar el prototipo visual

Cuando el alcance lo amerite (proyecto con interfaz visual relevante, no solo APIs internas), construye un artifact navegable de las 2-4 pantallas más representativas del flujo principal.

**Antes de construir el prototipo, consulta `/mnt/skills/public/frontend-design/SKILL.md`** y sigue su proceso de brainstorm → plan de tokens (color/tipografía/layout/elemento distintivo) → crítica → construcción. No repitas los defaults genéricos de IA que esa guía señala (fondo crema con acento terracota, fondo negro con acento ácido, estilo periódico). El sistema de diseño que definiste en el paso anterior debe ser la base de tokens para el prototipo — mantén consistencia entre el documento y el artifact.

Usa React o HTML según la complejidad (ver criterios de la skill frontend-design y las reglas generales de artifacts: Tailwind core, sin props requeridas, etc.).

### 6. Entregar los archivos

- El documento Markdown: `create_file` en `/mnt/user-data/outputs/`, nombrado `diseno-ux-<nombre-proyecto>.md`.
- El prototipo (si se generó): como artifact React/HTML.
- Comparte ambos con `present_files` cuando correspondan a archivos de salida.

Al terminar, recuerda al usuario que este documento alimenta la siguiente etapa (gestión Scrum) cuando esa skill esté lista.

## Referencias

- `assets/plantilla-ux-ui.md` — estructura exacta del documento.
- `/mnt/skills/public/frontend-design/SKILL.md` — guía obligatoria a consultar antes de construir cualquier prototipo visual.
