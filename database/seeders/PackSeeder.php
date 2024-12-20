<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pack;

class PackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach([250, 500, 1000, 2000, 5000] as $quantity) {
            Pack::create(['quantity' => $quantity]);
        }
    }
}
