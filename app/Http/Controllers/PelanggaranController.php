<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\User;

class PelanggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Pelanggaran::with('user')->orderBy('nama_pelanggaran')->get();
        if (request()->wantsJson()) {
            return response()->json($items);
        }
        return view('pelanggaran.index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Use POST to /pelanggaran to create']);
        }
        $siswa = User::with('kelas')->whereDoesntHave('roles')->orWhereHas('roles', function($q){ $q->where('nama_role','siswa'); })->orderBy('name')->get();
        return view('pelanggaran.form', ['siswa' => $siswa]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'nama_siswa' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'absen' => 'required|string|max:10',
        ]);

        // Map siswa_id to user_id for backward compatibility
        $data['user_id'] = $data['siswa_id'];

        $pel = Pelanggaran::create($data);
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Created', 'data' => $pel],201);
        }
        return redirect()->route('pelanggaran.index')->with('success','Pelanggaran dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pel = Pelanggaran::with('user')->findOrFail($id);
        if (request()->wantsJson()) return response()->json($pel);
        $siswa = User::with('kelas')->whereDoesntHave('roles')->orWhereHas('roles', function($q){ $q->where('nama_role','siswa'); })->orderBy('name')->get();
        return view('pelanggaran.form', ['item' => $pel, 'siswa' => $siswa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pel = Pelanggaran::with('user')->findOrFail($id);
        if (request()->wantsJson()) return response()->json($pel);
        $siswa = User::with('kelas')->whereDoesntHave('roles')->orWhereHas('roles', function($q){ $q->where('nama_role','siswa'); })->orderBy('name')->get();
        return view('pelanggaran.form', ['item' => $pel, 'siswa' => $siswa]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pel = Pelanggaran::findOrFail($id);
        $data = $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'nama_siswa' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'absen' => 'required|string|max:10',
        ]);
        
        // Map siswa_id to user_id for backward compatibility
        $data['user_id'] = $data['siswa_id'];
        
        $pel->update($data);
        if (request()->wantsJson()) return response()->json(['message' => 'Updated', 'data' => $pel]);
        return redirect()->route('pelanggaran.index')->with('success','Pelanggaran diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pel = Pelanggaran::findOrFail($id);
        $pel->delete();
        if (request()->wantsJson()) return response()->json(['message' => 'Deleted']);
        return redirect()->route('pelanggaran.index')->with('success','Pelanggaran dihapus');
    }
}
