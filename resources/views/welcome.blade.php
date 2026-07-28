<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GenTech Field | Gestión Inteligente de Grupos Electrógenos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                        slate: {
                            850: '#151f32',
                            900: '#0f172a',
                            950: '#030712',
                        }
                    },
                    animation: {
                        'pulse-slow': 'pulse 6s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 4s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass-panel {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glass-card {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card:hover {
            background: rgba(30, 41, 59, 0.7);
            border-color: rgba(16, 185, 129, 0.3);
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.1), 0 8px 10px -6px rgba(16, 185, 129, 0.1);
        }
        .glow-sphere {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            z-index: 0;
            pointer-events: none;
        }
        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #34d399 50%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 font-sans min-h-screen overflow-x-hidden relative selection:bg-brand-500 selection:text-white">

    <!-- Ambient Glowing Spheres -->
    <div class="glow-sphere w-[500px] h-[500px] bg-brand-600/20 top-[-100px] left-[-150px] animate-pulse-slow"></div>
    <div class="glow-sphere w-[600px] h-[600px] bg-sky-600/15 top-[30%] right-[-200px] animate-pulse-slow" style="animation-delay: 2s;"></div>
    <div class="glow-sphere w-[400px] h-[400px] bg-emerald-500/10 bottom-[-50px] left-[25%] animate-pulse-slow" style="animation-delay: 4s;"></div>

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass-panel border-b border-white/5 py-4 px-6 md:px-12 transition-all duration-300">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-emerald-400 flex items-center justify-center shadow-lg shadow-brand-500/30">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <span class="font-display font-bold text-xl tracking-tight text-white">GenTech <span class="text-brand-400 font-light">Field</span></span>
                    <span class="hidden sm:inline-block ml-2 px-2 py-0.5 text-[10px] font-semibold bg-brand-500/20 text-brand-300 rounded-full border border-brand-500/30">v3.0 Autógenos</span>
                </div>
            </div>
            <div class="hidden md:flex items-center space-x-8 text-sm font-medium text-slate-300">
                <a href="#solucion" class="hover:text-brand-400 transition-colors">Solución</a>
                <a href="#modulos" class="hover:text-brand-400 transition-colors">Módulos IA</a>
                <a href="#portales" class="hover:text-brand-400 transition-colors">Portales de Acceso</a>
            </div>
            <div>
                <a href="/dashboard" class="px-4 py-2 text-sm font-medium text-slate-950 bg-gradient-to-r from-brand-400 to-emerald-500 hover:from-brand-300 hover:to-emerald-400 rounded-lg transition-all shadow-lg shadow-brand-500/20 hover:shadow-brand-500/40 font-semibold transform hover:-translate-y-0.5">
                    Acceder al Sistema &rarr;
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-36 pb-20 px-6 md:px-12 max-w-7xl mx-auto z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-slate-900/80 border border-brand-500/30 text-brand-400 text-xs font-medium mb-8 shadow-inner animate-float">
                <span class="w-2 h-2 rounded-full bg-brand-500 animate-ping"></span>
                <span>Plataforma de Nueva Generación &bull; Offline-First &bull; Diagnóstico Asistido por IA</span>
            </div>
            
            <h1 class="font-display text-4xl sm:text-6xl md:text-7xl font-extrabold tracking-tight text-white leading-[1.1] mb-6">
                Mantenimiento de Electrógenos <span class="gradient-text">Impulsado por Inteligencia Artificial</span>
            </h1>
            
            <p class="text-base sm:text-lg text-slate-400 max-w-2xl mx-auto font-normal leading-relaxed mb-10">
                Revolucionamos la gestión en campo de generadores eléctricos y motores estacionarios. Conecta técnicos de campo, supervisores y clientes con diagnósticos automáticos en tiempo real y reportes en PDF con firma digital.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6">
                <a href="/dashboard" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-brand-500 to-emerald-600 hover:from-brand-400 hover:to-emerald-500 text-white font-display font-semibold text-base rounded-xl shadow-xl shadow-brand-600/30 hover:shadow-brand-500/50 transition-all transform hover:-translate-y-1 flex items-center justify-center space-x-3">
                    <span>Ingresar a GenTech Field</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>

            <!-- Ticker Stats -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4 pt-8 border-t border-white/10 max-w-3xl mx-auto">
                <div class="text-center">
                    <div class="font-display text-3xl font-extrabold text-white">99.9%</div>
                    <div class="text-xs text-slate-400 font-medium uppercase tracking-wider mt-1">Precisión de Falla</div>
                </div>
                <div class="text-center">
                    <div class="font-display text-3xl font-extrabold text-brand-400">GenTech AI</div>
                    <div class="text-xs text-slate-400 font-medium uppercase tracking-wider mt-1">Motor ECU v3.0</div>
                </div>
                <div class="text-center">
                    <div class="font-display text-3xl font-extrabold text-white">&lt; 3 min</div>
                    <div class="text-xs text-slate-400 font-medium uppercase tracking-wider mt-1">Reporte PDF & Firma</div>
                </div>
                <div class="text-center">
                    <div class="font-display text-3xl font-extrabold text-sky-400">100% Sync</div>
                    <div class="text-xs text-slate-400 font-medium uppercase tracking-wider mt-1">Soporte Offline-First</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Features Section -->
    <section id="solucion" class="py-20 px-6 md:px-12 max-w-7xl mx-auto relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="font-display text-xs font-bold text-brand-400 tracking-widest uppercase mb-3">Especificación Oficial MVP</h2>
            <h3 class="font-display text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Arquitectura Diseñada para Trabajos Críticos</h3>
            <p class="text-slate-400 mt-4 text-sm sm:text-base">Desde la recepción del síntoma en la planta de generación hasta la emisión del certificado firmado en campo.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="glass-card p-8 rounded-2xl relative overflow-hidden group">
                <div class="w-12 h-12 rounded-xl bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-400 mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <h4 class="font-display font-bold text-xl text-white mb-3">Diagnóstico Asistido por IA</h4>
                <p class="text-slate-400 text-sm leading-relaxed mb-4">
                    Ingresa códigos de falla SPN/FMI, síntomas y lecturas de horómetro. El motor GenTech AI correlaciona historiales y recomienda el plan exacto (inspección, reparación o reemplazo).
                </p>
                <div class="text-xs font-semibold text-brand-400 flex items-center space-x-1">
                    <span>Módulo Integrado en Operaciones</span>
                    <span>&rarr;</span>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="glass-card p-8 rounded-2xl relative overflow-hidden group">
                <div class="w-12 h-12 rounded-xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center text-sky-400 mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h4 class="font-display font-bold text-xl text-white mb-3">Checklists Modulares</h4>
                <p class="text-slate-400 text-sm leading-relaxed mb-4">
                    Verificación sistemática del Motor de Combustión, Alternador, Radiadores, Sistema de Combustible y Control Eléctrico con registro de valores medidos y alertas automáticas.
                </p>
                <div class="text-xs font-semibold text-sky-400 flex items-center space-x-1">
                    <span>Cumplimiento Estricto en Campo</span>
                    <span>&rarr;</span>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="glass-card p-8 rounded-2xl relative overflow-hidden group">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h4 class="font-display font-bold text-xl text-white mb-3">Reportes PDF & Firmas</h4>
                <p class="text-slate-400 text-sm leading-relaxed mb-4">
                    Al terminar la intervención, genera un reporte ejecutivo al instante. El técnico y el cliente firman digitalmente validando la calidad del servicio técnico prestado.
                </p>
                <div class="text-xs font-semibold text-emerald-400 flex items-center space-x-1">
                    <span>Descarga PDF DomPDF en el acto</span>
                    <span>&rarr;</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Portal Selector Section -->
    <section id="portales" class="py-20 px-6 md:px-12 max-w-7xl mx-auto relative z-10 border-t border-white/5">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="font-display text-xs font-bold text-sky-400 tracking-widest uppercase mb-3">Control de Acceso por Roles</h2>
            <h3 class="font-display text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Elige Tu Portal de Trabajo</h3>
            <p class="text-slate-400 mt-4 text-sm">La solución separa los workflows operativos de campo de las tareas de gestión gerencial y configuración.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <!-- Portal Operativo -->
            <div class="glass-panel p-8 sm:p-10 rounded-3xl border border-brand-500/30 relative overflow-hidden flex flex-col justify-between hover:border-brand-500/60 transition-all">
                <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div>
                    <div class="inline-block px-3 py-1 rounded-md bg-brand-500/20 text-brand-300 font-bold text-xs mb-6 uppercase tracking-wide border border-brand-500/30">
                        Técnicos de Campo & Clientes
                    </div>
                    <h4 class="font-display font-bold text-2xl text-white mb-3 flex items-center space-x-3">
                        <span>Portal Operativo (/app)</span>
                        <span class="text-xs px-2 py-1 bg-brand-500 text-slate-950 font-extrabold rounded">EN VIVO</span>
                    </h4>
                    <p class="text-slate-300 text-sm leading-relaxed mb-8">
                        Diseñado para la ejecución en campo. Permite a los ingenieros y técnicos abrir órdenes de intervención, registrar síntomas, consultar la biblioteca de códigos ECU, llenar el checklist de inspección y generar el reporte final con firmas.
                    </p>
                    <div class="space-y-3 mb-8 text-sm text-slate-400">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-brand-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span>Vista rápida del Parque Electrógeno asignado</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-brand-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span>Asistente Inteligente de Diagnóstico GenTech AI</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-brand-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span>Visualización de Reportes PDF en tiempo real</span>
                        </div>
                    </div>
                </div>
                <a href="/dashboard" class="w-full py-4 bg-gradient-to-r from-brand-500 to-emerald-600 hover:from-brand-400 hover:to-emerald-500 text-slate-950 font-display font-bold text-center rounded-xl shadow-lg transition-all block text-base">
                    Acceder al Portal Operativo &rarr;
                </a>
            </div>

            <!-- Panel Admin -->
            <div class="glass-panel p-8 sm:p-10 rounded-3xl border border-indigo-500/30 relative overflow-hidden flex flex-col justify-between hover:border-indigo-500/60 transition-all">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div>
                    <div class="inline-block px-3 py-1 rounded-md bg-indigo-500/20 text-indigo-300 font-bold text-xs mb-6 uppercase tracking-wide border border-indigo-500/30">
                        Administradores & Supervisores
                    </div>
                    <h4 class="font-display font-bold text-2xl text-white mb-3 flex items-center space-x-3">
                        <span>Panel de Administración (/admin)</span>
                    </h4>
                    <p class="text-slate-300 text-sm leading-relaxed mb-8">
                        Centro de mando para gerencia técnica. Controla empresas clientes, catálogo global de marcas (Caterpillar, Cummins, Kohler, etc.), inventario de repuestos, base de conocimiento y auditoría.
                    </p>
                    <div class="space-y-3 mb-8 text-sm text-slate-400">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-indigo-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span>Gestión integral de Usuarios y Roles del Sistema</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-indigo-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span>Administración del Catálogo de Repuestos y Alertas</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-indigo-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span>Mantenimiento de la Biblioteca de Códigos ECU</span>
                        </div>
                    </div>
                </div>
                <a href="/dashboard" class="w-full py-4 bg-slate-800 hover:bg-slate-700 text-white font-display font-bold text-center rounded-xl border border-white/10 hover:border-white/20 transition-all block text-base shadow-lg">
                    Acceder al Panel Admin &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-white/5 py-12 px-6 md:px-12 max-w-7xl mx-auto relative z-10 text-slate-500 text-xs sm:text-sm">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                <span class="text-slate-400 font-medium">Sistema GenTech Field &bull; Grupos Autógenos</span>
            </div>
            <div>
                &copy; {{ date('Y') }} Todos los derechos reservados. Desarrollado en Laravel 12 & FilamentPHP 3.
            </div>
        </div>
    </footer>

</body>
</html>
