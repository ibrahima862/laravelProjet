<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('categorie_id');
            // Clé étrangère vers la table "categories"
           $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade'); // si la catégorie est supprimée, ses produits aussi
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('details')->nullable();
            $table->integer('price');
            $table->integer('delivery_days')->nullable();
            $table->integer('stock');
            $table->string('img')->nullable();
            $table->string('badge')->nullable();
             $table->integer('sales_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
