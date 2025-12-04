<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LivraisonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('livraisons')->insert([
            [
                'type' => 'Standard',
                'price' => 2000,
                'region' => 'National',
                'estimated_days' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Express',
                'price' => 5000,
                'region' => 'National',
                'estimated_days' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Point relais',
                'price' => 1500,
                'region' => 'National',
                'estimated_days' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
