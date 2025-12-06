<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
public function up(): void
{
Schema::create('jadwal_konseling', function (Blueprint $table) {
$table->id();
$table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
$table->foreignId('guru_bk_id')->constrained('users')->cascadeOnDelete();
$table->date('tanggal');
$table->time('jam');
$table->enum('jenis', ['individu','kelompok'])->default('individu');
$table->string('tempat')->nullable();
$table->enum('status', ['terjadwal','selesai','batal'])->default('terjadwal');
$table->timestamps();
});
}


public function down(): void
{
Schema::dropIfExists('jadwal_konseling');
}
};