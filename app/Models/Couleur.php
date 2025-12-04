<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Couleur extends Model
{
    use HasFactory;
    protected $table='couleurs';
    protected $fillable = ['name','hex_code'];

    public function produits(){
        return $this->belongsToMany(Produit::class ,'couleur_produit');
    }
}
