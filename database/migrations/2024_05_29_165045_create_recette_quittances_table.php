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
        Schema::create('recette_quittances', function (Blueprint $table) {
            $table->id();
            $table->date('date_siege');
            $table->string('numero_oni',30);
            $table->integer('centre_collecte_id');
            $table->integer('centre_traitement_id');
            $table->string('numero_tresor',30);
            $table->integer('nbre_rejet');
            $table->integer('formulaire_recus_id');
            $table->integer('nbre_formulaire');
            $table->integer('premier_serie');
            $table->integer('dernier_serie');
            $table->bigInteger('montant_formulaire');
            $table->bigInteger('montant');
            $table->integer('statut');
            $table->text('observations')->nullable();
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
        Schema::dropIfExists('recette_quittances');
    }
};
