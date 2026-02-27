<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role === 'manager') {
            return view('manager.profile.index', compact('user'));
        }

        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            if ($user->avatar && File::exists(public_path('storage/avatars/' . $user->avatar))) {
                File::delete(public_path('storage/avatars/' . $user->avatar));
            }

            $file     = $request->file('avatar');
            $fileName = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/avatars'), $fileName);
            $user->avatar = $fileName;
        }

        $user->save();

        // Redirect ke route yang sesuai role
        if ($user->role === 'manager') {
            return redirect()->route('manager.profile.index')
                ->with('success', 'Profil berhasil diperbarui!');
        }

        return redirect()->route('profile.index')
            ->with('success', 'Profile berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah!']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        if ($user->role === 'manager') {
            return redirect()->route('manager.profile.index')
                ->with('success', 'Password berhasil diubah!');
        }

        return redirect()->route('profile.index')
            ->with('success', 'Password berhasil diubah!');
    }
}