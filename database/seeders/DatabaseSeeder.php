<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Equipment;
use App\Models\EquipmentBrand;
use App\Models\EquipmentModel;
use App\Models\ErrorCodeLibrary;
use App\Models\InspectionChecklist;
use App\Models\Intervention;
use App\Models\InterventionPart;
use App\Models\KnowledgeBase;
use App\Models\Report;
use App\Models\SparePart;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Companies
        $companyAdmin = Company::create([
            'name' => 'GenTech Field Services S.A.',
            'tax_id' => 'GTF-2026-9901',
            'subscription_plan' => 'enterprise',
            'timezone' => 'America/Mexico_City',
        ]);

        $clientHospital = Company::create([
            'name' => 'Hospital Universitario Metropolitano',
            'tax_id' => 'HUM-1988-4421',
            'subscription_plan' => 'enterprise',
            'timezone' => 'America/Mexico_City',
        ]);

        $clientCloud = Company::create([
            'name' => 'Centro de Datos CloudScale LATAM',
            'tax_id' => 'CSL-2015-8832',
            'subscription_plan' => 'enterprise',
            'timezone' => 'America/Bogota',
        ]);

        $clientMinera = Company::create([
            'name' => 'Minera del Norte S.A. de C.V.',
            'tax_id' => 'MIN-2001-3319',
            'subscription_plan' => 'professional',
            'timezone' => 'America/Monterrey',
        ]);

        // 2. Users
        $admin = User::create([
            'company_id' => $companyAdmin->id,
            'name' => 'Carlos Mendoza (Administrador)',
            'email' => 'admin@gentech.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+52 55 1234 5678',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $supervisor = User::create([
            'company_id' => $companyAdmin->id,
            'name' => 'Ing. Laura Silva (Supervisor)',
            'email' => 'supervisor@gentech.com',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
            'phone' => '+52 55 8765 4321',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $tech1 = User::create([
            'company_id' => $companyAdmin->id,
            'name' => 'Roberto Gómez (Técnico de Campo)',
            'email' => 'tech@gentech.com',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'phone' => '+52 55 3344 5566',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $tech2 = User::create([
            'company_id' => $companyAdmin->id,
            'name' => 'David Torres (Técnico Especialista)',
            'email' => 'tech2@gentech.com',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'phone' => '+52 55 9988 7766',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $userHospital = User::create([
            'company_id' => $clientHospital->id,
            'name' => 'Dr. Fernando Ríos (Director Infraestructura)',
            'email' => 'client@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'phone' => '+52 55 1111 2222',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $userCloud = User::create([
            'company_id' => $clientCloud->id,
            'name' => 'Ing. Andrea Navarro (Jefe Data Center)',
            'email' => 'client@cloudscale.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'phone' => '+57 1 3333 4444',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // 3. Equipment Brands & Models
        $brandCat = EquipmentBrand::create(['name' => 'Caterpillar', 'website' => 'https://www.cat.com']);
        $brandCum = EquipmentBrand::create(['name' => 'Cummins Power Generation', 'website' => 'https://www.cummins.com']);
        $brandKoh = EquipmentBrand::create(['name' => 'Kohler Power Systems', 'website' => 'https://www.kohlerpower.com']);
        $brandPer = EquipmentBrand::create(['name' => 'Perkins Engines', 'website' => 'https://www.perkins.com']);

        $modCat1 = EquipmentModel::create([
            'brand_id' => $brandCat->id,
            'name' => 'C18 Acert Diesel Generator',
            'fuel_type' => 'diesel',
            'application' => 'standby',
            'power_kw_min' => 500,
            'power_kw_max' => 650,
        ]);

        $modCat2 = EquipmentModel::create([
            'brand_id' => $brandCat->id,
            'name' => '3516B Heavy Duty Power Module',
            'fuel_type' => 'diesel',
            'application' => 'prime',
            'power_kw_min' => 1500,
            'power_kw_max' => 2000,
        ]);

        $modCum1 = EquipmentModel::create([
            'brand_id' => $brandCum->id,
            'name' => 'QSK60-G6 Containerized Generator',
            'fuel_type' => 'diesel',
            'application' => 'continuous',
            'power_kw_min' => 1800,
            'power_kw_max' => 2200,
        ]);

        $modKoh1 = EquipmentModel::create([
            'brand_id' => $brandKoh->id,
            'name' => 'KD1800 Industrial Generator Set',
            'fuel_type' => 'diesel',
            'application' => 'standby',
            'power_kw_min' => 1600,
            'power_kw_max' => 1800,
        ]);

        // 4. Equipment (Parque Electrógeno)
        $eq1 = Equipment::create([
            'client_id' => $clientHospital->id,
            'company_id' => $companyAdmin->id,
            'brand_id' => $brandCat->id,
            'model_id' => $modCat1->id,
            'serial_number' => 'CAT-C18-2023-88912',
            'asset_code' => 'GEN-HOSP-01',
            'rated_power_kw' => 600,
            'voltage' => '220/380V 3-Phase',
            'frequency' => '60Hz',
            'fuel_type' => 'diesel',
            'application' => 'standby',
            'installation_date' => '2023-03-15',
            'controller_brand' => 'Deep Sea Electronics',
            'controller_model' => 'DSE7320 MKII',
            'address' => 'Av. Universidad #1001, Planta de Emergencia Torre Norte, CDMX',
            'city' => 'Ciudad de México',
            'status' => 'active',
            'total_operating_hours' => 6450,
            'last_maintenance_date' => '2026-06-10',
            'next_maintenance_date' => '2026-09-10',
            'maintenance_interval_hours' => 250,
        ]);

        $eq2 = Equipment::create([
            'client_id' => $clientCloud->id,
            'company_id' => $companyAdmin->id,
            'brand_id' => $brandCum->id,
            'model_id' => $modCum1->id,
            'serial_number' => 'CUM-QSK60-2022-44109',
            'asset_code' => 'GEN-CLOUD-01',
            'rated_power_kw' => 2000,
            'voltage' => '480V 3-Phase',
            'frequency' => '60Hz',
            'fuel_type' => 'diesel',
            'application' => 'continuous',
            'installation_date' => '2022-08-20',
            'controller_brand' => 'ComAp',
            'controller_model' => 'InteliGen 200',
            'address' => 'Zona Franca Bogotá, Bodega 14-B, Data Center Sala 2',
            'city' => 'Bogotá',
            'status' => 'active',
            'total_operating_hours' => 12840,
            'last_maintenance_date' => '2026-07-01',
            'next_maintenance_date' => '2026-08-01',
            'maintenance_interval_hours' => 500,
        ]);

        $eq3 = Equipment::create([
            'client_id' => $clientMinera->id,
            'company_id' => $companyAdmin->id,
            'brand_id' => $brandKoh->id,
            'model_id' => $modKoh1->id,
            'serial_number' => 'KOH-KD18-2021-00334',
            'asset_code' => 'GEN-MIN-02',
            'rated_power_kw' => 1800,
            'voltage' => '4160V Medium Voltage',
            'frequency' => '60Hz',
            'fuel_type' => 'diesel',
            'application' => 'prime',
            'installation_date' => '2021-11-05',
            'controller_brand' => 'Deep Sea Electronics',
            'controller_model' => 'DSE8610 MKII',
            'address' => 'Carretera Monterrey-Saltillo Km 45, Campamento Minero Sector 4',
            'city' => 'Monterrey',
            'status' => 'maintenance',
            'total_operating_hours' => 18400,
            'last_maintenance_date' => '2026-05-15',
            'next_maintenance_date' => '2026-07-15',
            'maintenance_interval_hours' => 250,
        ]);

        // 5. Spare Parts
        $part1 = SparePart::create([
            'part_number' => 'CAT-1R-1808',
            'name' => 'Filtro de Aceite de Alta Eficiencia CAT',
            'brand' => 'Caterpillar',
            'category' => 'filtro',
            'price' => 45.00,
            'stock_quantity' => 24,
        ]);

        $part2 = SparePart::create([
            'part_number' => 'CAT-1R-0750',
            'name' => 'Filtro de Combustible Separador de Agua CAT',
            'brand' => 'Caterpillar',
            'category' => 'filtro',
            'price' => 38.50,
            'stock_quantity' => 30,
        ]);

        $part3 = SparePart::create([
            'part_number' => 'MOB-15W40-20L',
            'name' => 'Aceite Sintético para Motor Heavy Duty 15W-40 (Cubeta 20L)',
            'brand' => 'Mobil Delvac',
            'category' => 'aceite',
            'price' => 120.00,
            'stock_quantity' => 15,
        ]);

        $part4 = SparePart::create([
            'part_number' => 'CUM-FF5488',
            'name' => 'Filtro de Aire Primario Cummins QSK',
            'brand' => 'Fleetguard / Cummins',
            'category' => 'filtro',
            'price' => 65.00,
            'stock_quantity' => 12,
        ]);

        $part5 = SparePart::create([
            'part_number' => 'AVR-SX460',
            'name' => 'Regulador Automático de Voltaje (AVR) SX460 para Alternador Stamford',
            'brand' => 'Stamford',
            'category' => 'electrico',
            'price' => 180.00,
            'stock_quantity' => 8,
        ]);

        // 6. Error Code Library
        ErrorCodeLibrary::create([
            'brand_id' => $brandCat->id,
            'code' => 'SPN 100 FMI 1',
            'description' => 'Presión de aceite del motor extremadamente baja (< 18 psi en ralentí o < 30 psi en carga). Posible falla de bomba de aceite, nivel bajo o dilución con combustible.',
            'severity' => 'critical',
        ]);

        ErrorCodeLibrary::create([
            'brand_id' => $brandCum->id,
            'code' => 'SPN 110 FMI 0',
            'description' => 'Temperatura del líquido refrigerante alta (> 102°C). Verificar termostato, bandas del ventilador, nivel de anticongelante y radiador obstruido.',
            'severity' => 'high',
        ]);

        ErrorCodeLibrary::create([
            'brand_id' => $brandCat->id,
            'code' => 'SPN 168 FMI 4',
            'description' => 'Voltaje del sistema de batería por debajo del umbral mínimo de arranque (< 22.5V en bancos de 24V). Verificar cargador de baterías y alternador de acople.',
            'severity' => 'medium',
        ]);

        ErrorCodeLibrary::create([
            'brand_id' => null,
            'code' => 'E-042 (Overcrank)',
            'description' => 'El motor no arrancó después del número máximo programado de ciclos de marcha. Verificar suministro de diésel, solenoide de corte y purgado de aire.',
            'severity' => 'high',
        ]);

        // 7. Knowledge Base
        KnowledgeBase::create([
            'brand_id' => $brandCat->id,
            'model_id' => $modCat1->id,
            'category' => 'manual',
            'title' => 'Manual de Mantenimiento Preventivo 250 y 500 Horas - Caterpillar C18',
            'content' => "### Procedimiento PMP-250 CAT C18\n1. Calentar el motor por 10 minutos a 1800 RPM sin carga.\n2. Drenar cárter y reemplazar los 2 filtros de aceite (CAT 1R-1808).\n3. Reemplazar filtro primario de combustible y separador de agua (CAT 1R-0750).\n4. Rellenar con aceite 15W-40 API CK-4/CJ-4 (aprox 38 litros).\n5. Tomar muestra de aceite para análisis de laboratorio (S.O.S).\n6. Realizar prueba en vacío por 15 minutos y verificar horómetro en controlador DSE7320.",
            'approved' => true,
        ]);

        KnowledgeBase::create([
            'brand_id' => null,
            'model_id' => null,
            'category' => 'diagram',
            'title' => 'Guía de Calibración de Módulo Deep Sea Electronics DSE7320 / DSE8610',
            'content' => "### Configuración de Umbrales AVR y Arranque\n- **Voltaje Sub-Tensión (Under-voltage):** Ajustar en Parámetro 704 a 185V F-N (para sistemas de 220V).\n- **Frecuencia Sub-Frecuencia:** Ajustar en 57.0 Hz (para sistemas de 60Hz).\n- **Intentos de Arranque:** 3 intentos de 10 segundos con 10 segundos de descanso.\n- Para conexión al software DSE Configuration Suite, usar cable USB tipo A-B directo al puerto frontal.",
            'approved' => true,
        ]);

        // 8. Interventions
        // Intervention 1: Completed Preventivo in Hospital
        $int1 = Intervention::create([
            'equipment_id' => $eq1->id,
            'technician_id' => $tech1->id,
            'supervisor_id' => $supervisor->id,
            'type' => 'preventive',
            'priority' => 'normal',
            'status' => 'completed',
            'engine_model' => 'CAT C18 Acert',
            'alternator_model' => 'Stamford HCI544C',
            'total_operating_hours' => 6450,
            'symptoms' => 'Mantenimiento programado 250 horas según horómetro. El cliente reporta que la planta arrancó en prueba semanal sin novedad.',
            'error_codes' => [],
            'diagnostic_summary' => 'Inspección física y prueba en vacío satisfactoria. Todos los parámetros eléctricos en rango normal.',
            'preliminary_diagnosis' => 'Desgaste normal de filtros y fluidos por tiempo de operación.',
            'ai_suggestions' => [
                'Motor' => 'Parámetros óptimos. Se recomienda programar cambio de bandas en la intervención de 7000 horas.',
                'Alternador' => 'Resistencia de aislamiento del estator verificada > 50 Mega-Ohms.',
            ],
            'ai_confidence' => 98,
            'recommended_action' => 'inspect',
            'estimated_duration_minutes' => 180,
            'estimated_cost' => 350.00,
            'start_date' => now()->subDays(2)->setTime(9, 0),
            'completion_date' => now()->subDays(2)->setTime(12, 15),
            'actual_duration_minutes' => 195,
            'actual_cost' => 368.50,
            'technician_signature' => 'Roberto Gómez (Firma Biométrica en Tablet)',
            'client_signature' => 'Dr. Fernando Ríos (Director Infraestructura HUM)',
            'signed_at' => now()->subDays(2)->setTime(12, 20),
            'location_lat' => 19.3325,
            'location_lng' => -99.1860,
        ]);

        // Checklists for Intervention 1
        InspectionChecklist::create([
            'intervention_id' => $int1->id,
            'section' => 'engine',
            'item_description' => 'Nivel y presión de aceite de motor en operación',
            'status' => 'ok',
            'measurement_value' => '54',
            'measurement_unit' => 'psi',
            'observations' => 'Presión estable a 1800 RPM. Aceite nuevo Mobil Delvac 15W-40.',
        ]);

        InspectionChecklist::create([
            'intervention_id' => $int1->id,
            'section' => 'cooling',
            'item_description' => 'Temperatura de líquido refrigerante e integridad de mangueras',
            'status' => 'ok',
            'measurement_value' => '82',
            'measurement_unit' => '°C',
            'observations' => 'Radiador limpio sin fugas ni corrosión en el panal.',
        ]);

        InspectionChecklist::create([
            'intervention_id' => $int1->id,
            'section' => 'electrical',
            'item_description' => 'Voltaje de banco de baterías 24V y cargador automático',
            'status' => 'ok',
            'measurement_value' => '27.4',
            'measurement_unit' => 'V',
            'observations' => 'Baterías con carga óptima. Terminales libres de sulfatación.',
        ]);

        // Parts for Intervention 1
        InterventionPart::create([
            'intervention_id' => $int1->id,
            'part_id' => $part1->id,
            'quantity' => 2,
            'unit_price' => 45.00,
            'discount_percent' => 0,
            'observations' => 'Cambio de 2 filtros de aceite de motor principal.',
        ]);

        InterventionPart::create([
            'intervention_id' => $int1->id,
            'part_id' => $part2->id,
            'quantity' => 1,
            'unit_price' => 38.50,
            'discount_percent' => 0,
            'observations' => 'Filtro separador de agua primario.',
        ]);

        InterventionPart::create([
            'intervention_id' => $int1->id,
            'part_id' => $part3->id,
            'quantity' => 2,
            'unit_price' => 120.00,
            'discount_percent' => 0,
            'observations' => '40 litros de aceite sintético 15W-40.',
        ]);

        // Report for Intervention 1
        Report::create([
            'intervention_id' => $int1->id,
            'report_number' => 'REP-2026-001-HOSP',
            'report_data' => [
                'Resumen Ejecutivo' => 'Servicio de mantenimiento preventivo de 250 horas concluido de manera exitosa sin anomalías operativas.',
                'Próxima Recomendación' => 'Mantenimiento de 500 horas programado para septiembre de 2026.',
                'Estatus del Equipo' => 'Operativo al 100% en modo automático de emergencia.',
            ],
            'pdf_url' => '/report/pdf/' . $int1->id,
            'status' => 'sent',
            'generated_at' => now()->subDays(2)->setTime(12, 25),
            'sent_at' => now()->subDays(2)->setTime(12, 30),
            'technician_signed' => true,
            'client_signed' => true,
        ]);

        // Intervention 2: Corrective in Progress at CloudScale
        $int2 = Intervention::create([
            'equipment_id' => $eq2->id,
            'technician_id' => $tech2->id,
            'supervisor_id' => $supervisor->id,
            'type' => 'corrective',
            'priority' => 'high',
            'status' => 'in_progress',
            'engine_model' => 'Cummins QSK60-G6 V16',
            'alternator_model' => 'Stamford LV8042',
            'total_operating_hours' => 12840,
            'symptoms' => 'Alarma de alta temperatura de refrigerante en el controlador ComAp. El motor reduce potencia automáticamente bajo demanda > 1500 kW.',
            'error_codes' => ['SPN 110 FMI 0', 'SPN 100 FMI 1'],
            'diagnostic_summary' => 'Técnico en sitio evaluando flujo de bomba de agua del circuito primario y termostato de regulación térmica.',
            'preliminary_diagnosis' => 'Probable obstrucción parcial o falla de apertura del termostato principal de la bancada derecha.',
            'ai_suggestions' => [
                'Circuito Térmico' => 'Verificar termostato del circuito primario y flujo en radiador remoto de techo.',
                'Sensores ECU' => 'Reemplazar sensor de temperatura SPN 110 si resistencia en caliente no coincide con tabla NTC (1.2k - 1.8k Ohms).',
                'Preventivo Adicional' => 'Inspeccionar rodete y sello mecánico de la bomba de agua auxiliar.',
            ],
            'ai_confidence' => 96,
            'recommended_action' => 'repair',
            'estimated_duration_minutes' => 300,
            'estimated_cost' => 850.00,
            'start_date' => now()->subHours(3),
            'location_lat' => 4.6738,
            'location_lng' => -74.1485,
        ]);

        InspectionChecklist::create([
            'intervention_id' => $int2->id,
            'section' => 'cooling',
            'item_description' => 'Temperatura de refrigerante a la entrada y salida del radiador',
            'status' => 'critical',
            'measurement_value' => '104',
            'measurement_unit' => '°C',
            'observations' => 'Diferencial térmico entre entrada y salida < 3°C, indicando nula disipación o fallo de circulación.',
        ]);
    }
}
