<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Equipment;
use App\Models\EquipmentBrand;
use App\Models\EquipmentModel;
use App\Models\Intervention;

class InterventionApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_technician_can_list_their_interventions(): void
    {
        $company = Company::factory()->create();
        
        $brand = EquipmentBrand::create(['name' => 'Brand']);
        $model = EquipmentModel::create(['name' => 'Model', 'brand_id' => $brand->id]);
        
        $equipment = Equipment::create([
            'serial_number' => '123' . rand(1, 1000), // Randomize serial to avoid unique constraint if needed
            'company_id' => $company->id,
            'brand_id' => $brand->id,
            'model_id' => $model->id
        ]);
        
        $tech1 = User::factory()->create(['role' => 'technician', 'company_id' => $company->id]);
        $tech2 = User::factory()->create(['role' => 'technician', 'company_id' => $company->id]);
        
        Intervention::create([
            'equipment_id' => $equipment->id,
            'technician_id' => $tech1->id,
            'type' => 'corrective',
            'status' => 'pending'
        ]);
        
        Intervention::create([
            'equipment_id' => $equipment->id,
            'technician_id' => $tech2->id,
            'type' => 'corrective',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($tech1, 'sanctum')->getJson('/api/interventions');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    public function test_technician_cannot_view_others_intervention(): void
    {
        $company = Company::factory()->create();
        
        $brand = EquipmentBrand::create(['name' => 'Brand']);
        $model = EquipmentModel::create(['name' => 'Model', 'brand_id' => $brand->id]);
        
        $equipment = Equipment::create([
            'serial_number' => '123' . rand(1, 1000), // Randomize serial to avoid unique constraint if needed
            'company_id' => $company->id,
            'brand_id' => $brand->id,
            'model_id' => $model->id
        ]);
        
        $tech1 = User::factory()->create(['role' => 'technician', 'company_id' => $company->id]);
        $tech2 = User::factory()->create(['role' => 'technician', 'company_id' => $company->id]);
        
        $intervention = Intervention::create([
            'equipment_id' => $equipment->id,
            'technician_id' => $tech2->id,
            'type' => 'corrective',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($tech1, 'sanctum')->getJson("/api/interventions/{$intervention->id}");

        $response->assertStatus(403);
    }
}
