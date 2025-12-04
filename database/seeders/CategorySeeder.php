<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Jouets & Enfants' => [
                'Jeux de société',
                'Poupées & Figurines',
                'Puériculture',
                'Véhicules miniatures'
            ],
            'Automobile' => [
                'Pièces & Accessoires',
                'Entretien & Réparation',
                'GPS & Accessoires auto'
            ],
            'Bricolage & Jardin' => [
                'Outils & Équipements',
                'Jardinage',
                'Décoration extérieure'
            ],
            'Musique & Instruments' => [
                'Instruments de musique',
                'Accessoires',
                'CD & Vinyles'
            ],
            'Papeterie & Bureau' => [
                'Fournitures de bureau',
                'Matériel scolaire',
                'Organisation & Rangement'
            ],
            'Épicerie' => [
                'Alimentation & Boissons',
                'Produits bio & diététiques',
                'Coffrets cadeaux'
            ],
            'Électronique' => [
                'Smartphones & Accessoires',
                'Téléviseurs & Home cinéma',
                'Appareils photo',
                'Casques & Écouteurs',
                'Objets connectés'
            ],
            'Informatique' => [
                'Ordinateurs portables',
                'Composants PC',
                'Périphériques & Accessoires',
                'Stockage & Mémoire',
                'Logiciels'
            ],
            'Mode' => [
                'Femme' => [
                    'Robes',
                    'Chaussures femme',
                    'Sacs & Accessoires',
                    'Vêtements femme',
                    'montre femme'
                ],
                'Homme' => [
                    'Vestes & Manteaux',
                    'Chaussures homme',
                    'Accessoires homme',
                    'T-shirts & Chemises',
                    'montre homme'
                ],
                'Enfants' => [
                    'Vêtements homme',
                    'Chaussure enfants',
                    'Jouets & Jeux'
                ]
            ],
            'Maison & Cuisine' => [
                'Meubles',
                'Décoration',
                'Electroménager',
                'Cuisine & Ustensiles'
            ],
            'Sport & Plein air' => [
                'Fitness & Musculation',
                'Camping & Randonnée',
                'Sports collectifs',
                'Cyclisme'
            ],
            'Beauté & Santé' => [
                'Cosmétiques',
                'Parfums',
                'Produits de soin',
                'Santé & Bien-être'
            ]
        ];

        foreach ($categories as $name => $children) {
            $this->createCategory($name, $children);
        }
    }

    private function createCategory($name, $children = null, $parentId = null)
    {
        // Vérifie si la catégorie existe déjà
        $category = Categorie::where('name', $name)
            ->where('parent_id', $parentId)
            ->first();

        if (!$category) {
            $category = Categorie::create([
                'name' => $name,
                'slug' => $this->makeUniqueSlug($name, $parentId),
                'icon' => $this->getIconForCategory($name),
                'parent_id' => $parentId,
                'image' => $this->getImageForCategory($name), // ← ajout de l'image
            ]);
        }

        if ($children && is_array($children)) {
            foreach ($children as $key => $child) {
                if (is_array($child)) {
                    // Cas où le nom du parent est la clé
                    $this->createCategory($key, $child, $category->id);
                } else {
                    $this->createCategory($child, null, $category->id);
                }
            }
        }
    }

    private function makeUniqueSlug($name, $parentId)
    {
        $slug = Str::slug($name);
        $count = Categorie::where('slug', 'like', $slug . '%')
            ->where('parent_id', $parentId)
            ->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    private function getIconForCategory($name)
    {
        $icons = [
            'Jouets & Enfants' => 'fa-solid fa-folder',
            'Automobile' => 'fa-solid fa-car',
            'Bricolage & Jardin' => 'fa-solid fa-hammer',
            'Musique & Instruments' => 'fa-solid fa-music',
            'Papeterie & Bureau' => 'fa-solid fa-pen-to-square',
            'Épicerie' => 'fa-solid fa-basket-shopping',
            'Électronique' => 'fa-solid fa-tv',
            'Informatique' => 'fa-solid fa-laptop',
            'Mode' => 'fa-solid fa-shirt',
            'Maison & Cuisine' => 'fa-solid fa-couch',
            'Sport & Plein air' => 'fa-solid fa-dumbbell',
            'Beauté & Santé' => 'fa-solid fa-sparkles'
        ];

        return $icons[$name] ?? 'fa-solid fa-folder';
    }
    private function getImageForCategory($name)
{
    $images = [
        'Jouets & Enfants' => 'categories/jouet&enfant.jpg',
        'Automobile' => 'categories/automobile.jpg',
        'Bricolage & Jardin' => 'categories/bricolage.jpg',
        'Musique & Instruments' => 'categories/musique.jpg',
        'Papeterie & Bureau' => 'categories/papeterie.jpg',
        'Épicerie' => 'categories/epicerie.jpg',
        'Électronique' => 'categories/electronique.jpg',
        'Informatique' => 'categories/informatique.jpg',
        'Mode' => 'categories/mode.jpg',
        'Maison & Cuisine' => 'categories/maison.jpg',
        'Sport & Plein air' => 'categories/sport.jpg',
        'Beauté & Santé' => 'categories/beaute.jpg',
    ];

    return $images[$name] ?? 'categories/default.jpg';
}

}
