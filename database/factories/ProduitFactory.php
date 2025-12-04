<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProduitFactory extends Factory
{
    public function definition(): array
    {
        $noms = [
            'Montre', 'Ordinateur', 'Téléphone', 'Casque', 'Clavier',
            'Souris', 'Chaussures', 'Sac', 'Bouteille', 'Caméra'
        ];

        // Choisit un nom aléatoire
        $nom = $this->faker->randomElement($noms);

        // Génère une image correspondant au nom
        // Exemple : "montre.jpg", "ordinateur.jpg", etc.
        $image = strtolower($nom) . '.jpg';

        return [
            'name' => $nom,
            'prix' => $this->faker->numberBetween(100, 1000),
            'quantite' => $this->faker->numberBetween(1, 100),
            'img' => $image,
        ];
    }
}
