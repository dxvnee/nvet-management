<?php

namespace App\Console\Commands;

use App\Models\Absen;
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
    protected $description = 'Cek dan update status absensi (tidak hadir & libur) untuk semua pegawai';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = $this->option('date') ? Carbon::parse($this->option('date')) : Carbon::today();
        $hariIni = $date->isoWeekday(); // 1 = Monday, 7 = Sunday

        $this->info("Checking absensi status for: " . $date->format('Y-m-d') . " (Day: $hariIni)");

        // Get all pegawai
        $pegawai = User::where('role', 'pegawai')->get();

        $liburCount = 0;
        $tidakHadirCount = 0;

        foreach ($pegawai as $user) {
            // Check if today is user's holiday
            $hariLibur = $user->hari_libur ?? [];
            $isLibur = in_array($hariIni, $hariLibur);

            // Get or create absen record for today
            $absen = Absen::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'tanggal' => $date->toDateString(),
                ],
                [
                    'izin' => false,
                    'telat' => false,
                    'tidak_hadir' => false,
                    'libur' => false,
                ]
            );

            // If already has jam_masuk or izin or libur, skip
            if ($absen->jam_masuk || $absen->izin || $absen->libur) {
                continue;
            }

            // Mark as libur if it's user's holiday
            if ($isLibur) {
                $absen->update([
                    'libur' => true,
                    'tidak_hadir' => false,
                ]);
                $liburCount++;
                $this->line("  - {$user->name}: Marked as LIBUR");
                continue;
            }

            // Check if current time is past user's jam_pulang (only for today)
            if ($date->isToday()) {
                $jamPulang = $user->jam_keluar ? Carbon::parse($user->jam_keluar) : Carbon::createFromTime(20, 0);
                $jamPulangToday = Carbon::today()->setTime($jamPulang->hour, $jamPulang->minute);

                // Handle shift users
                if ($user->is_shift && $user->shift_partner_id) {
                    // Use shift2 jam_keluar as the final deadline
                    $jamPulang = $user->shift2_jam_keluar ? Carbon::parse($user->shift2_jam_keluar) : Carbon::createFromTime(20, 0);
                    $jamPulangToday = Carbon::today()->setTime($jamPulang->hour, $jamPulang->minute);
                }

                // Only mark as tidak_hadir if it's past jam_pulang
                if (Carbon::now()->gte($jamPulangToday)) {
                    $absen->update([
                        'tidak_hadir' => true,
                    ]);
                    $tidakHadirCount++;
                    $this->line("  - {$user->name}: Marked as TIDAK HADIR");
                }
            } else {
                // For past dates, mark as tidak_hadir if no jam_masuk
                $absen->update([
                    'tidak_hadir' => true,
                ]);
                $tidakHadirCount++;
                $this->line("  - {$user->name}: Marked as TIDAK HADIR (past date)");
            }
        }

        $this->info("Completed! Libur: $liburCount, Tidak Hadir: $tidakHadirCount");

        return Command::SUCCESS;
    }
}
