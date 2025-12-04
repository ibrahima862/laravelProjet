<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSpec extends Model
{
    protected $fillable = ['produit_id', 'key', 'value'];

    public function produit(){
        return $this->belongsTo(Produit::class);
    }
}
