<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Role;
use Tests\TestCase;

class userTest extends TestCase {
    public function setUp(): void {
        parent::setUp();
        $this->artisan('db:seed --class=RoleSeeder');
        $this->user = User::factory()->create();
        $this->user->roles()->attach(Role::USER);
    }

    public function test_user_can_access_home_page(){
        $response = $this->actingAs($this->user)->get('/');
        $response->assertStatus(200);
    }

    public function test_user_can_access_products_page(){
        $response = $this->actingAs($this->user)->get('/products');
        $response->assertStatus(200);
    }

    public function test_user_can_not_access_dashboard(){
        $response = $this->actingAs($this->user)->get('/dashboard');
        $response->assertStatus(403);
    }

    public function test_user_can_not_access_dashcube(){
        $response = $this->actingAs($this->user)->get('/dashcube');
        $response->assertStatus(403);
    }
}
