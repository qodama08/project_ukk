<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRole = Role::where('nama_role', 'user')->first();
        $siswaRole = Role::where('nama_role', 'siswa')->first();
        $kelases = Kelas::all();

        $firstNames = ['Ahmad', 'Budi', 'Citra', 'Dani', 'Eka', 'Fitra', 'Gita', 'Hadi', 'Ina', 'Joko', 'Kris', 'Lila', 'Mira', 'Nina', 'Oscar'];
        $lastNames = ['Pratama', 'Wijaya', 'Santoso', 'Rahman', 'Hidayat', 'Suryanto', 'Kusuma', 'Mulyanto', 'Setiawan', 'Gunawan'];

        $absenCounter = [];
        $emailTracker = [];

        foreach ($kelases as $kelas) {
            $absenCounter[$kelas->id] = 1;

            // Create 5 students per class
            for ($i = 1; $i <= 5; $i++) {
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                $name = $firstName . ' ' . $lastName;
                
                $absen = $absenCounter[$kelas->id]++;
                
                // Generate unique email using timestamp and counter
                $email = strtolower(str_replace(' ', '.', $name)) . '.' . $kelas->id . '.' . $i . '@student.com';

                $student = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'kelas_id' => $kelas->id,
                    'jurusan_id' => $kelas->jurusan_id,
                    'absen' => $absen,
                    'umur' => rand(15, 18),
                    'nomor_hp' => '0812' . str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT),
                    'alamat' => 'Jl. ' . $firstName . ' No. ' . rand(1, 999),
                    'nama_ayah' => 'Ayah ' . $firstName,
                    'nama_ibu' => 'Ibu ' . $firstName,
                    'nama_wali' => null,
                    'hubungan_wali' => null,
                    'nomor_hp_wali' => null,
                ]);

                // Attach user and siswa roles
                if ($userRole) {
                    $student->roles()->attach($userRole->id);
                }
                if ($siswaRole) {
                    $student->roles()->attach($siswaRole->id);
                }
            }
        }
    }
}
