<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taille extends Model
{
    protected $table='tailles';
    protected $fillable = ['name','type'];
    
    public function produits(){
        return $this->belongsToMany(Produit::class,'produit-taille')->withPivot('stock')->withTimestamps();
    }
}
