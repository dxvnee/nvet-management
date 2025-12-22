<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Absen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile page.
     */
    public function show(Request $request): View
    {
        $user = $request->user();

        // Get attendance statistics
        $stats = [
            'bulan_ini' => Absen::where('user_id', $user->id)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count(),
            'total_jam' => Absen::where('user_id', $user->id)
                ->whereNotNull('jam_pulang')
                ->sum('menit_kerja') / 60, // Convert minutes to hours
            'status_terakhir' => Absen::where('user_id', $user->id)
                ->where('tanggal', now()->toDateString())
                ->first()?->status ?? 'Belum ada'
        ];

        return view('profile', [
            'user' => $user,
            'stats' => $stats,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Handle avatar upload from file input
        if ($request->hasFile('avatar')) {
            try {
                $file = $request->file('avatar');

                // Validate file
                if ($file->getSize() > 2048 * 1024) {
                    return Redirect::back()->withErrors(['avatar' => 'Ukuran file foto terlalu besar. Maksimal 2MB.'])->withInput();
                }

                $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!in_array($file->getMimeType(), $allowedMimes)) {
                    return Redirect::back()->withErrors(['avatar' => 'Format file tidak didukung.'])->withInput();
                }

                // Delete old avatar if exists
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                // Process image with Intervention Image
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file->getPathname());

                // Crop to square (1:1 ratio) from center
                $image->crop(
                    min($image->width(), $image->height()), // Size
                    min($image->width(), $image->height()), // Size
                    intval(($image->width() - min($image->width(), $image->height())) / 2), // X offset (center)
                    intval(($image->height() - min($image->width(), $image->height())) / 2)  // Y offset (center)
                );

                // Resize to max 400px (square)
                $image->scale(width: 400);

                // Generate filename
                $filename = sprintf('avatars/%d_%s.jpg', $user->id, now()->format('YmdHis'));

                // Save as JPEG 80% quality
                $encoded = $image->toJpeg(80);
                Storage::disk('public')->put($filename, (string) $encoded);

                $user->avatar = $filename;
            } catch (\Exception $e) {
                \Log::error('Avatar file upload error: ' . $e->getMessage());
                return Redirect::back()->withErrors(['avatar' => 'Terjadi kesalahan saat mengupload foto.'])->withInput();
            }
        }

        $validated = $request->validated();
        unset($validated['avatar']); // Remove avatar from validated data since we handle it separately
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete avatar file if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
