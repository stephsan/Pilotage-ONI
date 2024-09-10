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
        Schema::table('formulaire_recus', function (Blueprint $table) {
            $table->integer('nbre_carte_sortie')->nullable();
            $table->date('date_sortie')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formulaire_recus', function (Blueprint $table) {
           $table->dropColumn('nbre_carte_sortie');
           $table->dropColumn('date_sortie');
        });
    }
};
