<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop existing foreign key, modify column to allow NULL, then recreate FK
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
        });

        // Modify column to be nullable
        DB::statement('ALTER TABLE prestasi MODIFY siswa_id BIGINT UNSIGNED NULL');

        // Re-add foreign key constraint
        Schema::table('prestasi', function (Blueprint $table) {
            $table->foreign('siswa_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Revert column to NOT NULL
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
        });

        DB::statement('ALTER TABLE prestasi MODIFY siswa_id BIGINT UNSIGNED NOT NULL');

        Schema::table('prestasi', function (Blueprint $table) {
            $table->foreign('siswa_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
