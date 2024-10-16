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
            $table->integer('nbre_documents_poste1')->nullable();
            $table->integer('nbre_documents_poste2')->nullable();
            $table->integer('nbre_documents_poste3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registres', function (Blueprint $table) {
            $table->dropColumn('nbre_documents_poste1');
            $table->dropColumn('nbre_documents_poste2');
            $table->dropColumn('nbre_documents_poste3');
        });
    }
};
