<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'produit_id',
        'produit_valeur_attribut_id', // remplacer taille_id par attribut_valeur_id
        'quantity',
    ];

    // Relation vers le produit
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id', 'id');
    }

    // Relation vers l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation vers la valeur d'attribut choisie
 public function variation()
{
    return $this->belongsTo(Produit_valeur_attribut::class, 'produit_valeur_attribut_id');
}

}
