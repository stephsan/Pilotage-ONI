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
        Schema::table('centre_traitements', function (Blueprint $table) {
            $table->integer('seuil_max');
            $table->integer('seuil_min');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('centre_traitements', function (Blueprint $table) {
            $table->dropColumn('seuil_max');
            $table->dropColumn('seuil_min');
        });
    }
};
