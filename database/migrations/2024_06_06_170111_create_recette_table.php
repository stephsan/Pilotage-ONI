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
        Schema::create('recettes', function (Blueprint $table) {
            $table->id();
            $table->date('date_saisie');
            $table->bigInteger('numero');
            $table->date('date_de_paiement')->nullable();
            $table->integer('type_recette');
            $table->string('nom_complet_dela_personne',100)->nullable();
            $table->string('motif',100)->nullable();
            $table->integer('quittance_recette_ass')->nullable();
            $table->integer('site_operation')->nullable();
            $table->bigInteger('montant');
            $table->bigInteger('degagement')->nullable();
            $table->bigInteger('solde')->nullable();
            $table->text('observation')->nullable();
            $table->integer('statut')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recettes');
    }
};
