<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
public function up(): void
{
Schema::create('catatan_konseling', function (Blueprint $table) {
$table->id();
$table->foreignId('jadwal_id')->constrained('jadwal_konseling')->cascadeOnDelete();
$table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
$table->foreignId('guru_bk_id')->constrained('users')->cascadeOnDelete();
$table->text('hasil')->nullable();
$table->text('tindak_lanjut')->nullable();
$table->text('evaluasi')->nullable();
$table->timestamp('created_at')->useCurrent();
});
}


public function down(): void
{
Schema::dropIfExists('catatan_konseling');
}
};