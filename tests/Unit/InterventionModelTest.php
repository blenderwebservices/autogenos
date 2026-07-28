<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Intervention;

class InterventionModelTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_json_casting_works_for_ai_suggestions(): void
    {
        $intervention = new Intervention();
        $intervention->ai_suggestions = [
            'Motor' => 'Revisar aceite',
            'Alternador' => 'Medir voltaje'
        ];
        
        $this->assertIsArray($intervention->ai_suggestions);
        $this->assertArrayHasKey('Motor', $intervention->ai_suggestions);
        $this->assertEquals('Medir voltaje', $intervention->ai_suggestions['Alternador']);
    }
}
