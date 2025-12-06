<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class GuruBkSeeder extends Seeder
{
    public function run()
    {
        // Ensure role exists
        $role = Role::firstOrCreate([
            'nama_role' => 'guru_bk'
        ], [
            'deskripsi' => 'Guru Bimbingan Konseling',
            'is_multi' => 0
        ]);

        $gurus = [
            ['name' => 'Siti', 'email' => 'siti@example.test'],
            ['name' => 'Ani', 'email' => 'ani@example.test'],
            ['name' => 'Dewi', 'email' => 'dewi@example.test']
        ];

        foreach ($gurus as $g) {
            $user = User::where('email', $g['email'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $g['name'],
                    'email' => $g['email'],
                    'password' => bcrypt('secret123'),
                    'role' => 'admin', // keep role field but access control is via roles table
                ]);
            }

            // attach role via pivot
            if (!$user->roles()->where('role_id', $role->id)->exists()) {
                $user->roles()->attach($role->id);
            }
        }
    }
}
