<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Jurusan::orderBy('nama_jurusan')->get();
        return response()->json($items);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['message' => 'Use POST /jurusan to create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_jurusan' => 'required|string'
        ]);
        $j = Jurusan::create($data);
        return response()->json(['message' => 'Created', 'data' => $j],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $j = Jurusan::with('siswa')->findOrFail($id);
        return response()->json($j);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $j = Jurusan::findOrFail($id);
        return response()->json($j);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $j = Jurusan::findOrFail($id);
        $data = $request->validate([
            'nama_jurusan' => 'nullable|string'
        ]);
        $j->update($data);
        return response()->json(['message' => 'Updated', 'data' => $j]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $j = Jurusan::findOrFail($id);
        $j->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
