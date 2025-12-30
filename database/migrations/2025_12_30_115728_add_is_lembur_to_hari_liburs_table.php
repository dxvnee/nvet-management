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
        Schema::table('hari_liburs', function (Blueprint $table) {
            // Apakah termasuk lembur (jika ya, tampil dengan pengali upah, jika tidak, dihitung kerja biasa)
            $table->boolean('is_lembur')->default(true)->after('is_masuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hari_liburs', function (Blueprint $table) {
            $table->dropColumn('is_lembur');
        });
    }
};
