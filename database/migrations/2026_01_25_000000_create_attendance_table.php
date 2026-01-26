<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete(); // Guru mata pelajaran
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete();
            $table->date('tanggal');
            $table->string('jam_pelajaran')->nullable(); // e.g., "Jam 1", "Jam 2"
            $table->string('mata_pelajaran')->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa'])->default('hadir'); // hadir, izin, sakit, alfa (tidak masuk tanpa alasan)
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            // Index untuk query yang sering dilakukan
            $table->index(['siswa_id', 'tanggal']);
            $table->index(['guru_id', 'tanggal']);
            $table->index(['kelas_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
