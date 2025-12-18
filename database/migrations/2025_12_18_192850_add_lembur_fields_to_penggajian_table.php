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
        Schema::table('penggajian', function (Blueprint $table) {
            $table->integer('total_menit_lembur')->default(0)->after('total_potongan_telat');
            $table->decimal('upah_lembur_per_menit', 10, 2)->default(0)->after('total_menit_lembur');
            $table->decimal('total_upah_lembur', 15, 2)->default(0)->after('upah_lembur_per_menit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penggajian', function (Blueprint $table) {
            $table->dropColumn(['total_menit_lembur', 'upah_lembur_per_menit', 'total_upah_lembur']);
        });
    }
};
