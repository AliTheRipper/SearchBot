<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('historiques', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('utilisateur_id');
            $table->unsignedBigInteger('film_id');
            $table->timestamp('date_visionnage')->useCurrent();
            $table->timestamps();

            $table->foreign('utilisateur_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historiques');
    }
};
