<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paniers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');

            // Permet NULL si le produit n'a pas d'attribut
            $table->foreignId('produit_valeur_attribut_id')
                  ->nullable()
                  ->constrained('produit_valeur_attribut')
                  ->onDelete('cascade');

            $table->integer('quantity')->default(1);
            $table->timestamps();

            // Empêche les doublons pour un même utilisateur, produit et attribut
            $table->unique(['user_id', 'produit_id', 'produit_valeur_attribut_id'], 'panier_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paniers');
    }
};
