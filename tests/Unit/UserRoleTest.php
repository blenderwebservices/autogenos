<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Models\Company;

class UserRoleTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_user_can_have_roles(): void
    {
        $user = new User();
        $user->role = 'admin';
        
        $this->assertEquals('admin', $user->role);
        
        $user->role = 'technician';
        $this->assertEquals('technician', $user->role);
    }
}
