<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use App\Services\PhotoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LemburController extends Controller
{
    protected PhotoService $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    

    public function index()
    {
        $user = Auth::user();
        $today = Carbon::now();

        // Cek apakah ada lembur aktif hari ini
        $activeLembur = Lembur::where('user_id', $user->id)
            ->whereDate('tanggal', $today->toDateString())
            ->whereNull('jam_selesai')
            ->first();

        // Riwayat lembur untuk pagination
        $riwayatLembur = Lembur::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Data statistik - ambil semua data tanpa pagination
        $allLemburData = Lembur::where('user_id', $user->id)->get();

        // Hitung statistik
        $totalLemburBulanIni = $allLemburData->where('status', 'approved')
            ->where('tanggal', '>=', now()->startOfMonth())
            ->sum('durasi_menit');

        $menungguApproval = $allLemburData->where('status', 'pending')->count();

        $lemburDisetujui = $allLemburData->where('status', 'approved')->count();

        // Cek apakah sudah lewat jam pulang (asumsi jam pulang ada di user)
        // Jika tidak ada field jam_pulang, default ke 17:00 atau ambil dari shift
        // Menggunakan jam_pulang dari user jika ada, atau default
        $jamPulang = $user->jam_keluar ? Carbon::parse($user->jam_keluar) : Carbon::today()->setHour(17)->setMinute(0);

        // Jika jam pulang lebih kecil dari jam masuk (shift malam), tambah 1 hari
        if ($user->jam_masuk && Carbon::parse($user->jam_masuk)->gt($jamPulang)) {
            $jamPulang->addDay();
        }

        // Set tanggal jam pulang ke hari ini untuk perbandingan waktu
        // Note: Logic shift malam perlu penyesuaian lebih lanjut jika user login besoknya.
        // Untuk sekarang asumsi user klik lembur di hari yang sama dengan shift.
        $jamPulangToday = Carbon::parse($today->toDateString() . ' ' . $jamPulang->format('H:i:s'));

        $canLembur = $today->gt($jamPulangToday);

        return view('lembur.index', compact(
            'activeLembur',
            'riwayatLembur',
            'canLembur',
            'jamPulangToday',
            'totalLemburBulanIni',
            'menungguApproval',
            'lemburDisetujui'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now();

        // Validate photo is required
        $request->validate([
            'foto' => 'required|string',
        ], [
            'foto.required' => 'Foto wajib diambil untuk memulai lembur.',
        ]);

        // Validasi jam pulang
        $jamPulang = $user->jam_keluar ? Carbon::parse($user->jam_keluar) : Carbon::today()->setHour(17)->setMinute(0);
        $jamPulangToday = Carbon::parse($now->toDateString() . ' ' . $jamPulang->format('H:i:s'));

        if ($now->lt($jamPulangToday)) {
            return back()->with('error', 'Belum waktunya lembur. Tunggu hingga jam pulang: ' . $jamPulangToday->format('H:i'));
        }

        // Cek apakah sudah ada lembur aktif
        $existing = Lembur::where('user_id', $user->id)
            ->whereDate('tanggal', $now->toDateString())
            ->whereNull('jam_selesai')
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sedang dalam sesi lembur.');
        }

        // Process and save photo
        $fotoPath = $this->photoService->processPhoto($request->foto, 'lembur_mulai', $user->id);

        Lembur::create([
            'user_id' => $user->id,
            'tanggal' => $now->toDateString(),
            'jam_mulai' => $now->toTimeString(),
            'foto_mulai' => $fotoPath,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Lembur dimulai.');
    }

    public function update(Request $request, Lembur $lembur)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'foto' => 'required|string',
        ], [
            'foto.required' => 'Foto wajib diambil untuk menyelesaikan lembur.',
        ]);

        if ($lembur->user_id !== Auth::id()) {
            abort(403);
        }

        $now = Carbon::now();

        // Hitung durasi
        $startDateTime = Carbon::parse($lembur->tanggal->format('Y-m-d') . ' ' . $lembur->jam_mulai->format('H:i:s'));

        // Jika jam sekarang lebih kecil dari jam mulai, berarti sudah lewat tengah malam (ganti hari)
        if ($now->lt($startDateTime)) {
            $endDateTime = $now->addDay();
        } else {
            $endDateTime = $now;
        }

        $durasi = $startDateTime->diffInMinutes($endDateTime);

        // Process and save photo
        $fotoPath = $this->photoService->processPhoto($request->foto, 'lembur_selesai', Auth::id());

        $lembur->update([
            'jam_selesai' => $now->toTimeString(),
            'foto_selesai' => $fotoPath,
            'durasi_menit' => $durasi,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Lembur selesai. Menunggu persetujuan admin.');
    }

    // Admin Methods
    public function adminIndex()
    {
        $lemburs = Lembur::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('lembur.admin', compact('lemburs'));
    }

    public function approve(Lembur $lembur)
    {
        $lembur->update(['status' => 'approved']);
        return back()->with('success', 'Lembur disetujui.');
    }

    public function reject(Request $request, Lembur $lembur)
    {
        $request->validate(['alasan' => 'required|string']);

        $lembur->update([
            'status' => 'rejected',
            'alasan_penolakan' => $request->alasan
        ]);

        return back()->with('success', 'Lembur ditolak.');
    }
}
