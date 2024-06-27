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
        Schema::create('formulaire_recus', function (Blueprint $table) {
            $table->id();
            $table->integer('ccd_id');
            $table->integer('centre_traitement_id');
            $table->integer('centre_collecte_id');
            $table->string('numero_lot',30);
            $table->string('premier_serie',30);
            $table->string('dernier_serie',30);
            $table->integer('nbre_formulaire');
            $table->integer('statut');
            $table->integer('user_created');
            $table->integer('user_updated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulaire_recus');
    }
};
