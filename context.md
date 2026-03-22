# Planificacion general

## 1) Contexto del producto

CeWy es una aplicacion web de gestion de tareas colaborativa centrada en proyectos. El objetivo del MVP es permitir que un equipo pueda:

- Registrarse e iniciar sesion de forma segura.
- Crear proyectos e invitar integrantes con roles.
- Gestionar tareas en vista Kanban y vista tabla.
- Aplicar filtros utiles para trabajo diario.
- Mantener una UX moderna, fluida e intuitiva.

La app parte sobre un stack Laravel 12 + Vite + Tailwind (base ya presente en este repositorio).

## 2) Alcance funcional MVP (segun documento de requisitos)

### 2.1 Autenticacion

- Pantalla inicial: login.
- Registro con campos:
  - nombre
  - apellidos
  - correo electronico
  - nombre de usuario
  - contrasena
- Login con:
  - usuario + contrasena, o
  - correo + contrasena
- Regla de contrasena MVP:
  - minimo 6 caracteres
  - se informa recomendacion de mayusculas, minusculas, numeros y simbolos (sin obligar)

### 2.2 Home

- Listado de proyectos del usuario.
- Boton para crear proyecto.
- Aside izquierdo con:
  - enlace a dashboard/home
  - proyectos recientes (maximo 5)
  - espacio para futuros enlaces de app

### 2.3 Proyectos

- Crear proyecto con:
  - nombre
  - descripcion
  - integrantes invitados
  - rol por integrante
- Vistas del proyecto:
  - Kanban con columnas: Planeadas, Asignadas, Desarrollo, Revision, Terminadas.
  - Tabla con estado visual de empezada/no empezada por color.
- En columna Terminadas:
  - cargar maximo 10 tareas al inicio
  - boton "ver mas" para paginacion incremental
- Filtros compartidos en Kanban y tabla:
  - mis tareas
  - por deadline
  - sin empezar
  - empezadas
  - (y filtros de utilidad similares)

### 2.4 Roles por proyecto

- CRUD de roles dentro de cada proyecto.
- Cada rol define:
  - nombre
  - descripcion
  - permisos por checkbox:
    - anadir tareas
    - eliminar tareas
    - modificar tareas
    - asignar/quitar roles
    - crear roles
    - modificar proyecto

### 2.5 Tareas

- Crear tarea rapido con:
  - nombre
  - descripcion enriquecida (rich text)
  - persona(s) asignada(s)
  - prioridad (1 muy alta, 5 baja)
  - categoria
  - columna/estado Kanban
  - fecha de entrega
  - opcion "crear otra al guardar"
- Acciones sobre tarea:
  - duplicar
  - eliminar
  - copiar a otro proyecto
  - adjuntar documentos/fotos
  - comentarios

### 2.6 Categorias

Categorias base:

- Documentacion
- Bug
- Feature
- Mejora
- Revision

Cada categoria afecta color visual de la tarea segun tema activo.

## 3) Supuestos de implementacion (hasta confirmar)

- Arquitectura monolito Laravel con Blade + componentes JS ligeros.
- Base de datos inicial: SQLite para desarrollo local y MySQL/PostgreSQL en produccion.
- Control de permisos por proyecto basado en tabla de permisos y validacion en Policies/Gates.
- Subida de archivos con storage local en desarrollo; compatible con S3 en futuro.
- No se implementa aun app movil nativa en MVP.

## 4) Arquitectura funcional propuesta

### 4.1 Modulos

- Modulo Auth
- Modulo Usuarios y perfil basico
- Modulo Proyectos
- Modulo Membresias e invitaciones
- Modulo Roles y permisos por proyecto
- Modulo Tareas
- Modulo Comentarios y adjuntos
- Modulo Filtros, vistas y productividad
- Modulo Configuracion de tema (base para futuro)

### 4.2 Entidades principales (modelo de datos)

- users
- projects
- project_members (user_id, project_id, role_id, invited_by, joined_at)
- project_roles (project_id, name, description)
- role_permissions (role_id, permission_key)
- tasks (project_id, creator_id, title, description_rich, status, priority, category, deadline)
- task_assignees (task_id, user_id)
- task_comments (task_id, user_id, body)
- task_attachments (task_id, uploader_id, file_path, mime, size)
- task_activity_log (task_id, actor_id, action, payload)

