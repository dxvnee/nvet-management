<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HariLibur extends Model
{
    protected $fillable = [
        'tanggal',
        'nama',
        'keterangan',
        'is_recurring',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_recurring' => 'boolean',
    ];

    /**
     * Check if a given date is a holiday
     */
    public static function isHoliday($date): bool
    {
        $date = Carbon::parse($date);

        // Check exact date match
        $exactMatch = self::whereDate('tanggal', $date)->exists();
        if ($exactMatch) {
            return true;
        }

        // Check recurring holidays (same month and day)
        $recurringMatch = self::where('is_recurring', true)
            ->whereMonth('tanggal', $date->month)
            ->whereDay('tanggal', $date->day)
            ->exists();

        return $recurringMatch;
    }

    /**
     * Get holiday info for a given date
     */
    public static function getHoliday($date): ?self
    {
        $date = Carbon::parse($date);

        // Check exact date match first
        $holiday = self::whereDate('tanggal', $date)->first();
        if ($holiday) {
            return $holiday;
        }

        // Check recurring holidays
        return self::where('is_recurring', true)
            ->whereMonth('tanggal', $date->month)
            ->whereDay('tanggal', $date->day)
            ->first();
    }
}
