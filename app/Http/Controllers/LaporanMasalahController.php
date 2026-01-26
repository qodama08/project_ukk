<?php

namespace App\Http\Controllers;

use App\Models\LaporanMasalah;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanMasalahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = LaporanMasalah::with(['siswa', 'guruMapel', 'guruWaliKelas', 'admin', 'kelas']);

        // Filter based on user role
        if ($user->roles()->where('nama_role', 'guru_mapel')->exists()) {
            // Guru mapel hanya bisa lihat laporan yang dia buat
            $query->where('guru_mapel_id', $user->id);
        } elseif ($user->roles()->where('nama_role', 'guru_wali_kelas')->exists()) {
            // Guru wali kelas bisa lihat laporan untuk kelas yang dia ajar
            $waliKelas = $user->waliKelas;
            if ($waliKelas) {
                $query->where('kelas_id', $waliKelas->id);
            }
        } elseif ($user->role !== 'admin') {
            // Siswa hanya bisa lihat laporan tentang dirinya
            $query->where('siswa_id', $user->id);
        }

        $laporan = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('laporan_masalah.index', ['laporan' => $laporan]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        // Only guru_mapel can create laporan
        if (!$user->roles()->where('nama_role', 'guru_mapel')->exists()) {
            abort(403, 'Hanya guru mata pelajaran yang bisa membuat laporan');
        }

        // Get all students
        $siswa = User::whereHas('roles', function ($q) {
                $q->where('nama_role', 'siswa');
            })->orderBy('name')->get();

        return view('laporan_masalah.form', ['siswa' => $siswa]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Only guru_mapel can create laporan
        if (!$user->roles()->where('nama_role', 'guru_mapel')->exists()) {
            abort(403, 'Hanya guru mata pelajaran yang bisa membuat laporan');
        }

        $data = $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'tanggal_kejadian' => 'required|date|before_or_equal:today',
            'jam_pelajaran' => 'required|string|max:50',
            'mata_pelajaran' => 'required|string|max:100',
            'deskripsi_masalah' => 'required|string|min:10|max:1000',
            'tindakan_guru' => 'nullable|string|max:500',
        ]);

        // Get siswa to find their kelas
        $siswa = User::findOrFail($data['siswa_id']);
        $data['guru_mapel_id'] = $user->id;
        $data['kelas_id'] = $siswa->kelas_id;
        $data['status'] = 'baru';

        $laporan = LaporanMasalah::create($data);

        // Notify guru wali kelas
        if ($siswa->kelas && $siswa->kelas->wali_kelas_id) {
            try {
                $waliKelas = User::findOrFail($siswa->kelas->wali_kelas_id);
                \App\Models\Notifikasi::create([
                    'user_id' => $waliKelas->id,
                    'title' => 'Laporan Masalah Baru dari Guru Mata Pelajaran',
                    'message' => 'Ada laporan masalah dari ' . $user->name . ' mengenai siswa ' . $siswa->name . ' pada ' . $data['tanggal_kejadian'],
                    'data' => json_encode(['laporan_id' => $laporan->id]),
                    'is_read' => false,
                ]);
            } catch (\Exception $e) {
                // ignore notification errors
            }
        }

        return redirect()->route('laporan_masalah.index')->with('success', 'Laporan masalah berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $laporan = LaporanMasalah::with(['siswa', 'guruMapel', 'guruWaliKelas', 'admin', 'kelas'])->findOrFail($id);
        $user = Auth::user();

        // Check authorization
        if ($user->roles()->where('nama_role', 'guru_mapel')->exists()) {
            // Guru mapel hanya bisa lihat laporan yang dia buat
            if ($laporan->guru_mapel_id !== $user->id) {
                abort(403, 'Anda tidak berhak melihat laporan ini');
            }
        } elseif ($user->roles()->where('nama_role', 'guru_wali_kelas')->exists()) {
            // Guru wali kelas bisa lihat laporan untuk kelas yang dia ajar
            if ($laporan->kelas_id !== $user->kelas_id) {
                abort(403, 'Laporan ini bukan untuk kelas Anda');
            }
        } elseif ($user->role !== 'admin') {
            // Siswa hanya bisa lihat laporan tentang dirinya
            if ($laporan->siswa_id !== $user->id) {
                abort(403, 'Anda tidak berhak melihat laporan ini');
            }
        }

        return view('laporan_masalah.show', ['laporan' => $laporan]);
    }

    /**
     * Show form to accept laporan (for guru wali kelas)
     */
    public function terima($id)
    {
        $laporan = LaporanMasalah::findOrFail($id);
        $user = Auth::user();

        // Only guru wali kelas for this class can accept
        if (!$user->waliKelas || $user->waliKelas->id !== $laporan->kelas_id) {
            abort(403, 'Anda tidak berhak menerima laporan ini');
        }

        return view('laporan_masalah.terima', ['laporan' => $laporan]);
    }

    /**
     * Accept laporan (guru wali kelas)
     */
    public function storeTerima(Request $request, $id)
    {
        $laporan = LaporanMasalah::findOrFail($id);
        $user = Auth::user();

        if (!$user->waliKelas || $user->waliKelas->id !== $laporan->kelas_id) {
            abort(403, 'Anda tidak berhak menerima laporan ini');
        }

        $data = $request->validate([
            'catatan_wali_kelas' => 'nullable|string|max:500',
        ]);

        $laporan->markAsDiterimaWali();
        if ($data['catatan_wali_kelas']) {
            $laporan->catatan_wali_kelas = $data['catatan_wali_kelas'];
        }
        $laporan->save();

        return redirect()->route('laporan_masalah.index')->with('success', 'Laporan diterima');
    }

    /**
     * Show form to forward laporan to admin (for guru wali kelas)
     */
    public function teruskan($id)
    {
        $laporan = LaporanMasalah::findOrFail($id);
        $user = Auth::user();

        if (!$user->waliKelas || $user->waliKelas->id !== $laporan->kelas_id) {
            abort(403, 'Anda tidak berhak meneruskan laporan ini');
        }

        return view('laporan_masalah.teruskan', ['laporan' => $laporan]);
    }

    /**
     * Forward laporan to admin (guru wali kelas)
     */
    public function storeTeruskan(Request $request, $id)
    {
        $laporan = LaporanMasalah::findOrFail($id);
        $user = Auth::user();

        if (!$user->waliKelas || $user->waliKelas->id !== $laporan->kelas_id) {
            abort(403, 'Anda tidak berhak meneruskan laporan ini');
        }

        $data = $request->validate([
            'catatan_wali_kelas' => 'nullable|string|max:500',
        ]);

        if ($data['catatan_wali_kelas']) {
            $laporan->catatan_wali_kelas = $data['catatan_wali_kelas'];
        }

        $laporan->markAsDiteruskanAdmin();
        $laporan->save();

        // Notify all admins
        try {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                \App\Models\Notifikasi::create([
                    'user_id' => $admin->id,
                    'title' => 'Laporan Masalah Baru dari Guru Wali Kelas',
                    'message' => 'Laporan masalah tentang siswa ' . $laporan->siswa->name . ' telah diteruskan oleh ' . $user->name,
                    'data' => json_encode(['laporan_id' => $laporan->id]),
                    'is_read' => false,
                ]);
            }
        } catch (\Exception $e) {
            // ignore
        }

        return redirect()->route('laporan_masalah.index')->with('success', 'Laporan diteruskan ke admin');
    }

    /**
     * Handle laporan (admin)
     */
    public function handle($id)
    {
        $laporan = LaporanMasalah::findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa menangani laporan');
        }

        return view('laporan_masalah.handle', ['laporan' => $laporan]);
    }

    /**
     * Store handle (admin)
     */
    public function storeHandle(Request $request, $id)
    {
        $laporan = LaporanMasalah::findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa menangani laporan');
        }

        $data = $request->validate([
            'catatan_admin' => 'required|string|min:10|max:1000',
            'tindakan' => 'required|in:ditanggani,selesai',
        ]);

        $laporan->catatan_admin = $data['catatan_admin'];
        $laporan->admin_id = $user->id;

        if ($data['tindakan'] === 'ditanggani') {
            $laporan->markAsDitangani();
        } else {
            $laporan->markAsSelesai();
        }

        $laporan->save();

        // Notify guru mapel
        try {
            \App\Models\Notifikasi::create([
                'user_id' => $laporan->guru_mapel_id,
                'title' => 'Laporan Masalah Ditanggani Admin',
                'message' => 'Laporan masalah Anda tentang siswa ' . $laporan->siswa->name . ' telah ditanggani oleh admin',
                'data' => json_encode(['laporan_id' => $laporan->id]),
                'is_read' => false,
            ]);
        } catch (\Exception $e) {
            // ignore
        }

        return redirect()->route('laporan_masalah.index')->with('success', 'Laporan ditanggani');
    }
}
