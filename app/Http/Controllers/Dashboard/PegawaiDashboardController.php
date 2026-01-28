<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Penggajian;
use Illuminate\Support\Facades\Auth;

class PegawaiDashboardController extends Controller
{
    /**
     * Display the pegawai dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Jika admin, redirect ke admin dashboard
        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        $today = now()->toDateString();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Status absensi hari ini
        $absensiToday = Absen::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        // Statistik absensi bulan ini
        $absensiBulanIni = Absen::where('user_id', $user->id)
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->get();

        $totalHadir = $absensiBulanIni->count();
        $totalTidakHadir = $absensiBulanIni->where('tidak_hadir', true)->count();
        $totalMenitTelat = $absensiBulanIni->sum('menit_telat');
        $totalLupaPulang = $absensiBulanIni->where('lupa_pulang', true)->count();

        // Penggajian terakhir
        $penggajianTerakhir = Penggajian::where('user_id', $user->id)
            ->orderBy('periode', 'desc')
            ->first();

        // Riwayat absensi terakhir (5 terakhir)
        $riwayatAbsensi = Absen::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.pegawai', compact(
            'user',
            'absensiToday',
            'totalHadir',
            'totalTidakHadir',
            'totalMenitTelat',
            'totalLupaPulang',
            'penggajianTerakhir',
            'riwayatAbsensi'
        ));
    }
}
