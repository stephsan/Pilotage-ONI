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
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->integer('type_id')->nullable();
            $table->string('intitule');
            $table->text('description');
            $table->integer('statut');
            $table->date('date_daffectation');
            $table->integer('creer_par');
            $table->date('date_de_rappel')->nullable();
            $table->date('deadline');
            $table->integer('personne_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
