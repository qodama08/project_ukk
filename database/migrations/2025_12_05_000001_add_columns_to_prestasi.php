<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            if (!Schema::hasColumn('prestasi', 'nama_siswa')) {
                $table->string('nama_siswa')->nullable()->after('siswa_id');
            }
            if (!Schema::hasColumn('prestasi', 'kelas')) {
                $table->string('kelas')->nullable()->after('nama_siswa');
            }
            if (!Schema::hasColumn('prestasi', 'absen')) {
                $table->string('absen')->nullable()->after('kelas');
            }
        });
    }

    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            if (Schema::hasColumn('prestasi', 'absen')) $table->dropColumn('absen');
            if (Schema::hasColumn('prestasi', 'kelas')) $table->dropColumn('kelas');
            if (Schema::hasColumn('prestasi', 'nama_siswa')) $table->dropColumn('nama_siswa');
        });
    }
};
