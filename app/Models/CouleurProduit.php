<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Couleur_produit extends Model
{
    protected $table='couleur_produit';
    protected $fillable=
    [
        'produit_id',
        'couleur_id',

    ];
    public $timestamps = false;
}
