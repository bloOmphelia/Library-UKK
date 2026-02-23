<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::role('student')->filter($request->only(['search']), ['name', 'email'])->latest()->paginate(10)->withQueryString();
        return view('admin.pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.pages.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Assign role student
        $user->assignRole('student');

        return redirect()->route('admin.users')
            ->with('success', 'Anggota student berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::role('student')->findOrFail($id);
        return view('admin.pages.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::role('student')->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        $data = $request->only('name', 'email');

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')
            ->with('success', 'Data student berhasil diupdate');
    }
}

