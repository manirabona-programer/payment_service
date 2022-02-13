<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \DB::table('configs')->truncate();

        Config::create(['id' => 1, 'name' => 'vat', 'activated' => true, 'value'=>'18 / 100']);
        Config::create(['id' => 2, 'name' => 'discount', 'activated' => true, 'value'=>'2 / 100']);
        Config::create(['id' => 3, 'name' => 'coupon', 'activated' => true, 'value'=>'3 / 100']);
        Config::create(['id' => 4, 'name' => 'transaction_fees', 'activated' => true, 'value'=>'1000']);
        Config::create(['id' => 5, 'name' => 'loyalty_single_point_amount', 'activated' => true, 'value'=>'3000']);
        Config::create(['id' => 6, 'name' => 'loyalty_check_point_amount', 'activated' => true, 'value'=>'20000']);
        Config::create(['id' => 7, 'name' => 'loyalty_check_point', 'activated' => true, 'value'=>'10']);
    }
}
