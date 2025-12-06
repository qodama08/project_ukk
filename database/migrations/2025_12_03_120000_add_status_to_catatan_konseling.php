<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('catatan_konseling')) {
            // add status enum: pending (menunggu) and setuju (disetujui)
            DB::statement("ALTER TABLE catatan_konseling ADD COLUMN status ENUM('pending','setuju') NOT NULL DEFAULT 'pending' AFTER evaluasi");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('catatan_konseling')) {
            DB::statement("ALTER TABLE catatan_konseling DROP COLUMN status");
        }
    }
};
