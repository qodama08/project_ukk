<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hapus role guru_bk dari user_roles terlebih dahulu
        $guru_bk_role = DB::table('roles')->where('nama_role', 'guru_bk')->first();
        
        if ($guru_bk_role) {
            DB::table('user_roles')->where('role_id', $guru_bk_role->id)->delete();
            DB::table('roles')->where('id', $guru_bk_role->id)->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // tidak perlu direversi
    }
};
