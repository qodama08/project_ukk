<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the old table if it exists
        Schema::dropIfExists('attendance');
        
        // Create new simplified attendance table
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('guru_wali_kelas_id')->constrained('users')->cascadeOnDelete(); // Guru wali kelas yang mencatat
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->date('tanggal'); // Hanya mencatat per hari
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa'])->default('hadir'); // hadir, izin, sakit, alfa
            $table->text('keterangan')->nullable(); // Catatan tambahan
            $table->timestamps();
            
            // Index untuk query yang sering dilakukan
            $table->unique(['siswa_id', 'tanggal']); // Satu siswa hanya boleh satu record per hari
            $table->index(['kelas_id', 'tanggal']);
            $table->index(['guru_wali_kelas_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
