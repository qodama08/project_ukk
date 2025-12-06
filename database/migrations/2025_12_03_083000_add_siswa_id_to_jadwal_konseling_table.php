<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('jadwal_konseling')) return;

        Schema::table('jadwal_konseling', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwal_konseling', 'siswa_id')) {
                // add siswa_id referencing users table (students stored in users)
                $table->foreignId('siswa_id')->nullable()->constrained('users')->nullOnDelete()->after('id');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('jadwal_konseling')) return;

        Schema::table('jadwal_konseling', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal_konseling', 'siswa_id')) {
                $table->dropForeign(['siswa_id']);
                $table->dropColumn('siswa_id');
            }
        });
    }
};
