<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil
     */
    public function index()
    {
        $user = Auth::user();
        return view('profil.profile', compact('user'));
    }

    /**
     * Ubah password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required'    => 'Password lama wajib diisi.',
            'current_password.current_password' => 'Password lama tidak sesuai.',
            'password.required'            => 'Password baru wajib diisi.',
            'password.confirmed'           => 'Konfirmasi password tidak cocok.',
            'password.min'                 => 'Password minimal 8 karakter.',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile')
            ->with('success', 'Password berhasil diubah.');
    }
}
