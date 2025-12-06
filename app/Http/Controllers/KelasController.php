<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\User;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::with('wali')->orderBy('nama_kelas')->get();
        return response()->json($kelas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['message' => 'Use POST /kelas to create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kelas' => 'required|string',
            'tingkat' => 'required|integer',
            'wali_kelas_id' => 'nullable|exists:users,id',
            'tahun_ajaran' => 'nullable|string'
        ]);

        $k = Kelas::create($data);
        return response()->json(['message' => 'Created', 'data' => $k],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $k = Kelas::with('wali','siswa')->findOrFail($id);
        return response()->json($k);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $k = Kelas::findOrFail($id);
        return response()->json($k);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $k = Kelas::findOrFail($id);
        $data = $request->validate([
            'nama_kelas' => 'nullable|string',
            'tingkat' => 'nullable|integer',
            'wali_kelas_id' => 'nullable|exists:users,id',
            'tahun_ajaran' => 'nullable|string'
        ]);
        $k->update($data);
        return response()->json(['message' => 'Updated', 'data' => $k]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $k = Kelas::findOrFail($id);
        $k->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
