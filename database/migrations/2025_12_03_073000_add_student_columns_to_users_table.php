<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) return;

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nisn')) {
                $table->string('nisn')->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('users', 'kelas_id')) {
                $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete()->after('role');
            }
            if (!Schema::hasColumn('users', 'jurusan_id')) {
                $table->foreignId('jurusan_id')->nullable()->constrained('jurusan')->nullOnDelete()->after('kelas_id');
            }
            if (!Schema::hasColumn('users', 'absen')) {
                $table->integer('absen')->nullable()->after('jurusan_id');
            }
            if (!Schema::hasColumn('users', 'umur')) {
                $table->integer('umur')->nullable()->after('absen');
            }
            if (!Schema::hasColumn('users', 'nomor_hp')) {
                $table->string('nomor_hp')->nullable()->after('umur');
            }
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable()->after('nomor_hp');
            }
            if (!Schema::hasColumn('users', 'nama_ayah')) {
                $table->string('nama_ayah')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('users', 'nama_ibu')) {
                $table->string('nama_ibu')->nullable()->after('nama_ayah');
            }
            if (!Schema::hasColumn('users', 'nama_wali')) {
                $table->string('nama_wali')->nullable()->after('nama_ibu');
            }
            if (!Schema::hasColumn('users', 'hubungan_wali')) {
                $table->string('hubungan_wali')->nullable()->after('nama_wali');
            }
            if (!Schema::hasColumn('users', 'nomor_hp_wali')) {
                $table->string('nomor_hp_wali')->nullable()->after('hubungan_wali');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('users')) return;

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'nomor_hp_wali')) $table->dropColumn('nomor_hp_wali');
            if (Schema::hasColumn('users', 'hubungan_wali')) $table->dropColumn('hubungan_wali');
            if (Schema::hasColumn('users', 'nama_wali')) $table->dropColumn('nama_wali');
            if (Schema::hasColumn('users', 'nama_ibu')) $table->dropColumn('nama_ibu');
            if (Schema::hasColumn('users', 'nama_ayah')) $table->dropColumn('nama_ayah');
            if (Schema::hasColumn('users', 'alamat')) $table->dropColumn('alamat');
            if (Schema::hasColumn('users', 'nomor_hp')) $table->dropColumn('nomor_hp');
            if (Schema::hasColumn('users', 'umur')) $table->dropColumn('umur');
            if (Schema::hasColumn('users', 'absen')) $table->dropColumn('absen');
            if (Schema::hasColumn('users', 'jurusan_id')) {
                $table->dropForeign(['jurusan_id']);
                $table->dropColumn('jurusan_id');
            }
            if (Schema::hasColumn('users', 'kelas_id')) {
                $table->dropForeign(['kelas_id']);
                $table->dropColumn('kelas_id');
            }
            if (Schema::hasColumn('users', 'nisn')) $table->dropColumn('nisn');
        });
    }
};
