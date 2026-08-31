# Checklists de Completitud por Etapa

Cada checklist lista las secciones que un documento de esa etapa debería tener, según las plantillas de las skills correspondientes. Úsalos para la sección "Checklist de Completitud" del informe.

## Requisitos (skill `analisis-requisitos`)

- [ ] Resumen ejecutivo
- [ ] Alcance del MVP (incluido / fuera de alcance, explícitos)
- [ ] Roles de usuario definidos
- [ ] Requisitos funcionales numerados (RF-XX), agrupados por módulo
- [ ] Requisitos no funcionales numerados (RNF-XX)
- [ ] Historias de usuario en formato Scrum con criterios de aceptación
- [ ] Riesgos iniciales con mitigación
- [ ] Supuestos y preguntas abiertas

**Señales de alerta comunes:** requisitos sin numerar (dificulta referenciarlos después), historias sin criterios de aceptación, MVP sin límite claro de qué queda fuera.

## Arquitectura (skill `arquitectura-solucion`)

- [ ] Resumen de la decisión arquitectónica con justificación
- [ ] Stack tecnológico con justificación por capa
- [ ] Componentes del sistema + diagrama Mermaid
- [ ] Diseño de API de alto nivel (tabla método/ruta/propósito/rol)
- [ ] Diagrama de despliegue
- [ ] Decisiones descartadas con su razón
- [ ] Riesgos técnicos y supuestos

**Señales de alerta comunes:** stack elegido sin justificación, ausencia de "decisiones descartadas" (sugiere que no se consideraron alternativas), componentes que no cubren todos los módulos de requisitos.

## Base de Datos (skill `diseno-base-datos`)

- [ ] Resumen de la decisión (SQL/NoSQL/híbrido) con justificación
- [ ] Diagrama Entidad-Relación (Mermaid `erDiagram`)
- [ ] Descripción de entidades con tablas de campos
- [ ] Relaciones con cardinalidad y comportamiento ante borrado
- [ ] Consideraciones de diseño (normalización, índices)
- [ ] Supuestos y preguntas abiertas

**Señales de alerta comunes:** entidades en el diagrama sin descripción de campos, relaciones sin cardinalidad especificada, ausencia de campos de auditoría (created_at/updated_at) sin justificación de por qué no se incluyeron.

## Diseño UX/UI (skill `diseno-ux-ui`)

- [ ] Resumen de dirección de diseño
- [ ] Flujos de usuario por rol (con diagrama o secuencia numerada)
- [ ] Sistema de diseño básico (color, tipografía, componentes con estados)
- [ ] Descripción de pantallas (propósito, elementos, acción principal)
- [ ] Estados de UI (carga, error, vacío) para pantallas relevantes
- [ ] Supuestos y preguntas abiertas

**Señales de alerta comunes:** pantallas sin estados de error/vacío definidos, flujos que no cubren todos los roles de requisitos, sistema de diseño genérico sin relación con el proyecto específico.

## Scrum (skill `gestion-scrum`)

- [ ] Resumen de planificación (duración de sprint, capacidad, número de sprints)
- [ ] Backlog priorizado con estimación en puntos Fibonacci y criterio de prioridad
- [ ] Plan de sprints con Sprint Goal declarado por sprint
- [ ] Referencia a plantillas de ceremonias
- [ ] Supuestos y riesgos de planificación

**Señales de alerta comunes:** historias sin estimar, sprints sin objetivo declarado (solo lista de tareas), backlog que no cubre todas las historias del documento de requisitos, dependencias entre historias no respetadas en el orden de sprints.
