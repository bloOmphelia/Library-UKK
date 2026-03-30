<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::role('student')->filter($request->all(), ['name', 'email'])->latest()->paginate(10)->withQueryString();
        return view('admin.pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.pages.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->safe()->except('password_confirmation');
        
        $user = User::onlyTrashed()->where('email', $request->email)->first();

        if ($user) {
            // Restore user yang soft deleted
            $user->restore();
            $data['password'] = Hash::make($request->password);
            $user->update($data);
            $user->syncRoles(['student']);

            return redirect()->route('admin.users')
                ->with('success', 'Akun anggota telah diaktifkan kembali dengan data terbaru.');
        }

        // Email benar-benar baru
        $data['password'] = Hash::make($request->password);
        $newUser = User::create($data);
        $newUser->assignRole('student');

        return redirect()->route('admin.users')
            ->with('success', 'Anggota baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::role('student')->findOrFail($id);
        return view('admin.pages.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::role('student')->findOrFail($id);

        $data = $request->safe()->except(['password', 'password_confirmation']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')
            ->with('success', 'Anggota berhasil diupdate.');
    }

    public function destroy($id)
    {
        $user = User::role('student')->findOrFail($id);

        $hasActiveTransactions = $user->transactions()
            ->whereIn('status', ['borrowed', 'pending'])
            ->exists();

        if ($hasActiveTransactions) {
            return redirect()->route('admin.users')
                ->with('error', "Anggota {$user->name} tidak bisa dihapus karena masih memiliki transaksi aktif.");
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Anggota berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        if (!$request->has('ids') || empty($request->ids)) {
            return redirect()->back()->with('error', 'Pilih anggota yang ingin dihapus.');
        }

        $ids = $request->ids;

        // 1. Cari nama-nama user yang memiliki transaksi aktif (gagal dihapus)
        $usersWithActiveTransactions = User::whereIn('id', $ids)
            ->whereHas('transactions', function($query) {
                $query->whereIn('status', ['borrowed', 'pending']);
            })
            ->pluck('name')
            ->toArray();

        // 2. Ambil ID user yang AMAN untuk dihapus
        $safeToDeleteIds = User::whereIn('id', $ids)
            ->whereDoesntHave('transactions', function($query) {
                $query->whereIn('status', ['borrowed', 'pending']);
            })
            ->pluck('id');

        // Kasus 1: Semuanya punya transaksi aktif (tidak ada yang terhapus)
        if ($safeToDeleteIds->isEmpty()) {
            return redirect()->back()->with('error', 'Semua anggota yang dipilih masih memiliki transaksi aktif.');
        }

        // Eksekusi Penghapusan
        User::whereIn('id', $safeToDeleteIds)->delete();
        $countSuccess = count($safeToDeleteIds);

        // Kasus 2: Ada yang berhasil dihapus DAN ada yang gagal (transaksi aktif)
        if (!empty($usersWithActiveTransactions)) {
            $failedNames = implode(', ', $usersWithActiveTransactions);
            return redirect()->route('admin.users')->with('success', 
                "{$countSuccess} anggota berhasil dihapus. Namun, beberapa anggota tidak bisa dihapus karena memiliki transaksi aktif."
            );
        }

        // Kasus 3: Semuanya berhasil dihapus tanpa hambatan
        return redirect()->route('admin.users')->with('success', "{$countSuccess} anggota berhasil dihapus.");
    }
}

