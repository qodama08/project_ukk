<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
public function up(): void
{
Schema::create('prestasi', function (Blueprint $table) {
$table->id();
$table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
$table->string('nama_prestasi');
$table->enum('tingkat', ['sekolah','kota','provinsi','nasional','internasional'])->nullable();
$table->enum('kategori', ['akademik','non-akademik'])->nullable();
$table->date('tanggal')->nullable();
$table->text('deskripsi')->nullable();
$table->timestamps();
});
}


public function down(): void
{
Schema::dropIfExists('prestasi');
}
};