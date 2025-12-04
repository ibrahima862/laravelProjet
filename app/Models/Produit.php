<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;

class Produit extends Model
{
    use HasFactory;
    protected $table = 'produits'; // 👈 OBLIGATOIRE
    protected $fillable = [
        'categorie_id',
        'name',
        'slug',
        'description',
        'price',
        'delivery_days',
        'stock',
        'img',
        'badge',
    ];

    /**
     * 🔗 Relation : un produit appartient à une catégorie
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'produit_id');
    }

    public function mainImage()
{
    return $this->hasOne(ProductImage::class, 'produit_id')
        ->where('is_main', 1)
        ->withDefault(function () {
            return new ProductImage([
                'filename' => 'images/default.png'
            ]);
        });
}


    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }
    public function prixReduit()
    {
        if (!$this->badge) return null;

        if (preg_match('/-([0-9]+)/', $this->badge, $m)) {
            $percent = (int)$m[1];
            return $this->price - ($this->price * $percent / 100);
        }

        return null;
    }
    public function specs()
    {
        return $this->hasMany(ProductSpec::class);
    }
    public function attributs()
    {
        return $this->belongsToMany(Attribut::class, 'produit_valeur_attribut');
    }

    public function attributvaleurs()
    {
        return $this->belongsToMany(AttributValeur::class, 'produit_valeur_attribut', 'produit_id', 'attribut_valeur_id')
            ->withPivot('id', 'stock')
            ->withTimestamps();
    }
    // App/Models/Produit.php

    public function reviews()
    {
        // Remplace Review::class par le modèle réel si tu l’as créé
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->count() ? round($this->reviews()->avg('rating'), 1) : null;
    }
}
