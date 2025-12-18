<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penggajian extends Model
{
    use HasFactory;

    protected $table = 'penggajian';

    protected $fillable = [
        'user_id',
        'periode',
        'gaji_pokok',
        'total_menit_telat',
        'potongan_per_menit',
        'total_potongan_telat',
        'insentif_detail',
        'total_insentif',
        'reimburse',
        'keterangan_reimburse',
        'lain_lain',
        'lain_lain_items',
        'keterangan_lain',
        'total_gaji',
        'catatan',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'gaji_pokok' => 'decimal:2',
            'potongan_per_menit' => 'decimal:2',
            'total_potongan_telat' => 'decimal:2',
            'insentif_detail' => 'array',
            'total_insentif' => 'decimal:2',
            'reimburse' => 'decimal:2',
            'lain_lain' => 'decimal:2',
            'lain_lain_items' => 'array',
            'total_gaji' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
