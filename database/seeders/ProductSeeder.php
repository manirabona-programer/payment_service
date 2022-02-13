<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('products')->truncate();

        Product::create(['id' => 1, 'name' => 'Sand Crows Chips', 'quantity' => '4', 'price' => '6000']);
        Product::create(['id' => 2, 'name' => 'Flipp Pizza', 'quantity' => '4', 'price' => '10000']);
        Product::create(['id' => 3, 'name' => 'Hot Water Coffee', 'quantity' => '2', 'price' => '1000']);
        Product::create(['id' => 4, 'name' => 'Moringa Salad', 'quantity' => '7', 'price' => '4500']);
        Product::create(['id' => 5, 'name' => 'Bill Cakes', 'quantity' => '6', 'price' => '2000']);
        Product::create(['id' => 6, 'name' => 'Rolex Milk', 'quantity' => '3', 'price' => '9000']);
    }
}
