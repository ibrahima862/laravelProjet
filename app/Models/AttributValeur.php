<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributValeur extends Model
{
    protected $table = 'attribut_valeurs'; // si ton nom de table est valeur_attribut (singulier), change ici

    protected $fillable = [
        'attribut_id',
        'value',
        'description',
    ];

    public function attribut()
    {
        return $this->belongsTo(Attribut::class, 'attribut_id');
    }
   public function produits()
{
    return $this->belongsToMany(Produit::class, 'produit_valeur_attribut', 'attribut_valeur_id', 'produit_id')
                ->withPivot('stock')
                ->withTimestamps();
}


}
