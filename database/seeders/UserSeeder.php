<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'first_name' => 'John',
            'middle_name' => 'O',
            'last_name' => 'Doe',
            'password' => Hash::make('12345678')
        ]);
    }
}
