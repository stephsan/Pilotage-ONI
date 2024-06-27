<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('valeurs', function (Blueprint $table) {
            $table->id();
            $table->integer('parametre_id');
            $table->integer('valeur_id')->nullable();
            $table->string('libelle');
            $table->string('code')->nullable();
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valeurs');
    }
};
