<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalKonseling;
use App\Models\User;
use App\Models\Kelas;
use App\Models\CatatanKonseling;
use Illuminate\Support\Facades\Auth;

class JadwalKonselingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = JadwalKonseling::with(['siswa','guru','catatan'])->orderBy('tanggal','desc');

        // Semua user bisa melihat semua jadwal konseling

        $jadwals = $query->paginate(20);
        if (request()->wantsJson()) return response()->json($jadwals);
        return view('jadwal_konseling.index', ['jadwals' => $jadwals]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Use POST /jadwal_konseling to create']);
        }
        // Only pass siswa data if user is admin
        $isAdmin = auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->roles()->where('nama_role','admin')->exists());
        $siswa = $isAdmin ? User::with('kelas')->whereDoesntHave('roles')->orWhereHas('roles', function($q){ $q->where('nama_role','user'); })->orderBy('name')->get() : [];
        $gurus = User::where('role', 'admin')->where('email', '!=', 'admin@gmail.com')->orderBy('name')->get();
        $kelasJurusanOptions = Kelas::with('jurusan')->orderBy('tingkat')->orderBy('nama_kelas')->get();
        return view('jadwal_konseling.form', ['siswa' => $siswa, 'gurus' => $gurus, 'kelasJurusanOptions' => $kelasJurusanOptions, 'isAdmin' => $isAdmin]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user && ($user->role == 'admin' || $user->roles()->where('nama_role','admin')->exists());

        // Different validation rules for admin vs student
        if ($isAdmin) {
            $data = $request->validate([
                'siswa_id' => 'required|exists:users,id',
                'tanggal' => 'required|date',
                'jam' => 'required',
                'status' => 'nullable|in:pending,terjadwal,selesai,batal',
                'guru_bk_id' => 'required|exists:users,id',
            ]);
            
            // Get siswa data for nama, kelas, absen
            $siswa = User::findOrFail($data['siswa_id']);
            $data['nama_siswa'] = $siswa->name;
            $data['kelas'] = $siswa->kelas->nama_kelas ?? null;
            $data['absen'] = $siswa->absen;
            $data['status'] = $data['status'] ?? 'pending';
        } else {
            // Student: nama, kelas, dan absen harus sama dengan data login mereka
            $data = $request->validate([
                'nama_siswa' => 'required|string|max:255',
                'kelas' => 'required|string|max:50',
                'absen' => 'required|string|max:10',
                'tanggal' => 'required|date',
                'jam' => 'required',
                'guru_bk_id' => 'required|exists:users,id',
            ]);

            // Validate that nama_siswa matches authenticated user
            if ($data['nama_siswa'] !== $user->name) {
                return back()->withInput()->withErrors(['nama_siswa' => 'Nama siswa harus sesuai dengan data login Anda']);
            }

            // Validate that kelas matches authenticated user's kelas
            if ($data['kelas'] !== ($user->kelas->nama_kelas ?? '')) {
                return back()->withInput()->withErrors(['kelas' => 'Kelas harus sesuai dengan data login Anda']);
            }

            // Validate that absen matches authenticated user's absen
            if ($data['absen'] != $user->absen) {
                return back()->withInput()->withErrors(['absen' => 'Nomor absen harus sesuai dengan data login Anda']);
            }

            $data['siswa_id'] = $user->id;
            $data['status'] = 'pending';
        }

        // Ensure tanggal is not before today
        if (isset($data['tanggal']) && $data['tanggal'] < now()->format('Y-m-d')) {
            return back()->withInput()->withErrors(['tanggal' => 'Tanggal tidak boleh sebelum hari ini.']);
        }

        try {
            $jadwal = JadwalKonseling::create($data);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan jadwal: ' . $e->getMessage()]);
        }

        // Create notifications for all admins so they can review the pending jadwal
        try {
            $admins = User::whereHas('roles', function($q){ $q->where('nama_role','admin'); })->get();
            foreach ($admins as $admin) {
                \App\Models\Notifikasi::create([
                    'user_id' => $admin->id,
                    'title' => 'Pengajuan Jadwal Konseling Baru',
                    'message' => 'Terdapat pengajuan jadwal dari ' . ($jadwal->nama_siswa ?? 'siswa') . ' pada ' . ($jadwal->tanggal ?? '') . ' ' . ($jadwal->jam ?? '') . '. Klik untuk melihat.',
                    'data' => json_encode(['jadwal_id' => $jadwal->id]),
                    'is_read' => false,
                ]);
            }
        } catch (\Exception $e) {
            // ignore notification failures
        }

        if (request()->wantsJson()) return response()->json(['message' => 'Jadwal created', 'data' => $jadwal],201);
        return redirect()->route('jadwal_konseling.index')->with('success','Jadwal dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jadwal = JadwalKonseling::with(['siswa','guru'])->findOrFail($id);
        if (request()->wantsJson()) return response()->json($jadwal);
        
        $isAdmin = auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->roles()->where('nama_role','admin')->exists());
        $siswa = $isAdmin ? User::with('kelas')->whereHas('roles', function($q){ $q->where('nama_role','user'); })->whereNotNull('kelas_id')->orderBy('name')->get() : [];
        $gurus = User::whereHas('roles', function($q){ $q->where('nama_role','admin'); })->orderBy('name')->get();
        $kelasJurusanOptions = Kelas::with('jurusan')->orderBy('tingkat')->orderBy('nama_kelas')->get();
        
        // Show form view that displays details and allows status update (form will be read-only except for admin status field)
        return view('jadwal_konseling.form', ['jadwal' => $jadwal, 'siswa' => $siswa, 'gurus' => $gurus, 'kelasJurusanOptions' => $kelasJurusanOptions, 'isAdmin' => $isAdmin]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jadwal = JadwalKonseling::with(['siswa','guru'])->findOrFail($id);
        if (request()->wantsJson()) return response()->json($jadwal);
        
        $isAdmin = auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->roles()->where('nama_role','admin')->exists());
        $siswa = $isAdmin ? User::with('kelas')->whereHas('roles', function($q){ $q->where('nama_role','user'); })->whereNotNull('kelas_id')->orderBy('name')->get() : [];
        $gurus = User::whereHas('roles', function($q){ $q->where('nama_role','admin'); })->orderBy('name')->get();
        $kelasJurusanOptions = Kelas::with('jurusan')->orderBy('tingkat')->orderBy('nama_kelas')->get();
        
        // only the owner (siswa who created the jadwal) may edit
        if (!Auth::check() || Auth::id() != $jadwal->siswa_id) {
            abort(403, 'Unauthorized - only owner can edit jadwal');
        }

        return view('jadwal_konseling.form', ['jadwal' => $jadwal, 'siswa' => $siswa, 'gurus' => $gurus, 'kelasJurusanOptions' => $kelasJurusanOptions, 'isAdmin' => $isAdmin]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jadwal = JadwalKonseling::findOrFail($id);
        // only owner may update
        if (!Auth::check() || Auth::id() != $jadwal->siswa_id) {
            abort(403, 'Unauthorized - only owner can update jadwal');
        }
        $data = $request->validate([
            'nama_siswa' => 'required|string',
            'kelas' => 'required|string',
            'absen' => 'required|string',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'tempat' => 'nullable|string',
            'status' => 'nullable|in:pending,terjadwal,selesai,batal',
            'guru_bk_id' => 'nullable|exists:users,id',
        ]);

        // Ensure tanggal is not before today
        if (isset($data['tanggal']) && $data['tanggal'] < now()->format('Y-m-d')) {
            return back()->withInput()->withErrors(['tanggal' => 'Tanggal tidak boleh sebelum hari ini.']);
        }

        $jadwal->update($data);
        if (request()->wantsJson()) return response()->json(['message' => 'Updated', 'data' => $jadwal]);
        return redirect()->route('jadwal_konseling.index')->with('success','Jadwal diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jadwal = JadwalKonseling::findOrFail($id);
        // only owner may delete
        if (!Auth::check() || Auth::id() != $jadwal->siswa_id) {
            abort(403, 'Unauthorized - only owner can delete jadwal');
        }

        $jadwal->delete();
        if (request()->wantsJson()) return response()->json(['message' => 'Deleted']);
        return redirect()->route('jadwal_konseling.index')->with('success','Jadwal dihapus');
    }

    /**
     * Set status (admin action)
     */
    public function setStatus(Request $request, $id)
    {
        // Verify user is admin
        $user = auth()->user();
        if (!$user || !($user->role === 'admin' || $user->roles()->where('nama_role','admin')->exists())) {
            abort(403, 'Unauthorized - only admin can change status');
        }

        $jadwal = JadwalKonseling::findOrFail($id);
        $data = $request->validate([
            'status' => 'required|in:pending,terjadwal,selesai,batal'
        ]);

        $jadwal->status = $data['status'];
        $jadwal->save();

        // Mark related notifications as read (any notifikasi that references this jadwal)
        try {
            $notifs = \App\Models\Notifikasi::whereRaw("JSON_EXTRACT(data, '$.jadwal_id') = ?", [$jadwal->id])->get();
            foreach ($notifs as $n) {
                $n->is_read = true;
                $n->save();
            }
        } catch (\Exception $e) {
            // ignore notification update failures
        }

        return redirect()->route('jadwal_konseling.index')->with('success', 'Status diperbarui');
    }

    /**
     * Cancel schedule (admin action with reason)
     */
    public function cancelSchedule(Request $request, $id)
    {
        // Verify user is admin
        $user = auth()->user();
        if (!$user || !($user->role === 'admin' || $user->roles()->where('nama_role','admin')->exists())) {
            abort(403, 'Unauthorized - only admin can cancel schedule');
        }

        $jadwal = JadwalKonseling::findOrFail($id);
        $data = $request->validate([
            'alasan_batal' => 'required|string|min:5|max:500'
        ]);

        $jadwal->status = 'batal';
        $jadwal->alasan_batal = $data['alasan_batal'];
        $jadwal->save();

        // Mark related notifications as read
        try {
            $notifs = \App\Models\Notifikasi::whereRaw("JSON_EXTRACT(data, '$.jadwal_id') = ?", [$jadwal->id])->get();
            foreach ($notifs as $n) {
                $n->is_read = true;
                $n->save();
            }
        } catch (\Exception $e) {
            // ignore notification update failures
        }

        return redirect()->route('jadwal_konseling.index')->with('success', 'Jadwal dibatalkan');
    }
}
