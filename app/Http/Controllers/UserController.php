<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'pegawai');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        // Filter by jabatan
        if ($request->has('jabatan') && $request->jabatan) {
            $query->where('jabatan', $request->jabatan);
        }

        // Sorting
        $sortBy = $request->get('sort', 'name');
        $sortDir = $request->get('dir', 'asc');
        $query->orderBy($sortBy, $sortDir);

        $users = $query->paginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        // Get all pegawai for shift partner selection
        $pegawaiList = User::where('role', 'pegawai')->orderBy('name')->get();
        return view('users.create', compact('pegawaiList'));
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'jabatan' => ['required', 'in:FO,Dokter,Tech,Paramedis'],
            'gaji_pokok' => ['required', 'numeric', 'min:0'],
            'jam_kerja' => ['required', 'integer', 'min:1', 'max:24'],
            'hari_libur' => ['nullable', 'array'],
            'hari_libur.*' => ['integer', 'min:0', 'max:6'],
            'is_shift' => ['nullable', 'boolean'],
        ];

        // Validate based on shift or non-shift
        if ($request->is_shift) {
            $rules['shift_partner_id'] = ['required', 'exists:users,id'];
            $rules['shift1_jam_masuk'] = ['required', 'date_format:H:i'];
            $rules['shift1_jam_keluar'] = ['required', 'date_format:H:i'];
            $rules['shift2_jam_masuk'] = ['required', 'date_format:H:i'];
            $rules['shift2_jam_keluar'] = ['required', 'date_format:H:i'];
        } else {
            $rules['jam_masuk'] = ['required', 'date_format:H:i'];
            $rules['jam_keluar'] = ['required', 'date_format:H:i'];
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jabatan' => $request->jabatan,
            'gaji_pokok' => $request->gaji_pokok,
            'jam_kerja' => $request->jam_kerja,
            'hari_libur' => $request->hari_libur ?? [],
            'role' => 'pegawai',
            'is_shift' => $request->is_shift ?? false,
        ];

        if ($request->is_shift) {
            $data['shift_partner_id'] = $request->shift_partner_id;
            $data['shift1_jam_masuk'] = $request->shift1_jam_masuk;
            $data['shift1_jam_keluar'] = $request->shift1_jam_keluar;
            $data['shift2_jam_masuk'] = $request->shift2_jam_masuk;
            $data['shift2_jam_keluar'] = $request->shift2_jam_keluar;
            $data['jam_masuk'] = null;
            $data['jam_keluar'] = null;
        } else {
            $data['jam_masuk'] = $request->jam_masuk;
            $data['jam_keluar'] = $request->jam_keluar;
            $data['shift_partner_id'] = null;
            $data['shift1_jam_masuk'] = null;
            $data['shift1_jam_keluar'] = null;
            $data['shift2_jam_masuk'] = null;
            $data['shift2_jam_keluar'] = null;
        }

        $user = User::create($data);

        // If shift, update partner to also have same shift settings
        if ($request->is_shift && $request->shift_partner_id) {
            $partner = User::find($request->shift_partner_id);
            if ($partner) {
                $partner->update([
                    'is_shift' => true,
                    'shift_partner_id' => $user->id,
                    'shift1_jam_masuk' => $request->shift1_jam_masuk,
                    'shift1_jam_keluar' => $request->shift1_jam_keluar,
                    'shift2_jam_masuk' => $request->shift2_jam_masuk,
                    'shift2_jam_keluar' => $request->shift2_jam_keluar,
                    'jam_masuk' => null,
                    'jam_keluar' => null,
                ]);
            }
        }

        return redirect()->route('users.index')->with('success', 'Pegawai berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(User $user)
    {
        // Get all pegawai for shift partner selection (exclude current user)
        $pegawaiList = User::where('role', 'pegawai')
            ->where('id', '!=', $user->id)
            ->orderBy('name')
            ->get();
        return view('users.edit', compact('user', 'pegawaiList'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'jabatan' => ['required', 'in:FO,Dokter,Tech,Paramedis'],
            'gaji_pokok' => ['required', 'numeric', 'min:0'],
            'jam_kerja' => ['required', 'integer', 'min:1', 'max:24'],
            'hari_libur' => ['nullable', 'array'],
            'hari_libur.*' => ['integer', 'min:0', 'max:6'],
            'is_shift' => ['nullable', 'boolean'],
            'is_inactive' => ['nullable', 'boolean'],
            'inactive_permanent' => ['nullable', 'boolean'],
            'inactive_start_date' => ['nullable', 'date'],
            'inactive_end_date' => ['nullable', 'date', 'after_or_equal:inactive_start_date'],
            'inactive_reason' => ['nullable', 'string'],
        ];

        // Only validate password if provided
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        // Validate based on shift or non-shift
        if ($request->is_shift) {
            $rules['shift_partner_id'] = ['required', 'exists:users,id'];
            $rules['shift1_jam_masuk'] = ['required', 'date_format:H:i'];
            $rules['shift1_jam_keluar'] = ['required', 'date_format:H:i'];
            $rules['shift2_jam_masuk'] = ['required', 'date_format:H:i'];
            $rules['shift2_jam_keluar'] = ['required', 'date_format:H:i'];
        } else {
            $rules['jam_masuk'] = ['required', 'date_format:H:i'];
            $rules['jam_keluar'] = ['required', 'date_format:H:i'];
        }

        // Add validation for inactive dates if inactive and not permanent
        if ($request->is_inactive && !$request->inactive_permanent) {
            $rules['inactive_start_date'][] = 'required';
            $rules['inactive_end_date'][] = 'required';
        }

        $request->validate($rules);

        // Get old partner if exists
        $oldPartnerId = $user->shift_partner_id;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'gaji_pokok' => $request->gaji_pokok,
            'jam_kerja' => $request->jam_kerja,
            'hari_libur' => $request->hari_libur ?? [],
            'is_shift' => $request->is_shift ?? false,
            'is_inactive' => $request->is_inactive ?? false,
            'inactive_permanent' => $request->inactive_permanent ?? true,
            'inactive_start_date' => $request->inactive_start_date,
            'inactive_end_date' => $request->inactive_end_date,
            'inactive_reason' => $request->inactive_reason,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->is_shift) {
            $data['shift_partner_id'] = $request->shift_partner_id;
            $data['shift1_jam_masuk'] = $request->shift1_jam_masuk;
            $data['shift1_jam_keluar'] = $request->shift1_jam_keluar;
            $data['shift2_jam_masuk'] = $request->shift2_jam_masuk;
            $data['shift2_jam_keluar'] = $request->shift2_jam_keluar;
            $data['jam_masuk'] = null;
            $data['jam_keluar'] = null;
        } else {
            $data['jam_masuk'] = $request->jam_masuk;
            $data['jam_keluar'] = $request->jam_keluar;
            $data['shift_partner_id'] = null;
            $data['shift1_jam_masuk'] = null;
            $data['shift1_jam_keluar'] = null;
            $data['shift2_jam_masuk'] = null;
            $data['shift2_jam_keluar'] = null;
        }

        $user->update($data);

        // Handle partner updates
        if ($request->is_shift && $request->shift_partner_id) {
            // Update new partner
            $newPartner = User::find($request->shift_partner_id);
            if ($newPartner) {
                $newPartner->update([
                    'is_shift' => true,
                    'shift_partner_id' => $user->id,
                    'shift1_jam_masuk' => $request->shift1_jam_masuk,
                    'shift1_jam_keluar' => $request->shift1_jam_keluar,
                    'shift2_jam_masuk' => $request->shift2_jam_masuk,
                    'shift2_jam_keluar' => $request->shift2_jam_keluar,
                    'jam_masuk' => null,
                    'jam_keluar' => null,
                ]);
            }

            // If old partner is different, reset their shift settings
            if ($oldPartnerId && $oldPartnerId != $request->shift_partner_id) {
                $oldPartner = User::find($oldPartnerId);
                if ($oldPartner) {
                    $oldPartner->update([
                        'is_shift' => false,
                        'shift_partner_id' => null,
                        'shift1_jam_masuk' => null,
                        'shift1_jam_keluar' => null,
                        'shift2_jam_masuk' => null,
                        'shift2_jam_keluar' => null,
                    ]);
                }
            }
        } else if (!$request->is_shift && $oldPartnerId) {
            // Reset old partner if switching from shift to non-shift
            $oldPartner = User::find($oldPartnerId);
            if ($oldPartner) {
                $oldPartner->update([
                    'is_shift' => false,
                    'shift_partner_id' => null,
                    'shift1_jam_masuk' => null,
                    'shift1_jam_keluar' => null,
                    'shift2_jam_masuk' => null,
                    'shift2_jam_keluar' => null,
                ]);
            }
        }

        return redirect()->route('users.index')->with('success', 'Data pegawai berhasil diperbarui!');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus akun admin!');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pegawai berhasil dihapus!');
    }
}
