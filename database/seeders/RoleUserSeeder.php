<?php

namespace Database\Seeders;

use App\Models\RoleUser;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \DB::table('role_user')->truncate();

        RoleUser::create(['id' => 1, 'role_id' => 3, 'user_id' => 1]);
    }
}
