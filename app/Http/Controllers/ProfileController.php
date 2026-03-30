<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        /** @var \App\Models\User $user */
        $viewPath = $user->hasRole('admin') ? 'admin.pages.profile' : 'student.pages.profile';
        
        return view($viewPath . '.index', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
    
        $data = $request->only(['name', 'phone_number', 'class', 'address', 'gender']);

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $data['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
