<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create only two roles: admin and user
        $roles = [
            ['nama_role' => 'admin', 'deskripsi' => 'Administrator', 'is_multi' => false],
            ['nama_role' => 'user', 'deskripsi' => 'Pengguna umum', 'is_multi' => false],
        ];

        foreach ($roles as $r) {
            DB::table('roles')->updateOrInsert(
                ['nama_role' => $r['nama_role']],
                ['deskripsi' => $r['deskripsi'], 'is_multi' => $r['is_multi']]
            );
        }

        // Create sample admin and user and attach roles via pivot table
        $users = [
            ['name' => 'Admin Satu', 'email' => 'admin@gmail.com', 'password' => 'admin123', 'role' => 'admin'],
            ['name' => 'User Satu', 'email' => 'usersatu@gmail.com', 'password' => 'password123', 'role' => 'user'],
        ];

        foreach ($users as $u) {
            DB::table('users')->updateOrInsert(
                ['email' => $u['email']],
                ['name' => $u['name'], 'password' => Hash::make($u['password']), 'role' => $u['role']]
            );

            // Fetch real user id and attach role
            $user = DB::table('users')->where('email', $u['email'])->first();
            $role = DB::table('roles')->where('nama_role', $u['role'])->first();

            if ($user && $role) {
                DB::table('user_roles')->updateOrInsert(
                    ['user_id' => $user->id, 'role_id' => $role->id],
                    ['user_id' => $user->id, 'role_id' => $role->id]
                );
            }
        }
    }
}
