<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Role;
use Tests\TestCase;

class userTest extends TestCase {
    public function test_user_can_access_home_page(){
        $user = User::factory()->create();
        $user->roles()->attach(Role::USER);

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
    }

    public function test_user_can_access_products_page(){
        $user = User::factory()->create();
        $user->roles()->attach(Role::USER);

        $response = $this->actingAs($user)->get('/products');
        $response->assertStatus(200);
    }

    public function test_user_can_not_access_dashboard(){
        $user = User::factory()->create();
        $user->roles()->attach(Role::USER);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(403);
    }

    public function test_user_can_not_access_dashcube(){
        $user = User::factory()->create();
        $user->roles()->attach(Role::USER);

        $response = $this->actingAs($user)->get('/dashcube');
        $response->assertStatus(403);
    }
}
