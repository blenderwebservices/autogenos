Plan de Implementación: API REST para App Móvil
Este plan detalla la creación de una API REST moderna para respaldar una futura aplicación móvil de GenTech Field. La API estará dirigida principalmente al flujo operativo de los Técnicos en campo.

User Review Required
IMPORTANT

Utilizaremos Laravel Sanctum para la emisión y validación de tokens de API.
Todos los endpoints bajo /api/ estarán protegidos (excepto /api/login).
La API devolverá respuestas en formato JSON estandarizado (usando API Resources de Laravel).
Open Questions
¿Te gustaría que la API incluya también endpoints administrativos (para crear usuarios, ver métricas), o nos enfocamos exclusivamente en la operación de campo (Técnicos/Intervenciones)? Por defecto, construiré la API orientada al Técnico.
Proposed Changes
Configuración Base
[NEW] routes/api.php
Ejecutaré php artisan install:api para habilitar el ruteo de APIs en Laravel 11+ y configurar Laravel Sanctum.
Definiré el archivo de rutas routes/api.php con los endpoints.
Controladores y Lógica (Endpoints)
[NEW] app/Http/Controllers/Api/AuthController.php
POST /api/login: Valida credenciales (email y password), emite un token de acceso personal (Personal Access Token).
POST /api/logout: Revoca y destruye el token actual.
GET /api/me: Devuelve los datos del perfil del usuario autenticado.
[NEW] app/Http/Controllers/Api/EquipmentController.php
GET /api/equipments: Lista el parque electrógeno disponible o asignado al usuario.
[NEW] app/Http/Controllers/Api/InterventionController.php
GET /api/interventions: Lista las órdenes de trabajo asignadas.
GET /api/interventions/{id}: Detalles completos (incluyendo checklists y repuestos usados).
PUT /api/interventions/{id}: Actualiza el estado, síntomas, y códigos de error.
[NEW] app/Http/Controllers/Api/AiDiagnosticController.php
POST /api/interventions/{id}/ai-diagnostic: Endpoint que replica el proceso RAG de Filament. Toma la intervención, lee sus síntomas y códigos, consulta ErrorCodeLibrary, llama a Gemini AI y devuelve el JSON de sugerencias directamente a la App móvil para actualizar la UI nativa.
Transformación de Datos (API Resources)
[NEW] app/Http/Resources/...
Crearé UserResource, EquipmentResource, e InterventionResource (en el namespace HTTP, independientes de los recursos de Filament) para formatear los JSON que la API escupe, escondiendo campos sensibles y organizando relaciones.
Verification Plan
Automated Tests
No se correrán tests automatizados de PHPUnit por ahora, pero se validarán mediante HTTP request.
Manual Verification
Utilizaré comandos curl internos para:
Iniciar sesión y obtener un Token.
Solicitar la lista de intervenciones usando el Token como Bearer Auth.
Ejecutar el endpoint de AI Diagnostic de forma remota.
