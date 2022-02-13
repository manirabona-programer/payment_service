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
        $this->super_admin = User::factory()->create();
        $this->super_admin->roles()->attach(Role::SUPER_ADMIN);
    }

    public function test_super_admin_can_access_dashcube(){
        $response = $this->actingAs($this->super_admin)->get('/dashcube');
        $response->assertStatus(200);
    }

    public function test_super_admin_can_assign_role(){
        $role = $this->actingAs($this->super_admin)->put('/');
    }
}
