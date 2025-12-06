<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modify the status enum to include 'pending'
        if (Schema::hasTable('jadwal_konseling')) {
            DB::statement("ALTER TABLE jadwal_konseling MODIFY COLUMN status ENUM('pending','terjadwal','selesai','batal') DEFAULT 'pending'");
        }
    }

    public function down(): void
    {
        // Revert to the original enum
        if (Schema::hasTable('jadwal_konseling')) {
            DB::statement("ALTER TABLE jadwal_konseling MODIFY COLUMN status ENUM('terjadwal','selesai','batal') DEFAULT 'terjadwal'");
        }
    }
};
