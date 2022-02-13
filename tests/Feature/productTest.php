<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Role;
use App\Models\Config;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\PaymentController;
use Tests\TestCase;

class productTest extends TestCase {
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->artisan('db:seed --class=RoleSeeder');
        $this->user = User::factory()->create();
        $this->admin = User::factory()->create();
        $this->user->roles()->attach(Role::USER);
        $this->admin->roles()->attach(Role::ADMIN);
    }

    public function test_user_can_access_products(){
        $response = $this->actingAs($this->user)->get('/products');
        $response->assertStatus(200);
    }

    public function test_user_can_access_single_product(){
        $product = Product::factory()->create();
        $response = $this->actingAs($this->user)->get('/products/'.$product->id);
        $response->assertStatus(200);
    }

    public function test_user_can_pay_product_and_get_loyalty_point(){
        $loyalty = new PaymentController();
        $loyalty->processPayment(5000);
        $this->assertEquals($loyalty['earned_point'], 1);
    }

    public function test_user_can_pay_product_and_not_get_loyalty_point(){
        $loyalty = new PaymentController();
        $loyalty->processPayment(2000);
        $this->assertEquals($loyalty['earned_point'], 0);
    }

    public function test_admin_can_create_product(){
        $response = $this->actingAs($this->admin)->post('products', ['name' => 'Socket', 'quantity'=> 4, 'price' => '2000']);
        $response->assertStatus(200);
    }

    public function test_user_can_not_create_product(){
        $response = $this->actingAs($this->user)->post('products', ['name' => 'Socket', 'quantity'=> 4, 'price' => '2000']);
        $response->assertStatus(403);
    }

    public function test_admin_can_access_product(){
        $product = Product::factory()->create();
        $response = $this->actingAs($this->admin)->get('/products/'.$product->id);
        $response->assertStatus(200);
    }
    public function test_admin_can_update_product(){
        $product = Product::factory()->create(['name' => 'shake_bold', 'quantity' => 4, 'price' => '3000']);
        $this->assertDatabaseHas('products', ['name' => 'shake_bold']);

        $update = $this->actingAs($this->admin)->put('/products/'.$product->id, ['name' => 'bold_shake', 'quantity' => 4, 'price' => '3000']);
        $update->assertStatus(200);
        $this->assertDatabaseHas('products', ['name' => 'bold_shake']);
    }
    public function test_user_can_not_update_product(){
        $this->withoutExceptionHandling();
        $product = Product::factory()->create(['name' => 'shake_bold', 'quantity' => 4, 'price' => '3000']);
        $this->assertDatabaseHas('products', ['name' => 'shake_bold']);

        $update = $this->actingAs($this->user)->put('/products/'.$product->id, ['name' => 'bold_shake', 'quantity' => 4, 'price' => '3000']);
        $update->assertStatus(200);
        $this->assertDatabaseHas('products', ['name' => 'bold_shake']);
    }

    public function test_admin_can_delete_product(){
        $this->withoutExceptionHandling();
        $product = Product::factory()->create();
        $this->assertTrue(Product::all()->count() == 1);

        $response = $this->actingAs($this->admin)->delete('/products/'.$product->id);
        $response->assertStatus(200);
        $this->assertTrue(Product::all()->count() == 0);
    }

    public function test_user_can_not_delete_product(){
        $this->withoutExceptionHandling();
        $product = Product::factory()->create();
        $this->assertTrue(Product::all()->count() == 1);

        $response = $this->actingAs($this->user)->delete('/products/'.$product->id);
        $response->assertStatus(200);
        $this->assertTrue(Product::all()->count() == 1);
    }
}
