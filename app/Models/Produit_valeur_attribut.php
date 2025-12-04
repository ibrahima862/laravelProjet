<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit_valeur_attribut extends Model
{
    protected $table = 'produit_valeur_attribut';

    protected $fillable = [
        'produit_id',
        'attribut_valeur_id',
        'stock'
    ];

    public function attributValeur()
    {
        return $this->belongsTo(AttributValeur::class, 'attribut_valeur_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
