<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribut extends Model
{

    use HasFactory;
    protected $table='attributs';
    protected $fillable = ['name','description','created_at','updated_at'];
    public function categories()
{
    return $this->belongsToMany(Category::class, 'categorie_attribut');
}
public function valeurs()
{
    return $this->hasMany(AttributValeur::class, 'attribut_id');
}

}
