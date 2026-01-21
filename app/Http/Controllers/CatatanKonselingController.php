<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatatanKonseling;
use App\Models\JadwalKonseling;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CatatanKonselingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = CatatanKonseling::with(['siswa','guru','jadwal'])->orderBy('created_at','desc');

        // Jika admin (Guru BK), hanya tampilkan catatan yang mereka handle
        if ($user && ($user->role === 'admin' || $user->roles()->where('nama_role','admin')->exists())) {
            $query->where('guru_bk_id', $user->id);
        }

        $notes = $query->paginate(20);
        if (request()->wantsJson()) return response()->json($notes);
        return view('catatan_konseling.index', ['notes' => $notes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->wantsJson()) return response()->json(['message' => 'Use POST /catatan_konseling to create']);
        return view('catatan_konseling.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'jadwal_id' => 'required|exists:jadwal_konseling,id',
            'hasil' => 'required|string',
            'tindak_lanjut' => 'nullable|string',
            'evaluasi' => 'nullable|string',
            'guru_bk_id' => 'nullable|exists:users,id',
        ]);

        // Check if catatan konseling already exists for this jadwal
        $existingNote = CatatanKonseling::where('jadwal_id', $data['jadwal_id'])->first();
        if ($existingNote) {
            // Redirect to edit the existing catatan
            if (request()->wantsJson()) return response()->json(['message' => 'Catatan sudah ada, redirecting to edit', 'redirect' => route('catatan_konseling.edit', $existingNote->id)], 302);
            return redirect()->route('catatan_konseling.edit', $existingNote->id)->with('info', 'Catatan konseling sudah ada, silakan edit data yang sudah ada.');
        }

        $jadwal = JadwalKonseling::findOrFail($data['jadwal_id']);

        $data['siswa_id'] = $jadwal->siswa_id;
        $data['guru_bk_id'] = $data['guru_bk_id'] ?? (Auth::check() ? Auth::id() : $jadwal->guru_bk_id);
        $data['created_at'] = now();

        $note = CatatanKonseling::create($data);

        // mark jadwal as selesai
        $jadwal->update(['status' => 'selesai']);

        if (request()->wantsJson()) return response()->json(['message' => 'Catatan dikirim', 'data' => $note],201);
        return redirect()->route('catatan_konseling.index')->with('success','Catatan dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $note = CatatanKonseling::with(['siswa','guru','jadwal'])->findOrFail($id);
        if (request()->wantsJson()) return response()->json($note);
        return view('catatan_konseling.form', ['note' => $note]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $note = CatatanKonseling::with(['siswa','guru','jadwal'])->findOrFail($id);
        if (request()->wantsJson()) return response()->json($note);
        return view('catatan_konseling.form', ['note' => $note]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $note = CatatanKonseling::findOrFail($id);
        $data = $request->validate([
            'hasil' => 'nullable|string',
            'tindak_lanjut' => 'nullable|string',
            'evaluasi' => 'nullable|string',
        ]);

        $note->update($data);
        if (request()->wantsJson()) return response()->json(['message' => 'Updated', 'data' => $note]);
        return redirect()->route('catatan_konseling.index')->with('success','Catatan diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $note = CatatanKonseling::findOrFail($id);
        $note->delete();
        if (request()->wantsJson()) return response()->json(['message' => 'Deleted']);
        return redirect()->route('catatan_konseling.index')->with('success','Catatan dihapus');
    }

    /**
     * Approve (ACC) a catatan - admin only
     */
    public function approve(Request $request, $id)
    {
        $note = CatatanKonseling::with('jadwal')->findOrFail($id);

        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();

        // allow if admin OR the guru_bk assigned to the jadwal
        $isAdmin = ($user->roles()->where('nama_role','admin')->exists());
        $isAssignedGuru = ($note->guru_bk_id && $user->id == $note->guru_bk_id);

        if (!($isAdmin || $isAssignedGuru)) {
            abort(403, 'Unauthorized');
        }

        $note->status = 'setuju';
        $note->save();

        // also mark jadwal as selesai
        if ($note->jadwal) {
            try { $note->jadwal->update(['status' => 'selesai']); } catch (\Exception $e) {}
        }

        if (request()->wantsJson()) return response()->json(['message' => 'Catatan disetujui', 'data' => $note]);
        return redirect()->back()->with('success','Catatan disetujui');
    }
}
