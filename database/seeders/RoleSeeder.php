<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \DB::table('roles')->truncate();

        Role::create(['id' => 1, 'name' => 'user']);
        Role::create(['id' => 2, 'name' => 'admin']);
        Role::create(['id' => 3, 'name' => 'super_admin']);
    }
}
