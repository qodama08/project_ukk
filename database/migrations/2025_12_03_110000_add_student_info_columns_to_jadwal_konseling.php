<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('jadwal_konseling')) {
            Schema::table('jadwal_konseling', function (Blueprint $table) {
                $table->string('nama_siswa')->nullable()->after('siswa_id');
                $table->string('kelas')->nullable()->after('nama_siswa');
                $table->string('absen')->nullable()->after('kelas');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('jadwal_konseling')) {
            Schema::table('jadwal_konseling', function (Blueprint $table) {
                $table->dropColumn(['nama_siswa', 'kelas', 'absen']);
            });
        }
    }
};
