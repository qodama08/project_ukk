<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Attendance::with(['siswa', 'guruWaliKelas', 'kelas']);

        // Only guru_wali_kelas and admin can view attendance
        if ($user->roles()->where('nama_role', 'guru_wali_kelas')->exists()) {
            // Guru wali kelas hanya bisa lihat absen untuk kelas mereka sendiri
            // Gunakan kelas_id dari user (wali kelas) untuk filter
            if ($user->kelas_id) {
                $query->where('kelas_id', $user->kelas_id);
            }
        } elseif ($user->role !== 'admin') {
            // Siswa hanya bisa lihat absennya sendiri
            $query->where('siswa_id', $user->id);
        }

        $attendance = $query->orderBy('tanggal', 'desc')->paginate(30);

        return view('attendance.index', ['attendance' => $attendance]);
    }

    /**
     * Show the form for creating attendance record.
     */
    public function create()
    {
        $user = Auth::user();

        // Only guru_wali_kelas can create attendance
        if (!$user->roles()->where('nama_role', 'guru_wali_kelas')->exists()) {
            abort(403, 'Hanya guru wali kelas yang bisa mencatat kehadiran');
        }

        // Get the class that this wali kelas manages (from kelas_id)
        if (!$user->kelas_id) {
            abort(403, 'Anda tidak terhubung ke kelas manapun');
        }

        $kelas = \App\Models\Kelas::findOrFail($user->kelas_id);
        // Only get students (users with role 'siswa') in this class
        $siswa = User::where('kelas_id', $user->kelas_id)
            ->whereHas('roles', function($q) {
                $q->where('nama_role', 'siswa');
            })
            ->orderBy('name')
            ->get();

        return view('attendance.form', [
            'siswa' => $siswa,
            'kelas' => $kelas,
        ]);
    }

    /**
     * Store attendance record in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Only guru_wali_kelas can create
        if (!$user->roles()->where('nama_role', 'guru_wali_kelas')->exists()) {
            abort(403, 'Hanya guru wali kelas yang bisa mencatat kehadiran');
        }

        if (!$user->kelas_id) {
            abort(403, 'Anda tidak terhubung ke kelas manapun');
        }

        // Allow bulk entry
        $entries = $request->validate([
            'tanggal' => 'required|date|before_or_equal:today',
            'entries' => 'required|array|min:1',
            'entries.*.siswa_id' => 'required|exists:users,id',
            'entries.*.status' => 'required|in:hadir,izin,sakit,alfa',
            'entries.*.keterangan' => 'nullable|string|max:200',
        ]);

        foreach ($entries['entries'] as $entry) {
            // Verify siswa is in this class
            $siswa = User::findOrFail($entry['siswa_id']);
            
            if ($siswa->kelas_id !== $user->kelas_id) {
                return back()->withErrors(['error' => 'Siswa ' . $siswa->name . ' bukan dari kelas Anda']);
            }

            // Check if record already exists for this date
            $exists = Attendance::where('siswa_id', $entry['siswa_id'])
                ->where('tanggal', $entries['tanggal'])
                ->first();

            if ($exists) {
                // Update existing record
                $exists->update([
                    'status' => $entry['status'],
                    'keterangan' => $entry['keterangan'] ?? null,
                ]);
            } else {
                // Create new record
                Attendance::create([
                    'siswa_id' => $entry['siswa_id'],
                    'guru_wali_kelas_id' => $user->id,
                    'kelas_id' => $user->kelas_id,
                    'tanggal' => $entries['tanggal'],
                    'status' => $entry['status'],
                    'keterangan' => $entry['keterangan'] ?? null,
                ]);
            }
        }

        return redirect()->route('attendance.index')->with('success', 'Kehadiran berhasil dicatat');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $attendance = Attendance::with(['siswa', 'guruWaliKelas', 'kelas'])->findOrFail($id);

        // Check authorization
        $user = Auth::user();
        if ($user->id !== $attendance->guru_wali_kelas_id && $user->id !== $attendance->siswa_id && $user->role !== 'admin') {
            abort(403);
        }

        return view('attendance.show', ['attendance' => $attendance]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $user = Auth::user();

        // Only the guru_wali_kelas who created it can edit
        if ($user->id !== $attendance->guru_wali_kelas_id && $user->role !== 'admin') {
            abort(403);
        }

        return view('attendance.edit', ['attendance' => $attendance]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $user = Auth::user();

        if ($user->id !== $attendance->guru_wali_kelas_id && $user->role !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alfa',
            'keterangan' => 'nullable|string|max:200',
        ]);

        $attendance->update($data);

        return redirect()->route('attendance.index')->with('success', 'Kehadiran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $user = Auth::user();

        if ($user->id !== $attendance->guru_wali_kelas_id && $user->role !== 'admin') {
            abort(403);
        }

        $attendance->delete();

        return redirect()->route('attendance.index')->with('success', 'Kehadiran berhasil dihapus');
    }

    /**
     * Daily report - view attendance for a specific date
     */
    public function dailyReport(Request $request)
    {
        $user = Auth::user();
        $tanggal = $request->get('tanggal', now()->format('Y-m-d'));

        $query = Attendance::with(['siswa', 'guruWaliKelas', 'kelas'])->where('tanggal', $tanggal);

        if ($user->roles()->where('nama_role', 'guru_wali_kelas')->exists()) {
            $waliKelas = $user->waliKelas;
            if ($waliKelas) {
                $query->where('kelas_id', $waliKelas->id);
            }
        }

        $attendance = $query->orderBy('siswa_id')->get();

        return view('attendance.daily_report', [
            'attendance' => $attendance,
            'tanggal' => $tanggal,
        ]);
    }

    /**
     * Summary report for a student
     */
    public function siswaReport(Request $request, $siswaId)
    {
        $user = Auth::user();
        $siswa = User::findOrFail($siswaId);

        // Check authorization
        if ($user->id !== $siswaId && $user->role !== 'admin' && !$user->waliKelas) {
            abort(403);
        }

        $monthYear = $request->get('month', now()->format('Y-m'));
        
        $attendance = Attendance::where('siswa_id', $siswaId)
            ->whereRaw('DATE_FORMAT(tanggal, "%Y-%m") = ?', [$monthYear])
            ->orderBy('tanggal', 'desc')
            ->get();

        // Calculate summary
        $summary = [
            'hadir' => $attendance->where('status', 'hadir')->count(),
            'izin' => $attendance->where('status', 'izin')->count(),
            'sakit' => $attendance->where('status', 'sakit')->count(),
            'alfa' => $attendance->where('status', 'alfa')->count(),
        ];

        return view('attendance.siswa_report', [
            'siswa' => $siswa,
            'attendance' => $attendance,
            'summary' => $summary,
            'monthYear' => $monthYear,
        ]);
    }
}
