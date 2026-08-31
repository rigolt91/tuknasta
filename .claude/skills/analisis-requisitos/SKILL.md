---
name: analisis-requisitos
description: >
  Convierte la idea inicial de un cliente (descripción libre, transcripción de reunión, notas sueltas o cualquier mezcla de estas) en un documento profesional de requisitos de software para proyectos web y/o móviles, incluyendo alcance del MVP, requisitos funcionales y no funcionales, historias de usuario en formato Scrum, y riesgos iniciales. Usa esta skill SIEMPRE que el usuario describa una idea de proyecto nueva, comparta notas de una reunión con un cliente, pida "levantar requisitos", "documentar el alcance", "definir el MVP", "escribir historias de usuario", o en general esté en la fase de arranque de un proyecto de software antes de pasar a diseño o arquitectura. Es el primer eslabón de la cadena idea → requisitos → arquitectura → base de datos → diseño UX → Scrum.
---

# Análisis de Requisitos

Esta skill convierte la idea de un cliente en un documento de requisitos profesional y accionable, que sirve como insumo directo para la siguiente etapa (arquitectura de solución).

## Cuándo usarla

- El usuario pega una descripción libre de lo que un cliente quiere ("un cliente me pidió una app que...").
- El usuario comparte notas de reunión, audio transcrito, o mensajes de WhatsApp con la idea.
- El usuario pide explícitamente levantar requisitos, definir el MVP, o escribir historias de usuario.
- Se está iniciando un proyecto nuevo y aún no existe documentación formal.

No uses esta skill si el usuario ya tiene un documento de requisitos y solo pide ajustarlo puntualmente (en ese caso, edítalo directamente sin rehacer todo el proceso).

## Flujo de trabajo

### 1. Recolectar y entender la idea

Lee todo el material que el usuario proporcione (texto libre, notas, transcripciones). La entrada nunca tiene formato fijo — puede ser un párrafo desordenado o una lista de puntos. Tu trabajo es extraer la señal:

- ¿Quién es el cliente/usuario final? ¿Qué problema real quiere resolver?
- ¿Qué funcionalidades menciona explícitamente?
- ¿Qué funcionalidades están implícitas pero no dichas (ej. "vender productos" implica catálogo, carrito, pagos)?
- ¿Hay restricciones mencionadas (presupuesto, tiempo, plataformas, geografía, integraciones)?

### 2. Hacer preguntas de aclaración (solo las esenciales)

Antes de escribir el documento completo, usa `ask_user_input_v0` para resolver ambigüedades que cambiarían sustancialmente el alcance. Prioriza máximo 3-4 preguntas, por ejemplo:
- ¿Web, app móvil, o ambas?
- ¿Quiénes son los tipos de usuario (roles) del sistema?
- ¿Hay un presupuesto/tiempo límite que defina qué entra en el MVP vs. fases futuras?
- ¿Existen integraciones obligatorias (pagos, redes sociales, mensajería)?

Si la idea ya viene muy detallada y estas respuestas son inferibles del contexto, no preguntes — asume razonablemente y decláralo en el documento como supuesto.

### 3. Redactar el documento de requisitos

Usa la plantilla en `assets/plantilla-requisitos.md` como estructura base. El documento final debe incluir:

1. **Resumen ejecutivo** — 2-3 párrafos: qué es el proyecto, para quién, y qué problema resuelve.
2. **Alcance del MVP** — qué se construye en la primera versión vs. qué queda para fases futuras (sé explícito con una lista de "Incluido en MVP" y "Fuera de alcance por ahora").
3. **Roles de usuario** — quién interactúa con el sistema y qué puede hacer cada uno.
4. **Requisitos funcionales** — agrupados por módulo o área, numerados (RF-01, RF-02...) para que sean referenciables después.
5. **Requisitos no funcionales** — rendimiento, seguridad, disponibilidad, escalabilidad, compatibilidad de dispositivos, idioma, normativa aplicable si se conoce.
6. **Historias de usuario** — formato Scrum estándar: "Como [rol], quiero [acción], para [beneficio]", con criterios de aceptación breves por historia. Agrúpalas por épica/módulo.
7. **Riesgos iniciales** — riesgos técnicos, de negocio o de alcance detectados desde ya (ej. dependencia de una integración externa, ambigüedad en un flujo de pago), con una nota de mitigación breve.
8. **Supuestos y preguntas abiertas** — todo lo que asumiste porque el cliente no lo especificó, y lo que aún necesita confirmación.

### 4. Nivel de profesionalismo

Este documento se usará como entregable real para clientes y como base de trabajo del propio usuario, así que:
- Redacta en español neutro, tono profesional y claro (no telegráfico, no excesivamente técnico si el lector puede ser el cliente).
- Sé específico: evita requisitos vagos como "el sistema debe ser rápido" — cuantifica cuando sea posible ("tiempo de carga menor a 2s en conexión 3G").
- Numera todo lo referenciable (RF-XX, RNF-XX, HU-XX) para que la siguiente skill (arquitectura) pueda citar estos IDs.

### 5. Entregar el archivo

Crea el documento como archivo Markdown (`.md`) usando `create_file`, guárdalo en `/mnt/user-data/outputs/`, y compártelo con `present_files`. Nombra el archivo de forma descriptiva, ej. `requisitos-<nombre-proyecto>.md`.

Al terminar, indica brevemente al usuario que este documento es el insumo para la siguiente etapa (arquitectura de solución) cuando esa skill esté lista.

## Referencia

- `assets/plantilla-requisitos.md` — plantilla base con la estructura exacta a seguir.
