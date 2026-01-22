<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\User;
use App\Mail\PelanggaranTreshold;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

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
        $siswa = User::with('kelas')->whereHas('roles', function($q){ $q->where('nama_role','user'); })->orderBy('name')->get();
        
        // Get total points for each siswa
        $siswaWithPoints = $siswa->map(function($s) {
            $s->total_poin = Pelanggaran::where('siswa_id', $s->id)->sum('poin');
            return $s;
        });
        
        return view('pelanggaran.form', ['siswa' => $siswaWithPoints]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'nama_pelanggaran' => 'required|string|max:255',
            'poin' => 'required|numeric|min:0',
            'tingkat_warna' => 'required|in:hijau,kuning,merah',
        ]);

        // Get siswa data
        $siswa = User::findOrFail($data['siswa_id']);
        
        // Check current total points
        $currentTotalPoin = Pelanggaran::getTotalPoinSiswa($data['siswa_id']);
        
        // Validasi: siswa tidak boleh lebih dari 100 poin
        if ($currentTotalPoin >= 100) {
            return back()->withInput()->withErrors([
                'siswa_id' => "❌ Siswa {$siswa->name} sudah mencapai poin maksimal (100 poin). Tidak bisa menambahkan poin lagi."
            ]);
        }
        
        $newTotalPoin = $currentTotalPoin + $data['poin'];
        
        // Validasi: maksimal 100 poin per siswa
        if ($newTotalPoin > 100) {
            $sisanya = 100 - $currentTotalPoin;
            return back()->withInput()->withErrors([
                'poin' => "⚠️ Poin yang dapat ditambahkan maksimal {$sisanya} poin (saat ini siswa memiliki {$currentTotalPoin} poin, total maksimal adalah 100 poin per siswa)"
            ]);
        }
        
        // Create pelanggaran with siswa info
        $data['user_id'] = $data['siswa_id'];
        $data['nama_siswa'] = $siswa->name;
        $data['kelas'] = $siswa->kelas->nama_kelas ?? '';
        $data['absen'] = $siswa->absen ?? '';

        $pel = Pelanggaran::create($data);
        
        // Cek apakah sudah mencapai 100 poin, jika iya kirim email
        if ($newTotalPoin == 100 && $siswa->email) {
            try {
                \Log::info("Mencoba mengirim email ke: {$siswa->email} untuk siswa {$siswa->name}");
                Mail::to($siswa->email)->send(new PelanggaranTreshold($siswa, $newTotalPoin));
                \Log::info("Email notifikasi pelanggaran threshold berhasil dikirim ke {$siswa->email} untuk siswa {$siswa->name}");
            } catch (\Exception $e) {
                // Log error but don't stop the process
                \Log::error('Gagal mengirim email pelanggaran threshold: ' . $e->getMessage());
                \Log::error('Stack trace: ' . $e->getTraceAsString());
            }
        } else {
            if ($newTotalPoin == 100) {
                \Log::warning("Email siswa kosong atau tidak ada untuk: {$siswa->name}");
            }
        }
        
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Created', 'data' => $pel],201);
        }
        return redirect()->route('pelanggaran.index')->with('success','Pelanggaran dibuat. Total poin siswa: ' . $newTotalPoin . '/100 poin');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggaran $pelanggaran)
    {
        $pel = $pelanggaran->load('user');
        if (request()->wantsJson()) return response()->json($pel);
        $siswa = User::with('kelas')->whereHas('roles', function($q){ $q->where('nama_role','user'); })->orderBy('name')->get();
        
        // Get total points for each siswa
        $siswaWithPoints = $siswa->map(function($s) {
            $s->total_poin = Pelanggaran::where('siswa_id', $s->id)->sum('poin');
            return $s;
        });
        
        return view('pelanggaran.form', ['item' => $pel, 'siswa' => $siswaWithPoints]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelanggaran $pelanggaran)
    {
        $pel = $pelanggaran->load('user');
        if (request()->wantsJson()) return response()->json($pel);
        $siswa = User::with('kelas')->whereHas('roles', function($q){ $q->where('nama_role','user'); })->orderBy('name')->get();
        
        // Get total points for each siswa
        $siswaWithPoints = $siswa->map(function($s) {
            $s->total_poin = Pelanggaran::where('siswa_id', $s->id)->sum('poin');
            return $s;
        });
        
        return view('pelanggaran.form', ['item' => $pel, 'siswa' => $siswaWithPoints]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $pel = $pelanggaran;
        $data = $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'nama_pelanggaran' => 'required|string|max:255',
            'poin' => 'required|numeric|min:0',
            'tingkat_warna' => 'required|in:hijau,kuning,merah',
        ]);
        
        // Get siswa data
        $siswa = User::findOrFail($data['siswa_id']);
        
        // Calculate new total points (excluding current pelanggaran)
        $currentTotalPoin = Pelanggaran::where('siswa_id', $data['siswa_id'])
            ->where('id', '!=', $pel->id)
            ->sum('poin');
        
        // Cek apakah siswa adalah siswa yang berbeda
        if ($data['siswa_id'] != $pel->siswa_id) {
            // Jika siswa berbeda, cek apakah siswa baru sudah 100 poin
            if ($currentTotalPoin >= 100) {
                return back()->withInput()->withErrors([
                    'siswa_id' => "❌ Siswa {$siswa->name} sudah mencapai poin maksimal (100 poin). Tidak bisa menambahkan poin lagi."
                ]);
            }
        }
        
        $newTotalPoin = $currentTotalPoin + $data['poin'];
        
        // Validasi: maksimal 100 poin per siswa
        if ($newTotalPoin > 100) {
            $sisanya = 100 - $currentTotalPoin;
            return back()->withInput()->withErrors([
                'poin' => "⚠️ Poin yang dapat ditambahkan maksimal {$sisanya} poin (saat ini siswa memiliki {$currentTotalPoin} poin, total maksimal adalah 100 poin per siswa)"
            ]);
        }
        
        // Update pelanggaran with siswa info
        $data['user_id'] = $data['siswa_id'];
        $data['nama_siswa'] = $siswa->name;
        $data['kelas'] = $siswa->kelas->nama_kelas ?? '';
        $data['absen'] = $siswa->absen ?? '';
        
        $pel->update($data);
        
        // Cek apakah sudah mencapai 100 poin, jika iya kirim email
        if ($newTotalPoin == 100 && $siswa->email) {
            // Cek apakah sudah pernah mengirim email untuk siswa ini
            $hasBeenNotified = Pelanggaran::where('siswa_id', $data['siswa_id'])
                ->where('notified_at', '!=', null)
                ->exists();
            
            if (!$hasBeenNotified) {
                try {
                    \Log::info("Mencoba mengirim email ke: {$siswa->email} untuk siswa {$siswa->name}");
                    Mail::to($siswa->email)->send(new PelanggaranTreshold($siswa, $newTotalPoin));
                    // Mark as notified
                    $pel->notified_at = now();
                    $pel->save();
                    \Log::info("Email notifikasi pelanggaran threshold berhasil dikirim ke {$siswa->email} untuk siswa {$siswa->name}");
                } catch (\Exception $e) {
                    \Log::error('Gagal mengirim email pelanggaran threshold: ' . $e->getMessage());
                    \Log::error('Stack trace: ' . $e->getTraceAsString());
                }
            }
        } else {
            if ($newTotalPoin == 100) {
                \Log::warning("Email siswa kosong atau tidak ada untuk: {$siswa->name}");
            }
        }
        
        if (request()->wantsJson()) return response()->json(['message' => 'Updated', 'data' => $pel]);
        return redirect()->route('pelanggaran.index')->with('success','Pelanggaran diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggaran $pelanggaran)
    {
        $pel = $pelanggaran;
        $pel->delete();
        if (request()->wantsJson()) return response()->json(['message' => 'Deleted']);
        return redirect()->route('pelanggaran.index')->with('success','Pelanggaran dihapus');
    }
}
