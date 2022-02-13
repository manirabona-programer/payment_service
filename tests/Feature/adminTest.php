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
        $this->artisan('db:seed --class=RoleSeeder');
        $this->admin = User::factory()->create();
        $this->admin->roles()->attach(Role::ADMIN);
    }

    public function test_admin_can_access_dashboard(){
        $response = $this->actingAs($this->admin)->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_admin_can_not_access_dashcube(){
        $response = $this->actingAs($this->admin)->get('/dashcube');
        $response->assertStatus(403);
    }

    public function test_admin_can_add_config(){
        $response = $this->actingAs($this->admin)->post('/config',
            ['name'=>'SHS', 'activated' => true, 'value' => 2]
        );
        $response->assertStatus(200);
        $this->assertTrue(Config::all()->count() == 1);
    }

    public function test_admin_can_access_configs(){
        $response = $this->actingAs($this->admin)->get('/config');
        $response->assertStatus(200);
    }

    public function test_admin_can_update_config(){
        $config = Config::factory()->create(['name' => 'BSI', 'activated' => false]);
        $this->assertDatabaseHas('configs', ['name' => 'BSI']);

        $update = $this->actingAs($this->admin)->put('/config/'.$config->id, ['name' => 'Lock', 'activated' => true, 'value' => '2']);
        $update->assertStatus(200);
        $this->assertDatabaseHas('configs', ['name' => 'Lock']);
    }

    public function test_admin_can_delete_config(){
        $config = Config::factory()->create();
        $this->assertTrue(Config::all()->count() == 1);

        $delete = $this->actingAs($this->admin)->delete('/config/'.$config->id);
        $delete->assertStatus(200);
        $this->assertTrue(Config::all()->count() == 0);
    }
}
