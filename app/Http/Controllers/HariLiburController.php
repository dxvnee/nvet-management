<?php

namespace App\Http\Controllers;

use App\Models\HariLibur;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HariLiburController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        $hariLiburs = HariLibur::whereYear('tanggal', $tahun)
            ->orWhere('is_recurring', true)
            ->orderBy('tanggal')
            ->get();

        return view('hari-libur.index', compact('hariLiburs', 'tahun'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = User::where('role', '!=', 'admin')
            ->orderBy('name')
            ->get();

        return view('hari-libur.create', compact('pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date|unique:hari_liburs,tanggal',
            'tipe' => 'required|in:libur,hari_khusus',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'is_recurring' => 'boolean',
            'is_masuk' => 'boolean',
            'is_lembur' => 'boolean',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i',
            'is_shift_enabled' => 'boolean',
            'shift1_jam_masuk' => 'nullable|date_format:H:i',
            'shift1_jam_keluar' => 'nullable|date_format:H:i',
            'shift2_jam_masuk' => 'nullable|date_format:H:i',
            'shift2_jam_keluar' => 'nullable|date_format:H:i',
            'pegawai_hadir' => 'nullable|array',
            'pegawai_hadir.*' => 'exists:users,id',
            'libur_tetap_masuk' => 'boolean',
            'is_wajib' => 'boolean',
            'upah_multiplier' => 'nullable|numeric|min:0.5|max:5',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.unique' => 'Tanggal ini sudah terdaftar sebagai hari libur',
            'tipe.required' => 'Tipe wajib dipilih',
            'nama.required' => 'Nama hari libur wajib diisi',
        ]);

        $validated['is_recurring'] = $request->has('is_recurring');
        $validated['is_masuk'] = $request->has('is_masuk');
        $validated['is_lembur'] = $request->has('is_lembur');
        $validated['is_shift_enabled'] = $request->has('is_shift_enabled');
        $validated['libur_tetap_masuk'] = $request->has('libur_tetap_masuk');
        $validated['is_wajib'] = $request->has('is_wajib');
        $validated['upah_multiplier'] = $request->input('upah_multiplier', 1.0);

        // Handle pegawai_hadir
        if ($request->has('pegawai_semua') || empty($request->pegawai_hadir)) {
            $validated['pegawai_hadir'] = null;
        } else {
            $validated['pegawai_hadir'] = array_map('intval', $request->pegawai_hadir);
        }

        HariLibur::create($validated);

        return redirect()->route('hari-libur.index')
            ->with('success', 'Hari libur berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HariLibur $hariLibur)
    {
        $pegawai = User::where('role', '!=', 'admin')
            ->orderBy('name')
            ->get();

        return view('hari-libur.edit', compact('hariLibur', 'pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HariLibur $hariLibur)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date|unique:hari_liburs,tanggal,' . $hariLibur->id,
            'tipe' => 'required|in:libur,hari_khusus',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'is_recurring' => 'boolean',
            'is_masuk' => 'boolean',
            'is_lembur' => 'boolean',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i',
            'is_shift_enabled' => 'boolean',
            'shift1_jam_masuk' => 'nullable|date_format:H:i',
            'shift1_jam_keluar' => 'nullable|date_format:H:i',
            'shift2_jam_masuk' => 'nullable|date_format:H:i',
            'shift2_jam_keluar' => 'nullable|date_format:H:i',
            'pegawai_hadir' => 'nullable|array',
            'pegawai_hadir.*' => 'exists:users,id',
            'libur_tetap_masuk' => 'boolean',
            'is_wajib' => 'boolean',
            'upah_multiplier' => 'nullable|numeric|min:0.5|max:5',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.unique' => 'Tanggal ini sudah terdaftar sebagai hari libur',
            'tipe.required' => 'Tipe wajib dipilih',
            'nama.required' => 'Nama hari libur wajib diisi',
        ]);

        $validated['is_recurring'] = $request->has('is_recurring');
        $validated['is_masuk'] = $request->has('is_masuk');
        $validated['is_lembur'] = $request->has('is_lembur');
        $validated['is_shift_enabled'] = $request->has('is_shift_enabled');
        $validated['libur_tetap_masuk'] = $request->has('libur_tetap_masuk');
        $validated['is_wajib'] = $request->has('is_wajib');
        $validated['upah_multiplier'] = $request->input('upah_multiplier', 1.0);

        // Handle pegawai_hadir
        if ($request->has('pegawai_semua') || empty($request->pegawai_hadir)) {
            $validated['pegawai_hadir'] = null;
        } else {
            $validated['pegawai_hadir'] = array_map('intval', $request->pegawai_hadir);
        }

        $hariLibur->update($validated);

        return redirect()->route('hari-libur.index')
            ->with('success', 'Hari libur berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HariLibur $hariLibur)
    {
        $hariLibur->delete();

        return redirect()->route('hari-libur.index')
            ->with('success', 'Hari libur berhasil dihapus');
    }
}
