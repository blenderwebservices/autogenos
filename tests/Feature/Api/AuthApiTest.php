<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_and_get_token(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create([
            'email' => 'test@gentech.com',
            'password' => bcrypt('password123'),
            'company_id' => $company->id,
            'is_active' => true
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@gentech.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'user' => [
                'id',
                'email'
            ]
        ]);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create([
            'email' => 'test@gentech.com',
            'password' => bcrypt('password123'),
            'company_id' => $company->id
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@gentech.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(401);
    }
}
