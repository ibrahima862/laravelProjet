<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProduitTaille extends Model
{
    protected $table = 'produit_taille'; // nom de la table pivot

    protected $fillable = [
        'produit_id',
        'taille_id',
        'stock'
    ];

    public $timestamps = false; // table pivot n’a pas toujours des timestamps
}
