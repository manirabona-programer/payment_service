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
        $this->user = User::factory()->create(['role_id' => Role::USER]);
        $this->super_admin = User::factory()->create(['role_id' => Role::SUPER_ADMIN]);
    }

    /** test super admin can access dashcube page */
    public function test_super_admin_can_access_dashcube(){
        $response = $this->actingAs($this->super_admin)->get('/dashcube');
        $response->assertStatus(200);
    }

    /** test super admin can not access dashboard page (admin page) */
    public function test_super_admin_can_not_access_dashboard(){
        $response = $this->actingAs($this->super_admin)->get('/dashboard');
        $response->assertStatus(403);
    }

    /** test super admin can access products page */
    public function test_super_admin_can_access_products(){
        $response = $this->actingAs($this->super_admin)->get('/products');
        $response->assertStatus(200);
    }

    /** test super admin can assign new role to any user */
    public function test_super_admin_can_assign_roles(){
        $response = $this->actingAs($this->super_admin)->put('/users/'.$this->user->id, ["role_id" => Role::ADMIN]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['role_id' => Role::ADMIN]);
    }
}
