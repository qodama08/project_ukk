<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestasi;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestasis = Prestasi::orderBy('tanggal','desc')->paginate(20);
        if (request()->wantsJson()) return response()->json($prestasis);
        return view('prestasi.index', ['prestasis' => $prestasis]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->wantsJson()) return response()->json(['message' => 'Use POST /prestasi to create']);
        return view('prestasi.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_siswa' => 'nullable|string',
            'kelas' => 'nullable|string',
            'absen' => 'nullable|string',
            'nama_prestasi' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $p = Prestasi::create([
            'nama_siswa' => $data['nama_siswa'] ?? null,
            'kelas' => $data['kelas'] ?? null,
            'absen' => $data['absen'] ?? null,
            'nama_prestasi' => $data['nama_prestasi'],
            'deskripsi' => $data['keterangan'] ?? null,
        ]);
        if (request()->wantsJson()) return response()->json(['message' => 'Created', 'data' => $p],201);
        return redirect()->route('prestasi.index')->with('success','Prestasi dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $p = Prestasi::findOrFail($id);
        return response()->json($p);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $p = Prestasi::findOrFail($id);
        return view('prestasi.form', ['prestasi' => $p]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $p = Prestasi::findOrFail($id);
        $data = $request->validate([
            'nama_siswa' => 'nullable|string',
            'kelas' => 'nullable|string',
            'absen' => 'nullable|string',
            'nama_prestasi' => 'nullable|string',
            'keterangan' => 'nullable|string'
        ]);

        $payload = [];
        if (array_key_exists('nama_siswa', $data)) $payload['nama_siswa'] = $data['nama_siswa'];
        if (array_key_exists('kelas', $data)) $payload['kelas'] = $data['kelas'];
        if (array_key_exists('absen', $data)) $payload['absen'] = $data['absen'];
        if (array_key_exists('nama_prestasi', $data)) $payload['nama_prestasi'] = $data['nama_prestasi'];
        if (array_key_exists('keterangan', $data)) $payload['deskripsi'] = $data['keterangan'];

        $p->update($payload);
        if (request()->wantsJson()) return response()->json(['message' => 'Updated', 'data' => $p]);
        return redirect()->route('prestasi.index')->with('success','Prestasi diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $p = Prestasi::findOrFail($id);
        $p->delete();
        if (request()->wantsJson()) return response()->json(['message' => 'Deleted']);
        return redirect()->route('prestasi.index')->with('success','Prestasi dihapus');
    }
}
