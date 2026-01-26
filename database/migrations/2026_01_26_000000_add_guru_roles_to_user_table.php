<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Change enum to include guru_mapel, guru_wali_kelas, and siswa
            $table->enum('role', ['user', 'admin', 'guru_mapel', 'guru_wali_kelas', 'siswa'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert back to original enum
            $table->enum('role', ['user', 'admin'])->change();
        });
    }
};
