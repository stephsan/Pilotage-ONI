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
        Schema::create('centre_collectes', function (Blueprint $table) {
            $table->id();
            $table->string('code',20);
            $table->string('libelle',40);
            $table->integer('region_id');
            $table->integer('province_id');
            $table->integer('commune_id');
            $table->integer('centre_traitement_id')->unsigned();
            $table->text('description');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centre_collectes');
    }
};
