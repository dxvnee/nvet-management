<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Penggajian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Pastikan user adalah admin
        if ($user->role !== 'admin') {
            return redirect()->route('dashboard.pegawai');
        }

        $currentMonth = now()->format('Y-m');
        $today = now()->toDateString();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Total pegawai
        $totalPegawai = User::where('role', 'pegawai')->count();

        // Pegawai berdasarkan jabatan
        $pegawaiByJabatan = User::where('role', 'pegawai')
            ->selectRaw('jabatan, count(*) as total')
            ->groupBy('jabatan')
            ->pluck('total', 'jabatan')
            ->toArray();

        // Absensi hari ini (semua pegawai)
        $absensiHariIni = Absen::whereDate('tanggal', $today)
            ->whereNotNull('jam_masuk')
            ->count();
            
        $tepatWaktuHariIni = Absen::whereDate('tanggal', $today)
            ->where('menit_telat', 0)
            ->whereNotNull('jam_masuk')
            ->count();

        $telatHariIni = Absen::whereDate('tanggal', $today)
            ->where('menit_telat', '>', 0)
            ->count();

        // Pegawai yang belum absen hari ini
        $belumAbsen = User::where('role', 'pegawai')
            ->activeOnDate($today)
            ->whereIn('id', function ($q) {
                $q->select('user_id')
                    ->from('absens')
                    ->whereDate('tanggal', now())
                    ->whereNull('jam_masuk')
                    ->where('izin', false)
                    ->where('libur', false);
            })
            ->get();

        // Total gaji bulan ini
        $totalGajiBulanIni = Penggajian::where('periode', $currentMonth)
            ->where('status', 'final')
            ->sum('total_gaji');

        // Penggajian pending (draft)
        $penggajianDraft = Penggajian::where('status', 'draft')->count();

        // Count lupa pulang bulan ini
        $totalLupaPulangBulanIni = Absen::whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->where('lupa_pulang', true)
            ->count();

        // Aktivitas absensi terbaru (10 terakhir)
        $aktivitasTerbaru = Absen::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->whereNotNull('jam_masuk')
            ->get();

        // Top pegawai telat bulan ini
        $topTelat = Absen::selectRaw('user_id, COUNT(*) as total_telat, SUM(menit_telat) as total_menit')
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->where('menit_telat', '>', 0)
            ->groupBy('user_id')
            ->orderByDesc('total_menit')
            ->with('user')
            ->limit(5)
            ->get();

        // Grafik absensi 7 hari terakhir
        $grafikAbsensi = $this->getGrafikAbsensi();

        return view('dashboard.admin', compact(
            'user',
            'today',
            'totalPegawai',
            'pegawaiByJabatan',
            'absensiHariIni',
            'tepatWaktuHariIni',
            'telatHariIni',
            'belumAbsen',
            'totalGajiBulanIni',
            'penggajianDraft',
            'aktivitasTerbaru',
            'topTelat',
            'grafikAbsensi',
            'totalLupaPulangBulanIni'
        ));
    }

    /**
     * Get grafik absensi 7 hari terakhir.
     */
    private function getGrafikAbsensi(): array
    {
        $grafikAbsensi = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $grafikAbsensi[] = [
                'tanggal' => Carbon::parse($date)->format('d M'),
                'hadir' => Absen::whereDate('tanggal', $date)->count(),
                'telat' => Absen::whereDate('tanggal', $date)
                    ->where('menit_telat', '>', 0)
                    ->count(),
            ];
        }

        return $grafikAbsensi;
    }
}
