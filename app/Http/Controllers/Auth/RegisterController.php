<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreRegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(StoreRegisterRequest $request)
    {
        // Cek apakah email ini adalah akun yang pernah di-soft delete
        $existingUser = User::onlyTrashed()->where('email', $request->email)->first();

        if ($existingUser) {
            // Restore dan update password
            $existingUser->restore();
            $existingUser->update([
                'name' => $request->name, 
                'nis' => $request->nis,
                'password' => Hash::make($request->password)
                ]);
            $existingUser->syncRoles(['student']);
            auth()->login($existingUser);
        } else {
            // User baru
            $user = User::create([
                'name'     => $request->name,
                'nis'      => $request->nis,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole('student');
            auth()->login($user);
        }

        return redirect()->route('register.complete');
    }

    public function completeIndex()
    {
        $user = auth()->user();
        return view('auth.complete-register', compact('user'));
    }

    public function completeUpdate(UpdateProfileRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $email = $user->email;
        
        if ($request->action !== 'skip') {
            $user->update($request->only(['phone_number', 'class', 'address', 'gender']));
        }

        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login')
        ->with('autofill_email', $email)
        ->with('success', $request->action === 'skip' 
            ? 'Registrasi berhasil! Silakan login.' 
            : 'Profil berhasil dilengkapi! Silakan login.');
    }
}
