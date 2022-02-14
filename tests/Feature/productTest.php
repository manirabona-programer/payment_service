<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class productTest extends TestCase {
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->artisan('db:seed --class=RoleSeeder');
        $this->user = User::factory()->create(['role_id' => Role::USER]);
        $this->admin = User::factory()->create(['role_id' => Role::ADMIN]);
    }

    /** test user can access products page */
    public function test_user_can_access_products(){
        $response = $this->actingAs($this->user)->get('/products');
        $response->assertStatus(200);
    }

    /** test user can access single product */
    public function test_user_can_access_single_product(){
        $product = Product::factory()->create();
        $response = $this->actingAs($this->user)->get('/products/'.$product->id);
        $response->assertStatus(200);
    }

    /** test user can pay single product */
    public function test_user_can_pay_product(){
        $product = Product::factory()->create();
        // $this->assertTrue(Product::all()->count() == 7);

        $response = $this->actingAs($this->user)->get('/products/'.$product->id.'/pay');
        $response->assertStatus(302);
    }

    /** test admin can create and add a product */
    public function test_admin_can_create_product(){
        $response = $this->actingAs($this->admin)->post('products',
                        ['name' => 'Socket', 'quantity'=> 4, 'price' => '2000']
                    );
        $response->assertStatus(200);
    }

    /** test user can not create even single product */
    public function test_user_can_not_create_product(){
        $response = $this->actingAs($this->user)->post('products',
                        ['name' => 'Socket', 'quantity'=> 4, 'price' => '2000']
                    );
        $response->assertStatus(403);
    }

    /** test admin can access product page */
    public function test_admin_can_access_product(){
        $product = Product::factory()->create();
        $response = $this->actingAs($this->admin)->get('/products/'.$product->id);
        $response->assertStatus(200);
    }

    /** test admin can update product */
    public function test_admin_can_update_product(){
        $product = Product::factory()->create(['name' => 'shake_bold']);
        $this->assertDatabaseHas('products', ['name' => 'shake_bold']);

        $update = $this->actingAs($this->admin)->put('/products/'.$product->id, ['name' => 'bold_shake']);
        $update->assertStatus(200);
        $this->assertDatabaseHas('products', ['name' => 'bold_shake']);
    }

    /** test user can not update product */
    public function test_user_can_not_update_product(){
        $this->withoutExceptionHandling();
        $product = Product::factory()->create(['name' => 'shake_bold']);
        $this->assertDatabaseHas('products', ['name' => 'shake_bold']);

        $update = $this->actingAs($this->user)->put('/products/'.$product->id, ['name' => 'bold_shake']);
        $update->assertStatus(403);
    }

    /** test admin can delete any product */
    public function test_admin_can_delete_product(){
        $product = Product::factory()->create();
        $this->assertTrue(Product::all()->count() == 1);

        $response = $this->actingAs($this->admin)->delete('/products/'.$product->id);
        $response->assertStatus(200);
        $this->assertTrue(Product::all()->count() == 0);
    }

    /** test user can not delete even single product */
    public function test_user_can_not_delete_product(){
        $product = Product::factory()->create();
        $this->assertTrue(Product::all()->count() == 1);

        $response = $this->actingAs($this->user)->delete('/products/'.$product->id);
        $response->assertStatus(403);
        $this->assertTrue(Product::all()->count() == 1);
    }
}
