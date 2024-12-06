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
        Schema::create('registre_docs', function (Blueprint $table) {
            $table->id();
            $table->integer('antenne_id');
            $table->date('date_effet');
            $table->integer('statut')->nullable();
            $table->integer('creer_par');
            $table->integer('modifier_par');
            $table->integer('entite_id')->nullable();
            $table->integer('effectif_theorique');
            $table->integer('effectif_present');
            $table->integer('effectif_absent');
            $table->integer('effectif_conge');
            $table->integer('effectif_malade');
            $table->integer('effectif_mission');
            $table->integer('effectif_permission');
            //Carte d'identite de refugiés cir
            $table->integer('nbre_demande_recu_cir')->nullable();
            $table->integer('nbre_demande_traites_cir')->nullable();
            $table->integer('nbre_demande_en_instance_cir')->nullable();
            $table->integer('nbre_demande_corrige_cir')->nullable();
            $table->integer('nbre_demandes_rejetes_cir')->nullable();
            //Carte professionnel cp
            $table->integer('nbre_demande_recu_cp')->nullable();
            $table->integer('nbre_demande_traites_cp')->nullable();
            $table->integer('nbre_demande_en_instance_cp')->nullable();
            $table->integer('nbre_demande_corrige_cp')->nullable();
            $table->integer('nbre_demandes_rejetes_cp')->nullable();
            //Carte professionnel autre
            $table->integer('nbre_demande_recu_autre')->nullable();
            $table->integer('nbre_demande_traites_autre')->nullable();
            $table->integer('nbre_demande_en_instance_autre')->nullable();
            $table->integer('nbre_demande_corrige_autre')->nullable();
            $table->integer('nbre_demandes_rejetes_autre')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registre_docs');
    }
};
