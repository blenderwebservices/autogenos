# GenTech Field | Gestión Inteligente de Grupos Electrógenos

<p align="center">
  <img src="public/build/assets/hero-bg.jpg" alt="GenTech Field" width="600"/>
</p>

## 🎯 Objetivo de la Aplicación
**GenTech Field** es una plataforma integral, moderna y robusta diseñada para transformar el mantenimiento y gestión de Grupos Electrógenos Autónomos a nivel global. El objetivo principal es proporcionar a técnicos de campo, supervisores y clientes propietarios una herramienta centralizada y asistida por Inteligencia Artificial para el diagnóstico, reparación, seguimiento y reporte del ciclo de vida de los equipos de generación eléctrica (marcas como Caterpillar, Cummins, Kohler, etc.).

## 🏗 Arquitectura del Sistema
El sistema ha sido construido bajo una arquitectura modular y escalable, enfocada en la eficiencia operativa:

- **Frontend / Landing Page**: Desarrollado con **Laravel Blade** y estilizado con **Tailwind CSS**. Implementa un diseño Ultra-Premium "Glassmorphism" con animaciones dinámicas e interactividad de alto rendimiento.
- **Backend y Paneles de Control**: Basado en **Laravel 12** y **FilamentPHP 3**, ofreciendo una interfaz robusta de doble panel:
  - `/admin`: Panel Administrativo para la gestión de usuarios, catálogo de equipos, inventario de repuestos y base de conocimiento.
  - `/app`: Portal Operativo para técnicos en campo, diseñado para dispositivos móviles/tabletas, enfocado en ejecución de intervenciones y diagnósticos.
- **Generación de Reportes**: Motor de renderizado **DomPDF** para la emisión automatizada de certificados de servicio en formato PDF, firmados digitalmente.
- **Base de Datos**: Base de datos relacional MySQL/SQLite estructurada para gestionar modelos complejos (Empresas, Usuarios, Equipos, Intervenciones, Checklists, Repuestos y Códigos ECU).

## 🚀 Alcances Actuales (MVP Finalizado)
El producto mínimo viable actual permite operar la empresa de forma completa:
- **Gestión Multi-Rol**: Soporte para Administradores, Supervisores, Técnicos y Clientes.
- **Catálogo y Base de Conocimiento**: Diccionario de Códigos de Error (SPN/FMI) y repuestos compatibles.
- **Operación en Campo**: Los técnicos pueden levantar órdenes de trabajo (preventivas/correctivas), adjuntar diagnósticos y marcar refacciones utilizadas.
- **Flujo de Checklists**: Plantillas de inspección predefinidas para motor, alternador, sistemas de refrigeración y baterías.
- **Reportes Certificados**: Creación instantánea del reporte final en PDF para entrega inmediata al cliente final.
- **Integración Visual**: Enlaces transversales de navegación que unifican el entorno administrativo (`/admin`), el operativo (`/app`) y la página institucional de bienvenida (`/`).

## 🤖 Interacción con Inteligencia Artificial (IA) y Agentes
La Inteligencia Artificial es el núcleo diferenciador de GenTech Field:

**Alcance Actual (GenTech AI)**:
- La plataforma cuenta con campos de metadatos (AI Metadata) dentro de las Intervenciones y un diseño de interfaz que acopla alertas predictivas.
- El modelo de datos integra un motor de asistencia predictiva que asocia síntomas y códigos de error (ECU) reportados por el técnico para sugerir causas raíz y soluciones (implementado estructuralmente en el módulo Knowledge Base).

**Integración Futura (Corto/Mediano Plazo)**:
- **Agentes Chatbots Autónomos**: Asistentes integrados (LLMs como OpenAI GPT-4 o Claude 3.5) que actúan como "Ingenieros Expertos Virtuales". Interrogarán al técnico en campo a través de un chat para llegar a diagnósticos guiados leyendo manuales PDF embebidos.
- **Computer Vision**: Reconocimiento automático de marca, modelo y placa de datos del generador mediante una simple fotografía capturada con el móvil (utilizando YOLO-v8 o EfficientNet).
- **Predicción de Fallas**: Análisis histórico algorítmico para pronosticar fallas y recomendar mantenimiento preventivo de componentes críticos antes de que el generador sufra "downtime".

## 🗺 Objetivos y Roadmap

### Corto Plazo (1-3 Meses)
- Despliegue en producción para primeros clientes piloto.
- Implementación de la App Móvil Nativa (Flutter) con sincronización **Offline-First** (SQLite + CRDT) para operación ininterrumpida en zonas remotas (minas, telecomunicaciones, plataformas).
- Despliegue del microservicio AI (Python/FastAPI) para inferencia de Machine Learning y PLN.

### Mediano Plazo (6-12 Meses)
- Expansión comercial internacional hacia Estados Unidos, Colombia y Brasil.
- Integración nativa con sistemas de telemetría IoT desde los controladores de los equipos (DeepSea, ComAp, Woodward) para captura de datos en tiempo real.
- Creación de un **Marketplace de Repuestos** en la plataforma, interconectando proveedores logísticos.

### Largo Plazo (Visión 2030)
- Gemelos Digitales (Digital Twins) de gran parte del parque electrógeno global para simulaciones precisas.
- Ahorro comprobable de más de mil millones de dólares anuales en reducción de tiempos muertos (Downtime) para industrias de misión crítica (Data Centers, Hospitales).
- Consolidación como la plataforma líder SaaS/PaaS B2B para todo el sector de energía en sitio.

---
*Desarrollado con ⚡ por agentes Antigravity bajo la filosofía de "Gestión Inteligente".*
