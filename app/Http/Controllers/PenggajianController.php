<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Lembur;
use App\Models\Penggajian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    /**
     * Display a listing of payrolls.
     */
    public function index(Request $request)
    {
        $periode = $request->get('periode', now()->format('Y-m'));

        $query = Penggajian::with('user')
            ->where('periode', $periode);

        // Handle sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        // Define allowed sort columns
        $allowedSorts = [
            'user_name' => 'users.name',
            'jabatan' => 'users.jabatan',
            'gaji_pokok' => 'penggajian.gaji_pokok',
            'total_potongan_telat' => 'penggajian.total_potongan_telat',
            'total_insentif' => 'penggajian.total_insentif',
            'total_gaji' => 'penggajian.total_gaji',
            'created_at' => 'penggajian.created_at',
        ];

        if (array_key_exists($sortBy, $allowedSorts)) {
            if (in_array($sortBy, ['user_name', 'jabatan'])) {
                $query->join('users', 'penggajian.user_id', '=', 'users.id')
                    ->orderBy($allowedSorts[$sortBy], $sortDirection)
                    ->select('penggajian.*');
            } else {
                $query->orderBy($allowedSorts[$sortBy], $sortDirection);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $penggajian = $query->paginate(10)->withQueryString();

        // Get all employees for creating new payroll
        $employees = User::where('role', 'pegawai')->get();

        return view('penggajian.index', compact('penggajian', 'periode', 'employees'));
    }

    /**
     * Show the form for creating a new payroll.
     */
    public function create(Request $request)
    {
        $userId = $request->get('user_id');
        $periode = $request->get('periode', now()->format('Y-m'));

        $user = User::findOrFail($userId);

        // Check if payroll already exists
        $existing = Penggajian::where('user_id', $userId)->where('periode', $periode)->first();
        if ($existing) {
            return redirect()->route('penggajian.edit', $existing)->with('error', 'Penggajian untuk periode ini sudah ada!');
        }

        // Get attendance data for the period
        $startDate = Carbon::parse($periode . '-01')->startOfMonth();
        $endDate = Carbon::parse($periode . '-01')->endOfMonth();

        $absensi = Absen::where('user_id', $userId)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        // Get approved overtime
        $lembur = Lembur::where('user_id', $userId)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->where('status', 'approved')
            ->get();

        $totalMenitLembur = $lembur->sum('durasi_menit');

        $totalMenitTelat = $absensi->sum('menit_telat');
        $jamKerja = $user->jam_kerja ?? 8;
        $potonganPerMenit = round(($user->gaji_pokok / ($jamKerja * 26)) / 60);
        return view('penggajian.create', compact('user', 'periode', 'potonganPerMenit', 'totalMenitTelat', 'absensi', 'totalMenitLembur'));
    }

    /**
     * Store a newly created payroll in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'periode' => 'required|string',
            'gaji_pokok' => 'required|numeric|min:0',
            'total_menit_telat' => 'required|integer|min:0',
            'potongan_per_menit' => 'required|integer|min:0',
            'insentif_detail' => 'nullable|array',
            'reimburse' => 'nullable|numeric|min:0',
            'keterangan_reimburse' => 'nullable|string',
            'lain_lain' => 'nullable|numeric',
            'keterangan_lain' => 'nullable|string',
            'catatan' => 'nullable|string',
            'status' => 'required|in:draft,final',
        ]);

        $user = User::findOrFail($request->user_id);

        // Calculate totals
        $gajiPokok = $request->gaji_pokok;
        $totalPotonganTelat = $request->total_menit_telat * $request->potongan_per_menit;
        $totalInsentif = $this->calculateInsentif($user->jabatan, $request->insentif_detail ?? []);
        $reimburse = $request->reimburse ?? 0;
        $lainLain = $request->lain_lain ?? 0;

        $totalGaji = $gajiPokok - $totalPotonganTelat + $totalInsentif - $reimburse + $lainLain;

        Penggajian::create([
            'user_id' => $request->user_id,
            'periode' => $request->periode,
            'gaji_pokok' => $gajiPokok,
            'total_menit_telat' => $request->total_menit_telat,
            'potongan_per_menit' => $request->potongan_per_menit,
            'total_potongan_telat' => $totalPotonganTelat,
            'insentif_detail' => $request->insentif_detail,
            'total_insentif' => $totalInsentif,
            'reimburse' => $reimburse,
            'keterangan_reimburse' => $request->keterangan_reimburse,
            'lain_lain' => $lainLain,
            'keterangan_lain' => $request->keterangan_lain,
            'total_gaji' => $totalGaji,
            'catatan' => $request->catatan,
            'status' => $request->status,
        ]);

        return redirect()->route('penggajian.index', ['periode' => $request->periode])
            ->with('success', 'Penggajian berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified payroll.
     */
    public function edit(Penggajian $penggajian)
    {
        $user = $penggajian->user;
        $periode = $penggajian->periode;

        // Get attendance data for the period
        $startDate = Carbon::parse($periode . '-01')->startOfMonth();
        $endDate = Carbon::parse($periode . '-01')->endOfMonth();

        $absensi = Absen::where('user_id', $user->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        $totalMenitTelat = $absensi->sum('menit_telat');
        $jamKerja = $user->jam_kerja ?? 8;
        $potonganPerMenit = round(($user->gaji_pokok / ($jamKerja * 26)) / 60);

        return view('penggajian.edit', compact('penggajian', 'user', 'periode', 'absensi', 'totalMenitTelat', 'potonganPerMenit'));
    }

    /**
     * Update the specified payroll in storage.
     */
    public function update(Request $request, Penggajian $penggajian)
    {
        $request->validate([
            'gaji_pokok' => 'required|numeric|min:0',
            'total_menit_telat' => 'required|integer|min:0',
            'potongan_per_menit' => 'required|integer|min:0',
            'insentif_detail' => 'nullable|array',
            'reimburse' => 'nullable|numeric|min:0',
            'keterangan_reimburse' => 'nullable|string',
            'lain_lain' => 'nullable|numeric',
            'keterangan_lain' => 'nullable|string',
            'catatan' => 'nullable|string',
            'status' => 'required|in:draft,final',
        ]);

        $user = $penggajian->user;

        // Calculate totals
        $gajiPokok = $request->gaji_pokok;
        $totalPotonganTelat = $request->total_menit_telat * $request->potongan_per_menit;
        $totalInsentif = $this->calculateInsentif($user->jabatan, $request->insentif_detail ?? []);
        $reimburse = $request->reimburse ?? 0;
        $lainLain = $request->lain_lain ?? 0;

        $totalGaji = $gajiPokok - $totalPotonganTelat + $totalInsentif - $reimburse + $lainLain;

        $penggajian->update([
            'gaji_pokok' => $gajiPokok,
            'total_menit_telat' => $request->total_menit_telat,
            'potongan_per_menit' => $request->potongan_per_menit,
            'total_potongan_telat' => $totalPotonganTelat,
            'insentif_detail' => $request->insentif_detail,
            'total_insentif' => $totalInsentif,
            'reimburse' => $reimburse,
            'keterangan_reimburse' => $request->keterangan_reimburse,
            'lain_lain' => $lainLain,
            'keterangan_lain' => $request->keterangan_lain,
            'total_gaji' => $totalGaji,
            'catatan' => $request->catatan,
            'status' => $request->status,
        ]);

        return redirect()->route('penggajian.index', ['periode' => $penggajian->periode])
            ->with('success', 'Penggajian berhasil diperbarui!');
    }

    /**
     * Remove the specified payroll from storage.
     */
    public function destroy(Penggajian $penggajian)
    {
        $periode = $penggajian->periode;
        $penggajian->delete();

        return redirect()->route('penggajian.index', ['periode' => $periode])
            ->with('success', 'Penggajian berhasil dihapus!');
    }

    /**
     * Print payroll slip.
     */
    public function print(Penggajian $penggajian)
    {
        // Check if user is admin or the payroll belongs to the authenticated user
        if (auth()->user()->role !== 'admin' && $penggajian->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('penggajian.print', compact('penggajian'));
    }

    /**
     * Calculate incentive based on job position.
     */
    private function calculateInsentif(string $jabatan, array $detail): float
    {
        $total = 0;

        // Calculate lain-lain items total
        $lainLainItemsTotal = 0;
        if (isset($detail['lain_lain_items']) && is_array($detail['lain_lain_items'])) {
            foreach ($detail['lain_lain_items'] as $item) {
                $qty = intval($item['qty'] ?? 0);
                $harga = floatval($item['harga'] ?? 0);
                $lainLainItemsTotal += $qty * $harga;
            }
        }

        switch ($jabatan) {
            case 'Dokter':
                // Transaksi - (Pengurangan + Penambahan)% + lain-lain
                $transaksi = floatval($detail['transaksi'] ?? 0);
                $pengurangan = floatval($detail['pengurangan'] ?? 0);
                $penambahan = floatval($detail['penambahan'] ?? 0);
                $persenan = floatval($detail['persenan'] ?? 0) / 100;

                $total = ($transaksi - $pengurangan + $penambahan) * $persenan + $lainLainItemsTotal;
                break;

            case 'Paramedis':
                // Antar jemput + Rawat inap + Visit + Grooming + lain-lain
                $antarJemput = (intval($detail['antar_jemput_qty'] ?? 0) * floatval($detail['antar_jemput_harga'] ?? 0));
                $rawatInap = (intval($detail['rawat_inap_qty'] ?? 0) * floatval($detail['rawat_inap_harga'] ?? 0));
                $visit = (intval($detail['visit_qty'] ?? 0) * floatval($detail['visit_harga'] ?? 0));
                $grooming = (intval($detail['grooming_qty'] ?? 0) * floatval($detail['grooming_harga'] ?? 0));

                $total = $antarJemput + $rawatInap + $visit + $grooming + $lainLainItemsTotal;
                break;

            case 'FO':
                // Review + Appointment + lain-lain
                $review = (intval($detail['review_qty'] ?? 0) * floatval($detail['review_harga'] ?? 0));
                $appointment = (intval($detail['appointment_qty'] ?? 0) * floatval($detail['appointment_harga'] ?? 0));

                $total = $review + $appointment + $lainLainItemsTotal;
                break;

            case 'Tech':
                // Antar konten + lain-lain
                $antarKonten = (intval($detail['antar_konten_qty'] ?? 0) * floatval($detail['antar_konten_harga'] ?? 0));

                $total = $antarKonten + $lainLainItemsTotal;
                break;
        }

        return $total;
    }

    /**
     * Display payroll history for the authenticated employee.
     */
    public function riwayatPegawai(Request $request)
    {
        $user = auth()->user();

        $query = Penggajian::where('user_id', $user->id);

        // Handle sorting
        $sortBy = $request->get('sort_by', 'periode');
        $sortDirection = $request->get('sort_direction', 'desc');

        // Define allowed sort columns for employee view
        $allowedSorts = [
            'periode' => 'periode',
            'gaji_pokok' => 'gaji_pokok',
            'total_potongan_telat' => 'total_potongan_telat',
            'total_insentif' => 'total_insentif',
            'total_gaji' => 'total_gaji',
            'created_at' => 'created_at',
        ];

        if (array_key_exists($sortBy, $allowedSorts)) {
            $query->orderBy($allowedSorts[$sortBy], $sortDirection);
        } else {
            $query->orderBy('periode', 'desc');
        }

        $penggajian = $query->paginate(12)->withQueryString();

        return view('penggajian.riwayat-pegawai', compact('penggajian'));
    }
}
