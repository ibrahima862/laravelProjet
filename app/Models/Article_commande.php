<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article_commande extends Model
{
    use HasFactory;

    protected $table = 'article_commandes';

    protected $fillable = [
        'commande_id',
        'produit_id',
        'produit_valeur_attribut_id', // ✅ Ajouter taille_id ici
        'quantity',
        'price',
        'created_at',
        'updated_at'
    ];

    // Relation vers le produit
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    // Relation vers la taille
    public function taille() 
    {
        return $this->belongsTo(Produit::class, 'produit_valeur_attribut_id');
    }
        public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
