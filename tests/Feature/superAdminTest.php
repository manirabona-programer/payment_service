<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class superAdminTest extends TestCase {
    use RefreshDatabase; 
    
    public function setUp(): void {
        parent::setUp();
        $this->artisan('db:seed --class=RoleSeeder');
        $this->super = User::factory()->create();
        $this->super->roles()->attach(Role::SUPER_ADMIN);
    }

    public function test_super_admin_can_access_dashcube(){
        $response = $this->actingAs($this->super)->get('/dashcube');
        $response->assertStatus(200);
    }

    public function test_super_admin_can_assign_role(){
        $this->withoutExceptionHandling();
        $role = User::factory()->create();
        $this->assertTrue(User::all()->count() == 2);
    }
}
