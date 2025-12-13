<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absen extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal',
        'tipe',
        'jam',
        'telat',
        'latitude',
        'longitude',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'telat' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
