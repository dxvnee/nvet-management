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
            // Tipe: libur, hari_khusus (custom working day)
            $table->enum('tipe', ['libur', 'hari_khusus'])->default('libur')->after('tanggal');

            // Untuk hari khusus - apakah ada kerja
            $table->boolean('is_masuk')->default(false)->after('is_recurring');

            // Jam kerja custom untuk hari khusus
            $table->time('jam_masuk')->nullable()->after('is_masuk');
            $table->time('jam_keluar')->nullable()->after('jam_masuk');

            // Pengaturan shift untuk hari khusus
            $table->boolean('is_shift_enabled')->default(false)->after('jam_keluar');
            $table->time('shift1_jam_masuk')->nullable()->after('is_shift_enabled');
            $table->time('shift1_jam_keluar')->nullable()->after('shift1_jam_masuk');
            $table->time('shift2_jam_masuk')->nullable()->after('shift1_jam_keluar');
            $table->time('shift2_jam_keluar')->nullable()->after('shift2_jam_masuk');

            // Siapa saja yang harus hadir (JSON array of user IDs, null = semua)
            $table->json('pegawai_hadir')->nullable()->after('shift2_jam_keluar');

            // Pegawai yang libur juga harus masuk?
            $table->boolean('libur_tetap_masuk')->default(false)->after('pegawai_hadir');

            // Apakah wajib masuk (jika tidak masuk akan dihitung alpha)
            $table->boolean('is_wajib')->default(false)->after('libur_tetap_masuk');

            // Multiplier untuk upah (misal: 2x untuk lembur hari libur)
            $table->decimal('upah_multiplier', 3, 1)->default(1.0)->after('is_wajib');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hari_liburs', function (Blueprint $table) {
            $table->dropColumn([
                'tipe',
                'is_masuk',
                'jam_masuk',
                'jam_keluar',
                'is_shift_enabled',
                'shift1_jam_masuk',
                'shift1_jam_keluar',
                'shift2_jam_masuk',
                'shift2_jam_keluar',
                'pegawai_hadir',
                'libur_tetap_masuk',
                'is_wajib',
                'upah_multiplier',
            ]);
        });
    }
};
