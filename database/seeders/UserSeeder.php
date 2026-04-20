<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'email' => 'admin@example.com',
            'first_name' => 'Admin',
            'middle_name' => 'O',
            'last_name' => 'Doe',
            'password' => Hash::make('12345678'),
            'role' => 'admin'
        ]);
        User::create([
            'email' => 'guest@example.com',
            'first_name' => 'Guest',
            'middle_name' => 'O',
            'last_name' => 'User',
            'password' => Hash::make('12345678'),
            'role' => 'guest'
        ]);

        // foreach (range(1, 20) as $index) {
        //     User::create([
        //         'first_name' => Str::random(5),
        //         'middle_name' => Str::random(1),
        //         'last_name' => Str::random(10),
        //         'email' => Str::random(10) . '@example.com',
        //         'password' => Hash::make('12345678'),
        //         'role_id' => 2

        //     ]);
        // }
    }
}
