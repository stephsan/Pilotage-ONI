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
        Schema::table('registres', function (Blueprint $table) {
            $table->integer('nbre_demande_verifiees')->nullable();
            //$table->integer('nbre_demande_recu_vip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registres', function (Blueprint $table) {
            $table->dropColumn('nbre_demande_verifiees');
            //$table->dropColumn('nbre_demande_recu_vip');
        });
    }
};
