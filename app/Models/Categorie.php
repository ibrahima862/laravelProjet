<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'icon'
    ];

    public function children()
    {
        return $this->hasMany(Categorie::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Categorie::class, 'parent_id');
    }
    public function produits()
    {
        return $this->hasMany(Produit::class, 'categorie_id');
    }
    public function attributs()
    {
        return $this->belongsToMany(Attribut::class, 'categorie_attribut', 'categorie_id', 'attribut_id')
            ->with('valeurs');
    }
  public function allProduitsRecursive()
{
    $produits = collect();

    // Produits de cette catégorie
    if ($this->produits) {
        $produits = $produits->merge($this->produits);
    }

    // Produits des catégories enfants (multi-niveaux)
    foreach ($this->children as $child) {
        $produits = $produits->merge($child->allProduitsRecursive());
    }

    return $produits;
}

}
