<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Kelas;
use App\Models\Role;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create roles: admin, user, guru_mapel, guru_wali_kelas, siswa
        $roles = [
            ['nama_role' => 'admin', 'deskripsi' => 'Administrator', 'is_multi' => false],
            ['nama_role' => 'user', 'deskripsi' => 'Pengguna umum', 'is_multi' => false],
            ['nama_role' => 'guru_mapel', 'deskripsi' => 'Guru Mata Pelajaran', 'is_multi' => true],
            ['nama_role' => 'guru_wali_kelas', 'deskripsi' => 'Guru Wali Kelas', 'is_multi' => true],
            ['nama_role' => 'siswa', 'deskripsi' => 'Siswa', 'is_multi' => false],
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

        // Create wali kelas for each kelas
        $kelas_list = Kelas::all();
        $guruWaliKelasRole = Role::where('nama_role', 'guru_wali_kelas')->first();

        foreach ($kelas_list as $kelas) {
            // Create wali kelas user
            $waliKelasName = 'Wali Kelas ' . $kelas->nama_kelas;
            $waliKelasEmail = 'walikelas.' . strtolower(str_replace(' ', '.', $kelas->nama_kelas)) . '@gmail.com';

            $waliKelasUser = DB::table('users')->updateOrInsert(
                ['email' => $waliKelasEmail],
                [
                    'name' => $waliKelasName,
                    'password' => Hash::make('password123'),
                    'role' => 'guru_wali_kelas',
                    'kelas_id' => $kelas->id,  // Link to their class
                ]
            );

            // Fetch the user and attach role
            $user = DB::table('users')->where('email', $waliKelasEmail)->first();
            if ($user && $guruWaliKelasRole) {
                DB::table('user_roles')->updateOrInsert(
                    ['user_id' => $user->id, 'role_id' => $guruWaliKelasRole->id],
                    ['user_id' => $user->id, 'role_id' => $guruWaliKelasRole->id]
                );
            }

            // Update kelas to link to this wali kelas
            Kelas::where('id', $kelas->id)->update(['wali_kelas_id' => $user->id]);
        }

        // Create demo wali kelas accounts for easy testing
        $demoWaliKelas = [
            ['name' => 'Wali Kelas X TKR 1', 'email' => 'wali.x.tkr.1@demo.com', 'password' => 'password123'],
            ['name' => 'Wali Kelas XII RPL 1', 'email' => 'wali.xii.rpl.1@demo.com', 'password' => 'password123'],
            ['name' => 'Wali Kelas XI TPM 1', 'email' => 'wali.xi.tpm.1@demo.com', 'password' => 'password123'],
        ];

        foreach ($demoWaliKelas as $demo) {
            // Determine target kelas based on email
            $targetKelas = null;
            
            if (strpos($demo['email'], 'x.tkr') !== false) {
                $targetKelas = Kelas::where('nama_kelas', 'LIKE', 'X TKR%')->first();
            } elseif (strpos($demo['email'], 'xii.rpl') !== false) {
                $targetKelas = Kelas::where('nama_kelas', 'LIKE', 'XII RPL%')->first();
            } elseif (strpos($demo['email'], 'xi.tpm') !== false) {
                $targetKelas = Kelas::where('nama_kelas', 'LIKE', 'XI TPM%')->first();
            }

            if ($targetKelas) {
                $demoUser = DB::table('users')->updateOrInsert(
                    ['email' => $demo['email']],
                    [
                        'name' => $demo['name'],
                        'password' => Hash::make($demo['password']),
                        'role' => 'guru_wali_kelas',
                        'kelas_id' => $targetKelas->id,
                    ]
                );

                $demoUserRecord = DB::table('users')->where('email', $demo['email'])->first();
                if ($demoUserRecord && $guruWaliKelasRole) {
                    DB::table('user_roles')->updateOrInsert(
                        ['user_id' => $demoUserRecord->id, 'role_id' => $guruWaliKelasRole->id],
                        ['user_id' => $demoUserRecord->id, 'role_id' => $guruWaliKelasRole->id]
                    );
                }
            }
        }

        // Create demo guru mata pelajaran accounts for easy testing
        $demoGuruMapel = [
            ['name' => 'Guru Mapel Matematika', 'email' => 'guru.mapel.matematika@demo.com', 'password' => 'password123'],
            ['name' => 'Guru Mapel Bahasa Indonesia', 'email' => 'guru.mapel.indonesia@demo.com', 'password' => 'password123'],
            ['name' => 'Guru Mapel Bahasa Inggris', 'email' => 'guru.mapel.inggris@demo.com', 'password' => 'password123'],
        ];

        $guruMapelRole = Role::where('nama_role', 'guru_mapel')->first();

        foreach ($demoGuruMapel as $demo) {
            $guruMapelUser = DB::table('users')->updateOrInsert(
                ['email' => $demo['email']],
                [
                    'name' => $demo['name'],
                    'password' => Hash::make($demo['password']),
                    'role' => 'guru_mapel',
                ]
            );

            $guruMapelUserRecord = DB::table('users')->where('email', $demo['email'])->first();
            if ($guruMapelUserRecord && $guruMapelRole) {
                DB::table('user_roles')->updateOrInsert(
                    ['user_id' => $guruMapelUserRecord->id, 'role_id' => $guruMapelRole->id],
                    ['user_id' => $guruMapelUserRecord->id, 'role_id' => $guruMapelRole->id]
                );
            }
        }

        // Create demo siswa accounts for each kelas
        $siswaRole = Role::where('nama_role', 'siswa')->first();
        $demoSiswaNames = [
            'Dani Rahman',
            'Eka Rahman',
            'Gita Hidayat',
            'Hadi Setiawan',
            'Lila Kusuma',
        ];

        $kelasesToPopulate = Kelas::limit(3)->get(); // Get first 3 kelas

        foreach ($kelasesToPopulate as $kelas) {
            foreach ($demoSiswaNames as $index => $siswaName) {
                $siswaEmail = 'siswa.' . strtolower(str_replace(' ', '.', $siswaName)) . '.' . strtolower(str_replace(' ', '.', $kelas->nama_kelas)) . '@demo.com';
                $absenNumber = $index + 1;

                $siswaUser = DB::table('users')->updateOrInsert(
                    ['email' => $siswaEmail],
                    [
                        'name' => $siswaName,
                        'password' => Hash::make('password123'),
                        'role' => 'siswa',
                        'kelas_id' => $kelas->id,
                        'absen' => $absenNumber,
                    ]
                );

                $siswaUserRecord = DB::table('users')->where('email', $siswaEmail)->first();
                if ($siswaUserRecord && $siswaRole) {
                    DB::table('user_roles')->updateOrInsert(
                        ['user_id' => $siswaUserRecord->id, 'role_id' => $siswaRole->id],
                        ['user_id' => $siswaUserRecord->id, 'role_id' => $siswaRole->id]
                    );
                }
            }
        }
    }
}
