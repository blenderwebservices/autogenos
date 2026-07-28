# Testing en GenTech Field

Este documento describe el stack de pruebas implementado en la aplicación GenTech Field, cubriendo tanto pruebas unitarias como de integración, y explicando cómo ejecutar la suite de tests.

## Stack de Testing

El proyecto utiliza **PHPUnit** como marco principal de pruebas, integrado nativamente con Laravel.

### Tipos de Pruebas Implementadas

#### 1. Pruebas Unitarias (`tests/Unit/`)
Las pruebas unitarias se enfocan en probar clases, métodos y modelos de forma aislada, sin interactuar profundamente con la base de datos o servicios externos.

- **`UserRoleTest.php`**: Verifica que el modelo de usuario (`User`) maneja y guarda correctamente los roles (ej. *admin*, *technician*).
- **`InterventionModelTest.php`**: Valida que los mutadores y el casting de JSON funcionen apropiadamente en el modelo `Intervention`, específicamente para el campo de `ai_suggestions`.

#### 2. Pruebas de Integración (Feature) (`tests/Feature/Api/`)
Las pruebas de integración evalúan el sistema en conjunto. Estas interactúan con la base de datos (utilizando SQLite en memoria por rapidez) y prueban los flujos completos de los endpoints de la API.

- **`AuthApiTest.php`**: 
  - Verifica que un usuario con credenciales correctas pueda hacer login y recibir su `access_token` de Laravel Sanctum.
  - Verifica que se rechacen las peticiones con credenciales inválidas (Error 401).

- **`InterventionApiTest.php`**: 
  - Verifica que un técnico pueda ver sus intervenciones asignadas (Status 200).
  - Valida el control de acceso: un técnico no puede acceder a los detalles de una intervención que le pertenece a otro técnico (Error 403).

- **`AiDiagnosticApiTest.php`**: 
  - Prueba el endpoint de generación de diagnóstico de Inteligencia Artificial utilizando **HTTP Mocking**.
  - Utiliza `Http::fake()` para simular la respuesta de la API de Google Generative Language (Gemini), previniendo llamadas de red reales y lentas durante los tests.
  - Verifica que la sugerencia generada por el mock se almacene en la base de datos y se envíe al usuario.

---

## Ejecución de Pruebas

Para ejecutar el conjunto completo de pruebas, corre el siguiente comando en tu terminal dentro de la raíz del proyecto:

```bash
php artisan test
```

Este comando ejecutará PHPUnit y devolverá un reporte detallado con el tiempo de ejecución y el estado de cada test (pass o fail).

### Ejecutar Pruebas Específicas

Si solo quieres ejecutar pruebas unitarias:
```bash
php artisan test --testsuite=Unit
```

Si solo quieres ejecutar las pruebas de Feature / Integración:
```bash
php artisan test --testsuite=Feature
```

O para un archivo en específico:
```bash
php artisan test tests/Feature/Api/AiDiagnosticApiTest.php
```

---

## Consideraciones Adicionales

1. **Base de datos de Testing**: Laravel utiliza una base de datos temporal SQLite en memoria configurada en `phpunit.xml`. Esto garantiza que los tests no modifiquen la base de datos de tu entorno local (`database.sqlite`).
2. **Factories**: Se crearon *Model Factories* (ej. `CompanyFactory`, `InterventionFactory`, `EquipmentFactory`) para poder poblar rápidamente la base de datos con registros falsos y probar distintos escenarios de forma ágil y determinista.
