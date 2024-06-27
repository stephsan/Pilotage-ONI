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
        Schema::create('registres', function (Blueprint $table) {
            $table->id();
            $table->integer('entite_id')->nullable();
            $table->integer('antenne_id')->nullable();
            $table->integer('effectif_theorique');
            $table->integer('effectif_present');
            $table->integer('effectif_absent');
            $table->integer('effectif_conge');
            $table->integer('effectif_malade');
            $table->integer('effectif_mission');
            $table->integer('effectif_permission');

            $table->integer('nbre_lot_introduit')->nullable(); //tri exp-recep production cnib lot recus de recep_expe
            $table->integer('nbre_demande_saisie')->nullable(); //vip tri exp-recep  production cnib demande saisie recep_expe
            $table->integer('nbre_demande_supervise')->nullable(); //production cnib
            $table->integer('nbre_carte_imprime')->nullable(); //production cnib
            $table->integer('nbre_carte_assure')->nullable(); //production cnib
            $table->integer('nbre_carte_endomage')->nullable();//production cnib

            $table->integer('nbre_demande_en_instance')->nullable();
            $table->integer('nbre_carte_transmise')->nullable();
            $table->integer('stock_de_teslin')->nullable();
            $table->integer('stock_de_tamine_imprime')->nullable();

            
            $table->integer('nbre_de_carte_disponible')->nullable(); //vip nombre carte
            $table->integer('nbre_de_carte_restitue')->nullable(); //vip nombre carte

            $table->integer('nbre_photos_a_verifier')->nullable(); //Biometrie nombre carte
            $table->integer('nbre_photo_enrole_manuellement')->nullable(); //Biometrie nombre carte
            $table->integer('nbre_photo_triees')->nullable(); //Biometrie nombre carte
            $table->integer('nbre_photo_investigues')->nullable(); //Biometrie nombre carte
            $table->integer('nbre_photo_en_attente_de_tirage')->nullable(); //Biometrie nombre carte
            $table->integer('nbre_photo_en_attente_dinvestigation')->nullable(); //Biometrie nombre carte
            $table->integer('nbre_photo_cas_fraude')->nullable(); //Biometrie nombre carte

            $table->integer('nbre_passport_ordi_produit')->nullable(); //Passport nombre carte
            $table->integer('nbre_passport_ordinaire_rejete')->nullable(); //Passport nombre carte
            $table->integer('nbre_passport_ord_faute')->nullable(); //Passport nombre carte
            $table->integer('nbre_passport_ord_vierge_restant')->nullable(); //Passport nombre carte
            $table->integer('nbre_passport_refugie_produit')->nullable(); //Passport nombre carte
            
            $table->integer('nbre_dossier_recu')->nullable(); //Enquete investigation nombre carte
            $table->integer('nbre_dossier_traite')->nullable(); //Enquete investigation nombre carte
            $table->integer('nbre_dossier_transmis')->nullable(); //Enquete investigation nombre carte
            $table->integer('nbre_dossier_rejete')->nullable(); //Enquete investigation nombre carte
            $table->integer('nbre_dossier_en_instance')->nullable(); //Enquete investigation nombre carte
           
            $table->integer('observation')->nullable();
            $table->date('date_effet');
            $table->integer('statut');
            $table->integer('creer_par');
            $table->integer('modifier_par');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registres');
    }
};
