<?php

namespace Tests\Feature;

use App\Models\Config;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Role;
use Tests\TestCase;

class adminTest extends TestCase {
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->artisan('db:seed');
        $this->user = User::factory()->create(['role_id' => Role::ADMIN]);
        $this->admin = User::factory()->create(['role_id' => Role::ADMIN]);
    }

    /** test admin can access dashbaord */
    public function test_admin_can_access_dashboard(){
        $response = $this->actingAs($this->admin)->get('/dashboard');
        $response->assertStatus(200);
    }

    /** test admin can not access dashbcube (super admin page) */
    public function test_admin_can_not_access_dashcube(){
        $response = $this->actingAs($this->admin)->get('/dashcube');
        $response->assertStatus(403);
    }

    /** test admin can create and add config */
    public function test_admin_can_add_config(){
        $response = $this->actingAs($this->admin)->post('config',['name'=>'SHS', 'value' => 2]);
        $response->assertStatus(200);
    }

    /** test admin can access avaliable configs */
    public function test_admin_can_access_configs(){
        $response = $this->actingAs($this->admin)->get('/config');
        $response->assertStatus(200);
    }

    /** test admin can update any config */
    public function test_admin_can_update_config(){
        $config = Config::factory()->create(['name' => 'BSI', 'activated' => false]);
        $this->assertDatabaseHas('configs', ['name' => 'BSI']);

        $update = $this->actingAs($this->admin)->put('/config/'.$config->id, ['name' => 'Lock', 'activated' => true, 'value' => '2']);
        $update->assertStatus(200);
        $this->assertDatabaseHas('configs', ['name' => 'Lock']);
    }

    /** test admin can delete any config */
    public function test_admin_can_delete_config(){
        $config = Config::factory()->create();
        $this->assertTrue(Config::all()->count() == 8);

        $delete = $this->actingAs($this->admin)->delete('/config/'.$config->id);
        $delete->assertStatus(200);
        $this->assertTrue(Config::all()->count() == 7);
    }

    /** test admin can not assign new role to any user */
    public function test_admin_can_not_assign_roles(){
        $response = $this->actingAs($this->admin)->put('/user/'.$this->user->id.'/role', ["role_id" => Role::USER]);
        $response->assertStatus(403);
        $this->assertDatabaseHas('users', ['role_id' => Role::ADMIN]);
    }
}
