<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'commandes'; // corrigé
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'payment_method',
        'total_amount',
        'status'
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    // Relation avec les articles de commande
    public function articles()
    {
        return $this->hasMany(\App\Models\Article_commande::class, 'commande_id');
    }
}
