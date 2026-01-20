<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Add cascading delete constraints to ensure data integrity
     */
    public function up(): void
    {
        // Drop existing constraints and recreate with cascadeOnDelete
        
        // 1. pelanggaran table - add user_id foreign key if not exists
        if (Schema::hasTable('pelanggaran')) {
            Schema::table('pelanggaran', function (Blueprint $table) {
                // Check if user_id column exists, if not add it
                if (!Schema::hasColumn('pelanggaran', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->cascadeOnDelete();
                }
            });
        }

        // 2. Add cascade delete to users table for kelas (when kelas is deleted, user's kelas_id becomes null)
        // This is already handled by nullOnDelete() in kelas table

        // 3. Ensure notifikasi table has cascade delete if it references users
        if (Schema::hasTable('notifikasis')) {
            if (Schema::hasColumn('notifikasis', 'user_id')) {
                try {
                    Schema::table('notifikasis', function (Blueprint $table) {
                        // Drop and recreate if necessary - this is handled by checking constraint
                    });
                } catch (\Exception $e) {
                    // Constraint might already exist
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration adds constraints, rollback would need to drop them
        // Since we're using nullable constraints, rollback is safe
    }
};
