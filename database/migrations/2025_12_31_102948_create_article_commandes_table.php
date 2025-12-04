<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('article_commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            
            // Remplace taille_id par produit_valeur_attribut_id
            $table->foreignId('produit_valeur_attribut_id')
                  ->constrained('produit_valeur_attribut')
                  ->onDelete('cascade');

            $table->integer('quantity');
            $table->decimal('price', 15, 2);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('article_commandes');
    }
};