### 4.3 Estados y enums

- task_status:
  - planned
  - assigned
  - in_progress
  - review
  - done
- task_category:
  - documentation
  - bug
  - feature
  - improvement
  - review
- task_priority:
  - 1,2,3,4,5

## 5) Reglas de negocio clave

- Un usuario solo puede ver proyectos donde es miembro.
- Un rol pertenece a un proyecto (no global en MVP).
- Permisos evaluados por proyecto y accion.
- Al eliminar proyecto se gestionan datos relacionados (soft delete recomendado).
- En "Terminadas" se listan 10 tareas iniciales por carga; siguientes via "ver mas".
- Filtros deben ser consistentes entre vista Kanban y vista tabla.
- Copiar tarea a otro proyecto requiere permiso en origen y destino.

## 6) Riesgos y mitigacion

- Riesgo: complejidad temprana de permisos.
  - Mitigacion: matriz simple de permisos y test por policy desde inicio.
- Riesgo: UX lenta al crecer tareas.
  - Mitigacion: indices en DB, paginacion y cargas parciales.
- Riesgo: rich text con riesgo XSS.
  - Mitigacion: sanitizacion del contenido y whitelist de etiquetas.
- Riesgo: adjuntos pesados.
  - Mitigacion: limite tamano, validacion mime, colas para procesos pesados.

## 7) Plan de desarrollo por fases

### Fase 0 - Preparacion tecnica

Objetivo: dejar base de trabajo estable.

- T0.1 Configurar entorno local (.env, DB, colas, storage link).
- T0.2 Definir convenciones (naming, estados, categorias, permisos).
- T0.3 Configurar base de estilos UI y layout global.
- T0.4 Preparar pipeline minimo de tests y lint.

### Fase 1 - Base de datos y dominio

Objetivo: estructura de datos completa del MVP.

- T1.1 Crear migraciones de usuarios extendidos (name, surname, username unico).
- T1.2 Crear tablas de proyectos y membresias.
- T1.3 Crear tablas de roles y permisos por proyecto.
- T1.4 Crear tablas de tareas y asignaciones.
- T1.5 Crear tablas de comentarios, adjuntos y activity log.
- T1.6 Crear seeders base (categorias, estados, permisos default).
- T1.7 Crear modelos/relaciones Eloquent.

### Fase 2 - Autenticacion y acceso

Objetivo: onboarding completo y seguro.

- T2.1 Implementar registro con campos requeridos.
- T2.2 Implementar login por usuario o email.
- T2.3 Validaciones de contrasena (min 6 + texto de recomendacion seguridad).
- T2.4 Implementar logout, sesiones y proteccion de rutas.
- T2.5 Tests de feature para auth.

### Fase 3 - Home y navegacion principal

Objetivo: entrada de usuario tras login.

- T3.1 Crear layout autenticado con aside izquierdo.
- T3.2 Mostrar lista de proyectos del usuario.
- T3.3 Mostrar proyectos recientes (max 5).
- T3.4 Boton y flujo de crear proyecto desde home.
- T3.5 Ajustes visuales de fluidez (transiciones base).

### Fase 4 - Proyectos, miembros y roles

Objetivo: colaboracion interna por proyecto.

- T4.1 Formulario crear/editar proyecto (nombre, descripcion).
- T4.2 Flujo invitar integrantes al proyecto.
- T4.3 Asignar rol al invitar/editar miembro.
- T4.4 CRUD de roles por proyecto.
- T4.5 Pantalla de permisos por rol (checkboxes).
- T4.6 Policies/middlewares para control de acceso.
- T4.7 Tests de permisos por rol.

### Fase 5 - Tareas (core)

Objetivo: productividad real dentro del proyecto.

