<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsenController extends Controller
{
    // Koordinat kantor (bisa dicustom)
    private $officeLatitude = -6.189035762950233;
    private $officeLongitude = 106.61662426529043;
    private $allowedRadius = 20; // meter

    public function index()
    {
        $today = Carbon::today();
        $user = Auth::user();

        // Ambil absen hari ini
        $absenHariIni = Absen::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->get();

        $sudahHadir = $absenHariIni->where('tipe', 'hadir')->first();
        $sudahIzin = $absenHariIni->where('tipe', 'izin')->first();
        $sudahPulang = $absenHariIni->where('tipe', 'pulang')->first();

        // Riwayat absen 7 hari terakhir
        $riwayat = Absen::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->limit(20)
            ->get();

        return view('absen', compact(
            'sudahHadir',
            'sudahIzin',
            'sudahPulang',
            'riwayat'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:hadir,izin,pulang',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $today = Carbon::today();
        $now = Carbon::now();

        // Cek apakah sudah absen dengan tipe yang sama hari ini
        $existing = Absen::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->where('tipe', $request->tipe)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah melakukan absen ' . $request->tipe . ' hari ini.');
        }

        // Validasi lokasi (radius 10 meter)
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $this->officeLatitude,
            $this->officeLongitude
        );

        if ($distance > $this->allowedRadius) {
            return back()->with('error', 'Anda berada di luar radius kantor. Jarak Anda: ' . round($distance, 2) . ' meter.');
        }

        // Cek telat (jam 09:00 untuk hadir)
        $telat = false;
        if ($request->tipe === 'hadir') {
            $batasHadir = Carbon::today()->setTime(9, 0, 0);
            $telat = $now->greaterThan($batasHadir);
        }

        // Untuk pulang, cek apakah sudah hadir
        if ($request->tipe === 'pulang') {
            $sudahHadir = Absen::where('user_id', $user->id)
                ->whereDate('tanggal', $today)
                ->where('tipe', 'hadir')
                ->first();

            if (!$sudahHadir) {
                return back()->with('error', 'Anda belum melakukan absen hadir hari ini.');
            }
        }

        Absen::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'tipe' => $request->tipe,
            'jam' => $now->format('H:i:s'),
            'telat' => $telat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'keterangan' => $request->keterangan,
        ]);

        $message = 'Absen ' . $request->tipe . ' berhasil dicatat pada ' . $now->format('H:i:s');
        if ($telat) {
            $message .= ' (TELAT)';
        }

        return back()->with('success', $message);
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
