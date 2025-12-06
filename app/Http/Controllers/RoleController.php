<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['message' => 'Use POST /roles to create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_role' => 'required|string',
            'deskripsi' => 'nullable|string',
            'is_multi' => 'nullable|boolean'
        ]);
        $r = Role::create($data);
        return response()->json(['message' => 'Created', 'data' => $r],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $r = Role::with('users')->findOrFail($id);
        return response()->json($r);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $r = Role::findOrFail($id);
        return response()->json($r);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $r = Role::findOrFail($id);
        $data = $request->validate([
            'nama_role' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'is_multi' => 'nullable|boolean'
        ]);
        $r->update($data);
        return response()->json(['message' => 'Updated', 'data' => $r]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $r = Role::findOrFail($id);
        $r->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
