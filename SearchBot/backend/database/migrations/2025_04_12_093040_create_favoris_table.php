<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('favoris', function (Blueprint $table) {
            $table->uuid('id')->primary(); // ou $table->id(); si UUID non nécessaire
            $table->uuid('utilisateur_id');
            $table->unsignedBigInteger('film_id');
            $table->timestamp('date_ajout')->useCurrent();
            $table->timestamps();

            // 🔗 Clés étrangères
            $table->foreign('utilisateur_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favoris');
    }
};
