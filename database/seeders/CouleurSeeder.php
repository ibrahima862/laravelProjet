<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Couleur;

class CouleurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Rouge', 'hex_code' => '#FF0000'],
            ['name' => 'Bleu', 'hex_code' => '#0000FF'],
            ['name' => 'Vert', 'hex_code' => '#00FF00'],
            ['name' => 'Noir', 'hex_code' => '#000000'],
            ['name' => 'Blanc', 'hex_code' => '#FFFFFF'],
            ['name' => 'Jaune', 'hex_code' => '#FFFF00'],
            ['name' => 'Orange', 'hex_code' => '#FFA500'],
            ['name' => 'Violet', 'hex_code' => '#800080'],
        ];

        foreach ($colors as $color) {
            Couleur::create($color);
        }
    }
}
