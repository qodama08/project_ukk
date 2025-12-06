<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('siswa')) {
            // nothing to migrate
            return;
        }

        // Build mapping from old siswa.id -> new users.id (create users when needed)
        $mapping = [];
        $siswaRows = \DB::table('siswa')->get();
        foreach ($siswaRows as $row) {
            // prefer matching by nisn if exists
            $existing = null;
            if (!empty($row->nisn)) {
                $existing = \DB::table('users')->where('nisn', $row->nisn)->first();
            }
            if ($existing) {
                $newId = $existing->id;
            } else {
                $newId = \DB::table('users')->insertGetId([
                    'name' => $row->nama,
                    'email' => null,
                    'role' => 'user',
                    'password' => bcrypt(bin2hex(random_bytes(8))),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'nisn' => $row->nisn ?? null,
                    'kelas_id' => $row->kelas_id ?? null,
                    'jurusan_id' => $row->jurusan_id ?? null,
                    'absen' => $row->absen ?? null,
                    'umur' => $row->umur ?? null,
                    'nomor_hp' => $row->nomor_hp ?? null,
                    'alamat' => $row->alamat ?? null,
                    'nama_ayah' => $row->nama_ayah ?? null,
                    'nama_ibu' => $row->nama_ibu ?? null,
                    'nama_wali' => $row->nama_wali ?? null,
                    'hubungan_wali' => $row->hubungan_wali ?? null,
                    'nomor_hp_wali' => $row->nomor_hp_wali ?? null,
                ]);
            }
            $mapping[$row->id] = $newId;
        }

        // Tables that reference siswa_id (detected from migrations)
        $tables = [
            'prestasi', 'laporan', 'laporans', 'jadwal_konseling', 'arsip_dokumen',
            'surat_panggilan', 'pengaduan', 'catatan_konseling',
            'catatan_perkembangan', 'pelanggaran'
        ];

        foreach ($tables as $tbl) {
            if (!Schema::hasTable($tbl)) continue;

            // add user_id column if not exists
            if (!Schema::hasColumn($tbl, 'user_id')) {
                Schema::table($tbl, function (Blueprint $table) use ($tbl) {
                    $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
                });
            }

            // update user_id based on mapping where siswa_id exists
            if (Schema::hasColumn($tbl, 'siswa_id')) {
                foreach ($mapping as $old => $new) {
                    \DB::table($tbl)->where('siswa_id', $old)->update(['user_id' => $new]);
                }

                // drop foreign key and siswa_id column
                Schema::table($tbl, function (Blueprint $table) use ($tbl) {
                    try { $table->dropForeign(['siswa_id']); } catch (\Exception $e) {}
                    try { $table->dropColumn('siswa_id'); } catch (\Exception $e) {}
                });
            }
        }

        // Finally drop siswa table
        try {
            Schema::dropIfExists('siswa');
        } catch (\Exception $e) {
            // If drop fails due to remaining foreign keys, log and rethrow
            \Log::warning('Failed to drop siswa table: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restoring original siswa table is non-trivial; this down() is intentionally left empty.
    }
};
