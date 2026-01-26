<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_masalah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('guru_mapel_id')->constrained('users')->cascadeOnDelete(); // Guru mata pelajaran
            $table->foreignId('guru_wali_kelas_id')->nullable()->constrained('users')->nullOnDelete(); // Guru wali kelas
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete(); // Admin
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete();
            
            // Laporan data
            $table->date('tanggal_kejadian');
            $table->string('jam_pelajaran'); // e.g., "Jam 1", "Jam 2"
            $table->string('mata_pelajaran');
            $table->text('deskripsi_masalah');
            $table->text('tindakan_guru')->nullable();
            
            // Status laporan
            $table->enum('status', ['baru', 'diterima_wali', 'diteruskan_admin', 'ditanggani', 'selesai'])->default('baru');
            // baru: baru dilaporkan guru mapel ke wali kelas
            // diterima_wali: wali kelas sudah menerima
            // diteruskan_admin: wali kelas teruskan ke admin
            // ditanggani: admin sedang menangani
            // selesai: sudah ditanggani
            
            // Catatan dari setiap level
            $table->text('catatan_wali_kelas')->nullable();
            $table->text('catatan_admin')->nullable();
            
            // Timestamp untuk tracking
            $table->timestamp('diterima_wali_at')->nullable();
            $table->timestamp('diteruskan_admin_at')->nullable();
            $table->timestamp('ditanggani_admin_at')->nullable();
            $table->timestamp('selesai_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['siswa_id']);
            $table->index(['guru_mapel_id']);
            $table->index(['guru_wali_kelas_id']);
            $table->index(['admin_id']);
            $table->index(['status']);
            $table->index(['kelas_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_masalah');
    }
};
