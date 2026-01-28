<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Redirect ke dashboard yang sesuai berdasarkan role user.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        return redirect()->route('dashboard.pegawai');
    }
}
