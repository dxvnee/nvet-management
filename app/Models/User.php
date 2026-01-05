<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'jabatan',
        'avatar',
        'gaji_pokok',
        'jam_kerja',
        'jam_masuk',
        'jam_keluar',
        'is_shift',
        'shift_partner_id',
        'shift1_jam_masuk',
        'shift1_jam_keluar',
        'shift2_jam_masuk',
        'shift2_jam_keluar',
        'hari_libur',
        'role',
        'is_inactive',
        'inactive_permanent',
        'inactive_start_date',
        'inactive_end_date',
        'inactive_reason',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'hari_libur' => 'array',
            'gaji_pokok' => 'decimal:2',
            'is_shift' => 'boolean',
            'is_inactive' => 'boolean',
            'inactive_permanent' => 'boolean',
            'inactive_start_date' => 'date',
            'inactive_end_date' => 'date',
        ];
    }

    /**
     * Get shift partner relationship.
     */
    public function shiftPartner()
    {
        return $this->belongsTo(User::class, 'shift_partner_id');
    }

    /**
     * Get users that have this user as shift partner.
     */
    public function shiftPartnerOf()
    {
        return $this->hasMany(User::class, 'shift_partner_id');
    }

    /**
     * Check if user is inactive on a specific date.
     */
    public function isInactiveOnDate($date = null)
    {
        if (!$this->is_inactive) {
            return false;
        }

        // If permanent inactive
        if ($this->inactive_permanent) {
            return true;
        }

        // If temporary inactive, check date range
        $checkDate = $date ? \Carbon\Carbon::parse($date) : now();

        if ($this->inactive_start_date && $this->inactive_end_date) {
            return $checkDate->between($this->inactive_start_date, $this->inactive_end_date);
        }

        return false;
    }

    /**
     * Scope to get only active users on a specific date.
     */
    public function scopeActiveOnDate($query, $date = null)
    {
        $checkDate = $date ? \Carbon\Carbon::parse($date) : now();

        return $query->where(function ($q) use ($checkDate) {
            // Not inactive at all
            $q->where('is_inactive', false)
                // Or inactive but permanent is false and date is outside range
                ->orWhere(function ($q2) use ($checkDate) {
                    $q2->where('is_inactive', true)
                        ->where('inactive_permanent', false)
                        ->where(function ($q3) use ($checkDate) {
                            $q3->where('inactive_start_date', '>', $checkDate)
                                ->orWhere('inactive_end_date', '<', $checkDate);
                        });
                });
        });
    }

    /**
     * Get the avatar URL attribute.
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : asset('images/default-avatar.png');
    }
}
