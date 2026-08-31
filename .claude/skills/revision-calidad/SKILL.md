---
name: revision-calidad
description: >
  Audita cualquier documento producido en la cadena de desarrollo (requisitos, arquitectura, base de datos, diseño UX/UI, o plan Scrum) y genera un informe de hallazgos en Markdown: problemas de completitud, inconsistencias con etapas anteriores, ambigüedades, y sugerencias de mejora. Nunca bloquea el avance — solo advierte, la decisión de continuar siempre es del usuario. Usa esta skill SIEMPRE que el usuario pida "revisar", "auditar", "validar", "chequear calidad", "¿esto está bien?", o antes de pasar de una etapa a la siguiente de la cadena idea → requisitos → arquitectura → base de datos → diseño UX → Scrum, cuando el usuario quiera un control de calidad intermedio.
---

# Revisión de Calidad

Esta skill es transversal: se aplica sobre el output de cualquiera de las otras skills de la cadena (`analisis-requisitos`, `arquitectura-solucion`, `diseno-base-datos`, `diseno-ux-ui`, `gestion-scrum`) para detectar problemas antes de avanzar a la siguiente etapa.

## Cuándo usarla

- El usuario pide revisar, auditar o validar un documento ya generado.
- El usuario pregunta directamente si un documento "está bien" o "está completo".
- Se está por pasar de una etapa a la siguiente y el usuario quiere un checkpoint de calidad.

## Principio central: advertir, no bloquear

Esta skill **nunca decide por el usuario**. Su función es señalar problemas con claridad y honestidad, incluyendo su severidad, pero la decisión de avanzar, corregir, o ignorar una advertencia es siempre del usuario. No uses lenguaje que suene a veto ("no puedes avanzar", "esto está prohibido") — usa lenguaje de riesgo informado ("esto podría causar X más adelante si no se corrige").

## Flujo de trabajo

### 1. Identificar qué tipo de documento se está revisando

Determina a cuál de las 5 etapas corresponde el documento (requisitos, arquitectura, base de datos, UX/UI, o Scrum) para aplicar el checklist correcto de `references/checklists-por-etapa.md`. Si el usuario no lo aclara, infiérelo por el contenido y confírmalo brevemente si hay ambigüedad real.

### 2. Revisar completitud interna

Usando el checklist correspondiente a la etapa, verifica que el documento tenga todas las secciones esperadas y que cada una esté sustancialmente desarrollada (no solo un placeholder o una frase genérica).

### 3. Revisar consistencia con etapas anteriores (si están disponibles)

Si el usuario proporciona también los documentos de etapas previas, verifica cruces obvios, por ejemplo:
- ¿Toda entidad del diagrama ER corresponde a algo mencionado en requisitos o arquitectura?
- ¿Los componentes de la arquitectura cubren todos los módulos funcionales de los requisitos?
- ¿Las pantallas del diseño UX/UI reflejan los roles de usuario definidos en requisitos?
- ¿El backlog de Scrum incluye todas las historias de usuario relevantes del documento de requisitos?

No inventes inconsistencias — si no tienes el documento de la etapa anterior, dilo explícitamente y limita la revisión a completitud interna.

### 4. Detectar ambigüedades y vaguedad

Señala frases vagas que deberían ser específicas (ej. "el sistema debe ser rápido" sin métrica, "algunos usuarios" sin definir el rol exacto), datos faltantes que se dejaron como supuesto sin marcarlo como tal, y contradicciones internas dentro del mismo documento.

### 5. Redactar el informe

Sigue la estructura de `assets/plantilla-informe-revision.md`:

1. **Resumen** — 1 párrafo: estado general del documento (sólido / con observaciones menores / con observaciones importantes) y qué etapa se revisó.
2. **Hallazgos** — tabla con: severidad (Alta/Media/Baja), descripción del problema, ubicación (sección del documento), sugerencia de corrección.
3. **Verificación de consistencia** — solo si se compararon etapas, con lo que sí cruza bien y lo que no.
4. **Checklist de completitud** — ✅/⚠️/❌ por cada sección esperada según `references/checklists-por-etapa.md`.
5. **Conclusión** — nota clara de que esto es una guía para decidir, no un bloqueo: el usuario decide si corrige antes de avanzar o continúa como está.

Clasifica la severidad con criterio:
- **Alta**: podría causar retrabajo significativo más adelante (ej. una entidad de datos que no aparece en ningún requisito, un requisito no funcional crítico sin definir).
- **Media**: afecta claridad o precisión pero no bloquea el avance técnico (ej. una historia de usuario sin criterio de aceptación).
- **Baja**: mejora de forma o estilo (ej. redacción poco clara en una sección).

### 6. Entregar el archivo

Crea el informe como Markdown con `create_file`, guárdalo en `/mnt/user-data/outputs/`, nómbralo `revision-<nombre-documento>.md`, y compártelo con `present_files`.

## Referencias

- `assets/plantilla-informe-revision.md` — estructura exacta del informe.
- `references/checklists-por-etapa.md` — checklist de completitud específico para cada una de las 5 etapas de la cadena.
