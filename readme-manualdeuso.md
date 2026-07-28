# Manual de Uso: GenTech Field

Bienvenido al manual oficial de **GenTech Field**, la plataforma unificada para la gestión inteligente de mantenimiento de grupos electrógenos.

El sistema funciona bajo un **Dashboard Unificado** (`http://autogenos.test/dashboard`) al cual ingresan todos los usuarios de la plataforma. La interfaz es dinámica y se adapta automáticamente según los permisos (Roles) de cada usuario.

---

## 1. Guía para el Técnico / Operador
El portal está diseñado para ser la herramienta diaria del técnico en el sitio de trabajo (campo).

**Permisos Restringidos:** No tendrás acceso a configuraciones del sistema, inventario general o creación de usuarios. Tu enfoque es puramente operativo.

### Flujo de Trabajo (Intervención):
1. **Ver tus Equipos**: Al ingresar, navega a **Equipos** para ver los generadores que tienes asignados para dar servicio.
2. **Crear o Editar una Intervención**:
   - Entra al módulo de **Intervenciones** y selecciona una orden de trabajo pendiente.
   - **Registro de campo**: Llena los "Síntomas Reportados" observados en sitio y selecciona los "Códigos de Error" (`error_codes`) que arroje el panel de control del generador.
3. **Uso de GenTech AI (Inteligencia Artificial)**:
   - Una vez ingresados los síntomas y códigos de error, haz clic en el botón con el ícono de chispas: **"Generar Diagnóstico AI"**.
   - El sistema enviará tus observaciones y el contexto técnico de los códigos a **Gemini 3.5 Flash Lite**.
   - En segundos, se rellenará el bloque de "Sugerencias de Inteligencia Artificial" con tareas recomendadas paso a paso, un nivel de confianza (%), y una sugerencia de acción técnica (ej. *inspeccionar, reparar, reemplazar*).
4. **Ejecución y Cierre**:
   - Usa los checklists dinámicos para ir marcando el estado de los componentes (Baterías, Motor, Alternador).
   - Añade los **Repuestos** utilizados durante el servicio.
   - Al terminar, cambia el estatus de la intervención a *Completada* y genera el **Reporte en PDF** (el cual podrá ser firmado y entregado).

---

## 2. Guía para el Supervisor
El rol de Supervisor está pensado para los jefes de servicio y coordinadores de campo.

**Permisos Supervisores:** Tienen control total sobre la operación técnica, pero **NO** pueden crear ni borrar cuentas de usuarios (para evitar escalado de privilegios no autorizados).

### Responsabilidades y Uso:
1. **Gestión Operativa**:
   - Asignar intervenciones a los Técnicos.
   - Revisar el estatus global del **Parque Electrógeno**.
2. **Gestión de Conocimiento y Catálogos**:
   - Acceso a **Base de Conocimiento** y **Librería de Códigos de Error**. Es crucial mantener esta librería actualizada, ya que de aquí se alimenta el contexto que utiliza la Inteligencia Artificial para dar respuestas precisas.
   - Gestión del inventario de **Repuestos** (Stock y Precios).
   - Administración de **Marcas y Modelos** de los equipos.
3. **Revisión de Intervenciones**:
   - Pueden auditar las recomendaciones que la IA le dio al técnico y compararlas con las refacciones que el técnico reportó utilizar, evaluando la eficiencia de las reparaciones.

---

## 3. Guía para el Administrador
El administrador es el dueño absoluto de la plataforma, usualmente el gerente general de la empresa de servicios o el administrador de TI.

**Permisos Administrativos:** Acceso sin restricciones a todos los módulos y configuraciones del sistema.

### Responsabilidades Únicas:
1. **Gestión de Usuarios y Empresas**: 
   - Es el **único rol** capaz de crear nuevas empresas cliente y dar de alta a nuevos técnicos, supervisores o clientes en el sistema desde el módulo de **Usuarios**.
2. **Auditoría Completa**:
   - Puede ver las métricas completas de todas las compañías y todos los costos (estimados vs reales) derivados de los repuestos consumidos en las intervenciones.
3. **Mantenimiento del Ecosistema**:
   - El administrador es responsable de que el sistema esté en óptimas condiciones, gestionando los roles, y asegurando que las integraciones (como el enlace de la API con Gemini AI) estén activas.

---

## 4. Guía para el Cliente Final
El cliente final es la empresa dueña del generador (ej. un Hospital, Centro de Datos).

**Permisos de Cliente:** Acceso de "Solo Lectura" a su propio equipamiento.

### Experiencia del Cliente:
1. **Transparencia**:
   - Al ingresar al Dashboard, el cliente solo verá sus generadores.
   - Puede consultar el historial completo de mantenimientos e intervenciones de sus máquinas.
2. **Visualización de Reportes**:
   - Una vez que una intervención es cerrada por el técnico, el cliente puede acceder y descargar el **Reporte PDF** ejecutivo generado por el sistema.
   - **Nota**: El cliente no puede ver los prompts de la Inteligencia Artificial ni el proceso interno de diagnóstico del técnico, solo el resultado final documentado.

---

### Resumen de la Inteligencia Artificial (RAG)
El módulo de IA no es un chatbot genérico. Opera como un **"Copiloto Experto"** para el técnico:
* **No alucina**: Porque cruza el "Código de Error" con la base de datos oficial del manual del fabricante (`ErrorCodeLibrary`).
* **Formatos Estrictos**: Devuelve JSON estructurado que el sistema usa de inmediato para rellenar los campos de la base de datos (tareas, confianza, estatus recomendado), eliminando el tiempo de captura manual para el operador en campo.
