<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribut;
use App\Models\AttributValeur;
use App\Models\ValeurAttribut;

class AttributSeeder extends Seeder
{
    public function run(): void
    {
        // ====== ATTRIBUTS VÊTEMENTS =======
        $this->createAttribut("Taille", [
            "S", "M", "L", "XL", "XXL", "38", "39", "40", "41", "42", "43", "44"
        ]);

        $this->createAttribut("Couleur", [
            "Noir", "Blanc", "Rouge", "Bleu", "Vert", "Jaune", "Rose", "Gris", "Marron"
        ]);

        $this->createAttribut("Matière", [
            "Coton", "Cuir", "Polyester", "Synthétique"
        ]);

        // ====== ATTRIBUTS TÉLÉPHONES =======
        $this->createAttribut("Stockage", [
            "16 Go", "32 Go", "64 Go", "128 Go", "256 Go"
        ]);

        $this->createAttribut("RAM", [
            "2 Go", "4 Go", "6 Go", "8 Go", "12 Go", "16 Go"
        ]);

        $this->createAttribut("Système", [
            "Android", "iOS", "Windows"
        ]);

        $this->createAttribut("État", [
            "Neuf", "Reconditionné"
        ]);

        // ====== ATTRIBUTS GENERAUX =======
        $this->createAttribut("Marque", [
            "Samsung", "Apple", "Nike", "Adidas", "Xiaomi", "Sony", "LG"
        ]);

        $this->createAttribut("Capacité", [
            "1L", "5L", "10L", "20L"
        ]);
    }

    private function createAttribut($name, array $values)
    {
        $attribut = Attribut::create([
            'name' => $name,
            'description' => null,
        ]);

        foreach ($values as $value) {
            AttributValeur::create([
                'attribut_id' => $attribut->id,
                'value' => $value,
                'description' => null,
            ]);
        }
    }
}
