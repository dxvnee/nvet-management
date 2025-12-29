<?php

namespace App\Http\Controllers;

use App\Models\HariLibur;
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
        return view('hari-libur.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date|unique:hari_liburs,tanggal',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'is_recurring' => 'boolean',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.unique' => 'Tanggal ini sudah terdaftar sebagai hari libur',
            'nama.required' => 'Nama hari libur wajib diisi',
        ]);
        
        $validated['is_recurring'] = $request->has('is_recurring');
        
        HariLibur::create($validated);
        
        return redirect()->route('hari-libur.index')
            ->with('success', 'Hari libur berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HariLibur $hariLibur)
    {
        return view('hari-libur.edit', compact('hariLibur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HariLibur $hariLibur)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date|unique:hari_liburs,tanggal,' . $hariLibur->id,
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'is_recurring' => 'boolean',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.unique' => 'Tanggal ini sudah terdaftar sebagai hari libur',
            'nama.required' => 'Nama hari libur wajib diisi',
        ]);
        
        $validated['is_recurring'] = $request->has('is_recurring');
        
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
