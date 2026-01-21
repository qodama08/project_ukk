<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pelanggaran')) {
            Schema::table('pelanggaran', function (Blueprint $table) {
                $table->string('nama_siswa')->nullable();
                $table->string('kelas')->nullable();
                $table->string('absen')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pelanggaran')) {
            Schema::table('pelanggaran', function (Blueprint $table) {
                $table->dropColumn(['nama_siswa','kelas','absen']);
            });
        }
    }
};
