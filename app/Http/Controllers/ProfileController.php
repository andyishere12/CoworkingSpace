<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Update profil (name, email, avatar)
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $user->name = $request->name;
        $user->email = $request->email;

        // Logika Upload Avatar
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada
            if ($user->avatar && File::exists(public_path('storage/avatars/' . $user->avatar))) {
                File::delete(public_path('storage/avatars/' . $user->avatar));
            }

            $file = $request->file('avatar');
            $fileName = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/avatars'), $fileName);
            $user->avatar = $fileName;
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile berhasil diperbarui!');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cek current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah!']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Password berhasil diubah!');
    }
}