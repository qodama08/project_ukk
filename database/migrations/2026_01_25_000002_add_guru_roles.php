<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Insert new roles
        DB::table('roles')->insert([
            [
                'nama_role' => 'guru_mapel',
                'deskripsi' => 'Guru Mata Pelajaran - Bisa melaporkan masalah siswa dan mencatat kehadiran',
                'is_multi' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role' => 'guru_wali_kelas',
                'deskripsi' => 'Guru Wali Kelas - Menerima laporan dari guru mapel dan meneruskan ke admin',
                'is_multi' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('roles')->whereIn('nama_role', ['guru_mapel', 'guru_wali_kelas'])->delete();
    }
};
