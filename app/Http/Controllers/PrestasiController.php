<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestasi;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestasis = Prestasi::with(['siswa' => function($q) {
            $q->with('kelas');
        }])->orderBy('tanggal','desc')->paginate(20);
        if (request()->wantsJson()) return response()->json($prestasis);
        return view('prestasi.index', ['prestasis' => $prestasis]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->wantsJson()) return response()->json(['message' => 'Use POST /prestasi to create']);
        $siswa = User::with('kelas')->whereNotNull('nisn')->orderBy('name')->get();
        return view('prestasi.form', ['siswa' => $siswa]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'nama_prestasi' => 'required|string',
            'keterangan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp,svg,tiff,ico|max:5120'
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('prestasi', 'public');
        }

        $siswa = User::find($data['siswa_id']);
        $p = Prestasi::create([
            'siswa_id' => $data['siswa_id'],
            'nama_siswa' => $siswa->name,
            'kelas' => $siswa->kelas->nama_kelas ?? null,
            'absen' => $siswa->absen,
            'nama_prestasi' => $data['nama_prestasi'],
            'deskripsi' => $data['keterangan'] ?? null,
            'gambar' => $gambarPath,
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
        $siswa = User::with('kelas')->whereNotNull('nisn')->orderBy('name')->get();
        return view('prestasi.form', ['prestasi' => $p, 'siswa' => $siswa]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $p = Prestasi::findOrFail($id);
        $data = $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'nama_prestasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp,svg,tiff,ico|max:5120'
        ]);

        $siswa = User::find($data['siswa_id']);
        $payload = [
            'siswa_id' => $data['siswa_id'],
            'nama_siswa' => $siswa->name,
            'kelas' => $siswa->kelas->nama_kelas ?? null,
            'absen' => $siswa->absen,
            'nama_prestasi' => $data['nama_prestasi'],
            'deskripsi' => $data['keterangan'] ?? null,
        ];

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($p->gambar) {
                \Storage::disk('public')->delete($p->gambar);
            }
            $payload['gambar'] = $request->file('gambar')->store('prestasi', 'public');
        }

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
