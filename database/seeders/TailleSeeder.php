<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Taille;

class TailleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tailles = [
            // Tailles vêtements
            ['name' => 'S', 'type' => 'vetement'],
            ['name' => 'M', 'type' => 'vetement'],
            ['name' => 'L', 'type' => 'vetement'],
            ['name' => 'XL', 'type' => 'vetement'],
            ['name' => 'XXL', 'type' => 'vetement'],

            // Tailles chaussures (EU)
            ['name' => '36', 'type' => 'chaussure'],
            ['name' => '37', 'type' => 'chaussure'],
            ['name' => '38', 'type' => 'chaussure'],
            ['name' => '39', 'type' => 'chaussure'],
            ['name' => '40', 'type' => 'chaussure'],
            ['name' => '41', 'type' => 'chaussure'],
            ['name' => '42', 'type' => 'chaussure'],
        ];

        foreach ($tailles as $taille) {
            Taille::create($taille);
        }
    }
}
