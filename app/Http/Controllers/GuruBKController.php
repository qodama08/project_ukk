<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class GuruBKController extends Controller
{
    public function index()
    {
        $gurus = User::where('role', 'admin')->where('email', '!=', 'admin@gmail.com')->orderBy('name')->paginate(15);

        return view('guru_bk.index', compact('gurus'));
    }

    public function create()
    {
        return view('guru_bk.create');
    }

    public function show($id)
    {
        $guru_bk = User::where('role', 'admin')->where('email', '!=', 'admin@gmail.com')->findOrFail($id);

        return view('guru_bk.show', compact('guru_bk'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nomor_hp' => 'nullable|string|max:20|unique:users,nomor_hp',
        ]);

        try {
            $guru = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'nomor_hp' => $validated['nomor_hp'] ?? null,
                'password' => bcrypt('password123'),
                'role' => 'admin',
                'is_verified' => 1,
            ]);

            return redirect()->route('guru_bk.index')->with('success', 'Guru BK berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $guru_bk = User::where('role', 'admin')->where('email', '!=', 'admin@gmail.com')->findOrFail($id);

        return view('guru_bk.edit', compact('guru_bk'));
    }

    public function update(Request $request, $id)
    {
        $guru_bk = User::findOrFail($id);
        
        // Verify this user is a guru_bk
        if (!$guru_bk->roles()->where('nama_role', 'guru_bk')->exists()) {
            abort(404, 'Guru BK tidak ditemukan');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $guru_bk->id,
            'nomor_hp' => 'nullable|string|max:20|unique:users,nomor_hp,' . $guru_bk->id,
        ]);

        try {
            $guru_bk->update($validated);
            return redirect()->route('guru_bk.index')->with('success', 'Guru BK berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $guru_bk = User::where('role', 'admin')->where('email', '!=', 'admin@gmail.com')->findOrFail($id);

        try {
            $guru_bk->delete();
            return back()->with('success', 'Guru BK berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus: ' . $e->getMessage()]);
        }
    }
}
