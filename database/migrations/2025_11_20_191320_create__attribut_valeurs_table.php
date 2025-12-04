<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attribut_valeurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribut_id')->constrained('attributs')->onDelete('cascade');
            $table->string('value'); // Ex: S, M, L, Rouge, 64GB
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribut_valeurs');
    }
};
