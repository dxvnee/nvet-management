<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absen extends Model
{
    protected $table = 'absens';

    protected $fillable = [
        'user_id',
        'tanggal',

        // JAM
        'jam_masuk',
        'jam_pulang',

        // TELAT
        'telat',
        'menit_telat',

        // LOKASI
        'lat_masuk',
        'lng_masuk',
        'foto_masuk',
        'lat_pulang',
        'lng_pulang',
        'foto_pulang',

        // IZIN
        'izin',
        'izin_keterangan',
        'foto_izin',

        // STATUS
        'tidak_hadir',
        'libur',

        // SHIFT
        'shift_number',

        // KERJA
        'menit_kerja',
    ];

    protected $casts = [
        'tanggal' => 'date',

        'jam_masuk' => 'datetime:H:i',
        'jam_pulang' => 'datetime:H:i',

        'telat' => 'boolean',
        'izin' => 'boolean',
        'tidak_hadir' => 'boolean',
        'libur' => 'boolean',

        'menit_telat' => 'integer',
        'menit_kerja' => 'integer',

        'lat_masuk' => 'decimal:8',
        'lng_masuk' => 'decimal:8',
        'lat_pulang' => 'decimal:8',
        'lng_pulang' => 'decimal:8',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
