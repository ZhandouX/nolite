<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 📋 Daftar pengguna + filter
    public function index(Request $request)
    {
        $query = User::query();

        // 🔍 Pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
        }

        // 🔽 Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistik
        $stats = [
            'total' => User::count(),
            'aktif' => User::where('status', 'aktif')->count(),
            'nonaktif' => User::where('status', 'nonaktif')->count(),
            'diblokir' => User::where('status', 'diblokir')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    // 👁 Detail pengguna
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    // 🚫 Blokir akun
    public function block(User $user)
    {
        $user->update(['status' => 'diblokir']);
        return back()->with('success', 'Akun berhasil diblokir.');
    }

    // ✅ Aktifkan akun
    public function activate(User $user)
    {
        $user->update(['status' => 'aktif']);
        return back()->with('success', 'Akun berhasil diaktifkan.');
    }

    // ⚪ Nonaktifkan akun
    public function nonaktif(User $user)
    {
        $user->update(['status' => 'nonaktif']);
        return back()->with('success', 'Akun berhasil dinonaktifkan.');
    }

    // ❌ Hapus permanen
    public function destroy(User $user)
    {
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->forceDelete(); // hapus permanen
        return back()->with('success', 'Akun berhasil dihapus permanen.');
    }
}
