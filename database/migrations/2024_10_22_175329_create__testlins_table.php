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
        Schema::create('testlins', function (Blueprint $table) {
            $table->id();
            $table->integer('antenne_id');
            $table->integer('qte_sortie')->nullable();
            $table->integer('qte_entree')->nullable();
            $table->string('reference');
            $table->date('date');
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
        Schema::dropIfExists('testlins');
    }
};
