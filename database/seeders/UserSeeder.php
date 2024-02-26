<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => "Ikonic",
            'mobile_no' => "12345678900",
            'email' => 'ikonic@mailinator.com',
            'password' => bcrypt('password'),
        ]);
    }
}
