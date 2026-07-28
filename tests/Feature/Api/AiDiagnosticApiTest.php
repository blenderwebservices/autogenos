<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Equipment;
use App\Models\EquipmentBrand;
use App\Models\EquipmentModel;
use App\Models\Intervention;

class AiDiagnosticApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_technician_can_generate_ai_diagnostic(): void
    {
        $company = Company::factory()->create();
        
        $brand = EquipmentBrand::create(['name' => 'Brand']);
        $model = EquipmentModel::create(['name' => 'Model', 'brand_id' => $brand->id]);
        
        $equipment = Equipment::create([
            'serial_number' => '12345',
            'company_id' => $company->id,
            'brand_id' => $brand->id,
            'model_id' => $model->id
        ]);
        
        $technician = User::factory()->create(['role' => 'technician', 'company_id' => $company->id]);
        
        $intervention = Intervention::create([
            'equipment_id' => $equipment->id,
            'technician_id' => $technician->id,
            'type' => 'corrective',
            'status' => 'pending',
            'symptoms' => 'No enciende',
            'error_codes' => ['E01']
        ]);

        $mockResponse = [
            'candidates' => [
                [
                    'content' => [
                        'parts' => [
                            [
                                'text' => json_encode([
                                    'ai_suggestions' => ['Motor' => 'Revisar batería'],
                                    'ai_confidence' => 95,
                                    'recommended_action' => 'repair'
                                ])
                            ]
                        ]
                    ]
                ]
            ]
        ];

        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response($mockResponse, 200)
        ]);

        $response = $this->actingAs($technician, 'sanctum')
            ->postJson("/api/interventions/{$intervention->id}/ai-diagnostic");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Diagnóstico generado exitosamente'
        ]);
        
        $this->assertDatabaseHas('interventions', [
            'id' => $intervention->id,
            'ai_confidence' => 95,
            'recommended_action' => 'repair'
        ]);
    }
}
