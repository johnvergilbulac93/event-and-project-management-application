<?php

namespace Database\Seeders;

use App\Models\Purok;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Purok::truncate();
        Purok::insert([
            ['name' => 'Purok 1'],
            ['name' => 'Purok 2'],
            ['name' => 'Purok 3'],
            ['name' => 'Purok 4'],
            ['name' => 'Purok 5'],
            ['name' => 'Purok 6'],
            ['name' => 'Purok 7'],
        ]);
    }
}
