<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('users')->truncate();
        User::create([
            'id' => 1,
            'name' => 'Michell B Cold',
            'email' => 'michecllbcold@yahoo.com',
            'password' => Hash::make('michecllbcold'),
            'role_id' => Role::SUPER_ADMIN,
            'royalty_points' => 0,
            'is_member' => true,
        ]);
    }
}
