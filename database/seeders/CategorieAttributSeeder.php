<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Categorie;
use App\Models\Attribut;

class CategorieAttributSeeder extends Seeder
{
    public function run(): void
    {
        $attribs = Attribut::all()->keyBy('name'); // tous les attributs disponibles

        Categorie::all()->each(function ($categorie) use ($attribs) {
            $toAttach = [];

            // récupère la catégorie et tous ses parents
            $categoriesToCheck = collect([$categorie->name]);
            $parent = $categorie->parent;
            while ($parent) {
                $categoriesToCheck->push($parent->name);
                $parent = $parent->parent;
            }

            foreach ($categoriesToCheck as $catName) {
                $name = strtolower($catName);

                // Attributs pour vêtements et chaussures
                if (str_contains($name, 'chaussure') || str_contains($name, 'robe') || str_contains($name, 't-shirt') || str_contains($name, 'vêtement')) {
                    $toAttach = array_merge($toAttach, ['Taille', 'Couleur', 'Matière']);
                }
                // Sacs
                elseif (str_contains($name, 'sac')) {
                    $toAttach = array_merge($toAttach, ['Couleur', 'Matière']);
                }
                // Produits électroniques
                elseif (str_contains($name, 'smartphone') || str_contains($name, 'ordinateur') || str_contains($name, 'téléviseur') || str_contains($name, 'appareil photo') || str_contains($name, 'casque')) {
                    $toAttach = array_merge($toAttach, ['Couleur', 'Stockage', 'RAM', 'Marque']);
                }
                // Alimentation / Épicerie
                elseif (str_contains($name, 'aliment') || str_contains($name, 'produit bio') || str_contains($name, 'coffret')) {
                    $toAttach = array_merge($toAttach, ['Poids', 'Goût', 'Marque']);
                }
                // Autres catégories génériques
                else {
                    $toAttach = array_merge($toAttach, ['Couleur']);
                }
            }

            // Supprimer les doublons
            $toAttach = array_unique($toAttach);

            foreach ($toAttach as $attrName) {
                if (isset($attribs[$attrName])) {
                    DB::table('categorie_attribut')->updateOrInsert([
                        'categorie_id' => $categorie->id,
                        'attribut_id' => $attribs[$attrName]->id,
                    ]);
                }
            }
        });
    }
}
