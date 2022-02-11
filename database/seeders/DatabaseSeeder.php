<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        \DB::table('users')->truncate();

        User::create([
            'id' => 1,
            'name' => 'Megan K Richson',
            'email' => 'hseal419@gmail.com',
            'email_verified_at' => '',
            'password' => 'NMGH%^OHSB',
            'remember_token' => ''
        ]);
    }
}