- T5.1 Formulario rapido de creacion de tarea.
- T5.2 Campo descripcion enriquecida (editor rich text).
- T5.3 Asignacion multiple de usuarios.
- T5.4 Guardado de estado, prioridad, categoria, deadline.
- T5.5 Opcion "crear otra al guardar".
- T5.6 Acciones de tarea: duplicar, eliminar, copiar proyecto.
- T5.7 Comentarios en tarea.
- T5.8 Adjuntos en tarea (subida y listado).
- T5.9 Registro de actividad basico.
- T5.10 Tests de tareas (creacion, permisos, acciones).

### Fase 6 - Vistas Kanban y tabla

Objetivo: visualizacion de tareas util y rapida.

- T6.1 Vista Kanban con 5 columnas fijas del MVP.
- T6.2 Drag/drop o cambio de estado por accion controlada.
- T6.3 Limite inicial de 10 en Terminadas.
- T6.4 Boton "ver mas" en Terminadas con paginacion incremental.
- T6.5 Vista tabla con codigos de color started/not started.
- T6.6 Sincronizar filtros entre Kanban y tabla.
- T6.7 Tests de consultas y paginacion de vistas.

### Fase 7 - Filtros y ordenacion

Objetivo: encontrar trabajo relevante al instante.

- T7.1 Filtro "mis tareas".
- T7.2 Filtro por deadline.
- T7.3 Filtro por estado (sin empezar, empezadas, etc.).
- T7.4 Filtro por categoria y prioridad.
- T7.5 Persistencia de filtros por sesion.
- T7.6 Optimizar queries con indices.

### Fase 8 - Calidad, seguridad y entrega MVP

Objetivo: estabilidad para uso real.

- T8.1 Hardening seguridad (validaciones, autorizacion, CSRF, XSS).
- T8.2 Revisar limites de archivos y politicas de subida.
- T8.3 Cobertura minima de tests de feature y unitarios criticos.
- T8.4 Revisión UX final (fluidez, estados vacios, errores claros).
- T8.5 Documentacion de despliegue y checklist release MVP.

## 8) Backlog atomico (orden recomendado)

1. Crear migracion para username unico en users.
2. Crear migracion projects.
3. Crear migracion project_roles.
4. Crear migracion role_permissions.
5. Crear migracion project_members.
6. Crear migracion tasks.
7. Crear migracion task_assignees.
8. Crear migracion task_comments.
9. Crear migracion task_attachments.
10. Crear migracion task_activity_log.
11. Implementar modelos Eloquent y relaciones.
12. Implementar seeders de permisos base.
13. Implementar formulario de registro.
14. Implementar login con usuario o email.
15. Proteger rutas con middleware auth.
16. Crear layout autenticado + aside.
17. Implementar listado proyectos home.
18. Implementar crear proyecto.
19. Implementar invitar miembro.
20. Implementar CRUD roles.
21. Implementar permisos por rol (checkbox UI + persistencia).
22. Implementar policies de proyecto y tarea.
23. Implementar crear tarea rapido.
24. Integrar editor rich text.
25. Implementar asignacion multiple.
26. Implementar comentarios.
27. Implementar adjuntos.
28. Implementar duplicar tarea.
29. Implementar copiar tarea entre proyectos.
30. Implementar borrar tarea.
31. Implementar vista Kanban.
32. Implementar limite 10 en done + ver mas.
33. Implementar vista tabla.
34. Implementar filtros compartidos.
35. Optimizar indices y consultas.
36. Implementar suite de tests MVP.
37. Ajustes UX final y documentacion release.

## 9) Criterios de aceptacion MVP

- Registro y login funcionan con validaciones pedidas.
- Un usuario autenticado puede crear proyecto y ver su home.
- Se pueden invitar miembros y asignarles roles por proyecto.
- Se pueden crear y gestionar tareas completas con categorias/prioridad/deadline.
- Kanban y tabla muestran tareas con filtros utiles.
- La columna Terminadas carga 10 tareas + "ver mas".
- Los permisos restringen acciones de forma correcta.
- Tests criticos pasan en local.

## 10) Plan de trabajo continuo

A partir de este archivo, cada tarea importante se descompondra en una "planificacion de tarea" separada con:

- objetivo concreto
- alcance y fuera de alcance
- checklist de implementacion
- pruebas a ejecutar
- definicion de terminado

Este documento se considera la referencia de planificacion general del proyecto CeWy.
