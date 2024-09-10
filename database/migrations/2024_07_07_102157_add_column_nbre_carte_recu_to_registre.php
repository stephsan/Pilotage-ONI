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
            $table->integer('nbre_de_carte_recus')->nullable(); //vip nombre carte
            $table->integer('stock_de_tamine_vierge')->nullable(); //Reception
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registres', function (Blueprint $table) {
            $table->dropColumn('nbre_de_carte_recus');
            $table->dropColumn('stock_de_tamine_vierge');
        });
    }
};
