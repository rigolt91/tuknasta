---
name: arquitectura-solucion
description: >
  Convierte un documento de requisitos (o una idea de proyecto ya descrita) en un documento profesional de arquitectura de solución para proyectos web y/o móviles: patrones arquitectónicos, stack tecnológico concreto justificado, diagrama de componentes, diseño de API de alto nivel, y diagrama de despliegue. Prioriza monolito modular para MVPs de equipos pequeños, mientras el proyecto no justifique microservicios. Usa esta skill SIEMPRE que el usuario pida "definir la arquitectura", "elegir el stack", "diseñar los componentes", "diseñar la API", o cuando ya exista un documento de requisitos (de la skill analisis-requisitos) y el siguiente paso natural sea pasar a diseño técnico. Es el segundo eslabón de la cadena idea → requisitos → arquitectura → base de datos → diseño UX → Scrum.
---

# Arquitectura de Solución

Esta skill toma el documento de requisitos (o una idea de proyecto suficientemente descrita) y define cómo se va a construir técnicamente: patrones, stack, componentes, API y despliegue. Es el insumo directo para la siguiente etapa (diseño de base de datos).

## Cuándo usarla

- Ya existe un documento de requisitos (generado por la skill `analisis-requisitos` o proporcionado por el usuario).
- El usuario pide elegir stack, definir arquitectura, diseñar componentes o diseñar la API.
- Se está pasando de la fase de "qué se construye" a "cómo se construye".

No uses esta skill para decisiones de base de datos a nivel de esquema/modelo de datos (eso corresponde a la siguiente skill de la cadena) — aquí solo se decide qué tipo de base de datos conviene (relacional/no relacional) y por qué, no las tablas o colecciones.

## Principios que debe seguir siempre

1. **Monolito modular por defecto.** Para MVPs y equipos pequeños, prioriza un monolito modular (módulos bien separados dentro de una sola aplicación/despliegue) en vez de microservicios. Solo recomienda microservicios si hay una razón concreta (escalabilidad diferencial extrema entre módulos, equipos grandes e independientes, requisitos de despliegue independiente). Si el proyecto no lo justifica, dilo explícitamente: "se descarta microservicios porque..." para dejar constancia de la decisión.
2. **Justificar el stack, no solo nombrarlo.** Cada tecnología elegida debe llevar una razón breve (madurez, curva de aprendizaje del equipo, costo, ecosistema, lo que aplique). Si hay una alternativa razonable, mencionarla en una línea.
3. **Pensar en Cuba/mercados con restricciones si aplica.** Si el contexto del proyecto lo amerita (ej. restricciones de pago, hosting, conectividad — como en proyectos previos del usuario), tenlo en cuenta al elegir servicios de terceros (pagos, hosting, mensajería) y anótalo como una decisión condicionada.
4. **Consistencia entre web y móvil.** Si el proyecto tiene web + app móvil, define claramente qué comparten (API, lógica de negocio, autenticación) y qué es específico de cada plataforma.
5. **Preservar IDs de la etapa anterior.** Si el documento de requisitos usa identificadores (RF-XX, RNF-XX, HU-XX), consérvalos exactamente al referenciarlos aquí — nunca los renumeres. Esto es lo que permite que `revision-calidad` pueda verificar consistencia entre etapas más adelante.

## Flujo de trabajo

### 1. Leer el input

Si el usuario da un documento de requisitos, léelo completo (usa `view` si es un archivo subido). Identifica: módulos funcionales, roles de usuario, requisitos no funcionales (especialmente rendimiento, escalabilidad, seguridad) y cualquier restricción ya declarada (presupuesto, plataformas, integraciones obligatorias).

Si no hay documento y el usuario solo describe la idea, trabaja con esa descripción, pero señala en el documento final qué quedó como supuesto.

### 2. Preguntas de aclaración (solo si son decisivas)

Usa `ask_user_input_v0` únicamente si falta algo que cambiaría la arquitectura de forma importante, por ejemplo:
- ¿Hay preferencia o restricción de lenguaje/framework por el equipo actual?
- ¿Presupuesto de hosting/infraestructura (gratuito/bajo costo vs. sin restricción)?
- ¿Se espera alta concurrencia desde el día uno, o el tráfico crecerá gradualmente?

Si el documento de requisitos ya responde esto, no preguntes.

### 3. Redactar el documento de arquitectura

Sigue la estructura de `assets/plantilla-arquitectura.md`:

1. **Resumen de la decisión arquitectónica** — patrón elegido (monolito modular u otro) y por qué, en 1 párrafo.
2. **Stack tecnológico** — backend, frontend web, app móvil, base de datos (tipo, no esquema), autenticación, hosting/infraestructura, servicios de terceros. Cada uno con una línea de justificación.
3. **Componentes del sistema** — lista de módulos/componentes principales y su responsabilidad, más un diagrama Mermaid de componentes (ver `references/guia-diagramas.md`).
4. **Diseño de API (alto nivel)** — recursos principales y sus endpoints clave (no el CRUD completo, solo lo estructuralmente relevante: autenticación, recursos core, webhooks/integraciones si aplica). Usa un formato tabla: método, ruta, propósito, rol que puede acceder.
5. **Diagrama de despliegue** — cómo se despliega cada pieza (servidor, base de datos, CDN, apps móviles en tiendas), en diagrama Mermaid.
6. **Decisiones descartadas** — alternativas consideradas y por qué no se eligieron (ej. "se descarta microservicios porque...", "se descarta NoSQL porque...").
7. **Riesgos técnicos y supuestos** — igual que en el documento de requisitos, pero enfocado en riesgos de la arquitectura elegida.

### 4. Diagramas

Genera los diagramas de componentes y despliegue en sintaxis Mermaid dentro del propio Markdown (bloques ```mermaid). Consulta `references/guia-diagramas.md` para las convenciones de estilo a seguir (tipos de diagrama según el caso, nivel de detalle).

### 5. Entregar el archivo

Crea el documento como Markdown con `create_file`, guárdalo en `/mnt/user-data/outputs/`, nómbralo `arquitectura-<nombre-proyecto>.md`, y compártelo con `present_files`.

Al terminar, recuerda al usuario que este documento alimenta la siguiente etapa (diseño de base de datos) cuando esa skill esté lista.

## Referencias

- `assets/plantilla-arquitectura.md` — estructura exacta del documento.
- `references/guia-diagramas.md` — convenciones para los diagramas Mermaid de componentes y despliegue.
