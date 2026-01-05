<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Penggajian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $currentMonth = now()->format('Y-m');
        $today = now()->toDateString();

        // Data untuk semua user
        $userAbsensiToday = Absen::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        // Statistik absensi bulan ini untuk user
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $userAbsensiBulanIni = Absen::where('user_id', $user->id)
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->get();

        $userTotalHadir = $userAbsensiBulanIni->count();
        $userTotalTidakHadir = $userAbsensiBulanIni->where('tidak_hadir', true)->count();
        $userTotalMenitTelat = $userAbsensiBulanIni->sum('menit_telat');
        $userTotalLupaPulang = $userAbsensiBulanIni->where('lupa_pulang', true)->count();

        // Penggajian terakhir user
        $userPenggajianTerakhir = Penggajian::where('user_id', $user->id)
            ->orderBy('periode', 'desc')
            ->first();

        // Riwayat absensi terakhir user (5 terakhir)
        $userRiwayatAbsensi = Absen::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        // Data khusus admin/owner
        $adminData = null;
        if ($user->role === 'admin') {
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
            $sudahAbsen = Absen::whereDate('tanggal', $today)->pluck('user_id')->toArray();
            $belumAbsen = User::where('role', 'pegawai')
                ->activeOnDate($today) // Filter only active users
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
                ->orderByDesc('total_menit') // lebih adil dari sekadar jumlah
                ->with('user')
                ->limit(5)
                ->get();


            // Grafik absensi 7 hari terakhir
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

            $adminData = compact(
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
            );
        }

        return view('dashboard', compact(
            'user',
            'userAbsensiToday',
            'userTotalHadir',
            'userTotalTidakHadir',
            'userTotalMenitTelat',
            'userTotalLupaPulang',
            'userPenggajianTerakhir',
            'userRiwayatAbsensi',
            'today',
            'adminData'
        ));
    }
}
