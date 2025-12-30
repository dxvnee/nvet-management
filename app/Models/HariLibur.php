<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class HariLibur extends Model
{
    protected $fillable = [
        'tanggal',
        'tipe',
        'nama',
        'keterangan',
        'is_recurring',
        'is_masuk',
        'is_lembur',
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
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_recurring' => 'boolean',
        'is_masuk' => 'boolean',
        'is_lembur' => 'boolean',
        'is_shift_enabled' => 'boolean',
        'libur_tetap_masuk' => 'boolean',
        'is_wajib' => 'boolean',
        'pegawai_hadir' => 'array',
        'upah_multiplier' => 'decimal:1',
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

    /**
     * Check if a user should work on this day
     */
    public function shouldUserWork(User $user): bool
    {
        // Jika tipe libur dan tidak ada kerja
        if ($this->tipe === 'libur' && !$this->is_masuk) {
            return false;
        }

        // Jika ada daftar pegawai yang harus hadir
        if ($this->pegawai_hadir && count($this->pegawai_hadir) > 0) {
            return in_array($user->id, $this->pegawai_hadir);
        }

        // Cek apakah user sedang libur hari tersebut
        $dayOfWeek = $this->tanggal->dayOfWeek;
        $userHariLibur = $user->hari_libur ?? [];
        $isUserDayOff = in_array($dayOfWeek, $userHariLibur);

        // Jika user sedang libur tapi libur_tetap_masuk aktif
        if ($isUserDayOff && $this->libur_tetap_masuk) {
            return true;
        }

        // Jika user sedang libur dan tidak diwajibkan masuk
        if ($isUserDayOff && !$this->libur_tetap_masuk) {
            return false;
        }

        return $this->is_masuk;
    }

    /**
     * Get jam masuk for a specific user (considers shift)
     */
    public function getJamMasukForUser(User $user, int $shiftNumber = 1): ?string
    {
        if (!$this->is_masuk) {
            return null;
        }

        if ($this->is_shift_enabled && $user->is_shift) {
            return $shiftNumber === 1 ? $this->shift1_jam_masuk : $this->shift2_jam_masuk;
        }

        return $this->jam_masuk;
    }

    /**
     * Get jam keluar for a specific user (considers shift)
     */
    public function getJamKeluarForUser(User $user, int $shiftNumber = 1): ?string
    {
        if (!$this->is_masuk) {
            return null;
        }

        if ($this->is_shift_enabled && $user->is_shift) {
            return $shiftNumber === 1 ? $this->shift1_jam_keluar : $this->shift2_jam_keluar;
        }

        return $this->jam_keluar;
    }

    /**
     * Get tipe label
     */
    public function getTipeLabelAttribute(): string
    {
        return match ($this->tipe) {
            'libur' => 'Hari Libur',
            'hari_khusus' => 'Hari Khusus',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Check if this is a special working day
     */
    public function isHariKhusus(): bool
    {
        return $this->tipe === 'hari_khusus';
    }
}
