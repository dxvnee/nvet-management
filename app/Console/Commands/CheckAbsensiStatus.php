<?php

namespace App\Console\Commands;

use App\Models\Absen;
use App\Models\HariLibur;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckAbsensiStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absensi:check-status {--date= : Tanggal yang akan dicek (format: Y-m-d)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek dan update status absensi (tidak hadir, libur, lupa pulang) untuk semua pegawai - Dijalankan jam 6 pagi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = $this->option('date') ? Carbon::parse($this->option('date')) : Carbon::yesterday();
        $hariIni = $date->dayOfWeek; // 1 = Monday, 7 = Sunday

        $this->info("Checking absensi status for: " . $date->format('Y-m-d') . " (Day: $hariIni)");

        // Check if today is a public holiday
        $isPublicHoliday = HariLibur::isHoliday($date);
        $publicHolidayInfo = HariLibur::getHoliday($date);
        
        if ($isPublicHoliday) {
            $this->info("📅 Hari ini adalah hari libur umum: " . ($publicHolidayInfo->nama ?? 'Hari Libur'));
        }

        // Get all pegawai
        $pegawai = User::where('role', 'pegawai')->get();

        $liburCount = 0;
        $tidakHadirCount = 0;
        $lupaPulangCount = 0;

        foreach ($pegawai as $user) {
            // Check if this date is user's personal holiday OR public holiday
            $hariLibur = $user->hari_libur ?? [];
            $isPersonalLibur = in_array($hariIni, $hariLibur);
            $isLibur = $isPersonalLibur || $isPublicHoliday;

            $absen = Absen::where('user_id', $user->id)
                ->where('tanggal', $date->toDateString())
                ->first();

            // If absen record exists
            if ($absen) {
                // Skip if already processed (izin, libur, atau tidak_hadir)
                if ($absen->izin || $absen->libur || $absen->tidak_hadir) {
                    continue;
                }

                // Check if user forgot to check out (has jam_masuk but no jam_pulang)
                if ($absen->jam_masuk && !$absen->jam_pulang && !$absen->lupa_pulang) {
                    // Auto set jam_pulang based on user's jam_keluar
                    $jamKeluar = $user->jam_keluar ? Carbon::parse($user->jam_keluar) : Carbon::createFromTime(20, 0);

                    // Handle shift users
                    if ($user->is_shift && $user->shift_partner_id) {
                        $jamKeluar = $user->shift2_jam_keluar ? Carbon::parse($user->shift2_jam_keluar) : Carbon::createFromTime(20, 0);
                    }

                    $jamMasuk = Carbon::parse($date->toDateString() . ' ' . Carbon::parse($absen->jam_masuk)->format('H:i:s'));
                    $jamKeluarToday = Carbon::parse($date->toDateString() . ' ' . $jamKeluar->format('H:i:s'));

                    $menitKerja = $jamMasuk->diffInMinutes($jamKeluarToday);

                    $absen->update([
                        'jam_pulang' => $jamKeluarToday,
                        'menit_kerja' => $menitKerja,
                        'lupa_pulang' => true,
                    ]);

                    $lupaPulangCount++;
                    $this->line("  - {$user->name}: AUTO CHECKOUT (LUPA PULANG) - Jam: {$jamKeluarToday->format('H:i')}");
                }
                continue;
            }

            // No absen record exists - create one based on status
            if ($isLibur) {
                // User's scheduled holiday
                Absen::create([
                    'user_id' => $user->id,
                    'tanggal' => $date->toDateString(),
                    'libur' => true,
                    'tidak_hadir' => false,
                ]);
                $liburCount++;
                $this->line("  - {$user->name}: Marked as LIBUR");
            } else {
                // User didn't show up at all
                Absen::create([
                    'user_id' => $user->id,
                    'tanggal' => $date->toDateString(),
                    'tidak_hadir' => true,
                ]);
                $tidakHadirCount++;
                $this->line("  - {$user->name}: Marked as TIDAK HADIR");
            }
        }

        $this->info("Completed! Libur: $liburCount, Tidak Hadir: $tidakHadirCount, Lupa Pulang: $lupaPulangCount");

        return Command::SUCCESS;
    }
}
