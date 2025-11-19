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

        // default role user
        DB::table('users')->updateOrInsert(
    ['email' => 'usersatu@gmail.com'],
    [
        'name' => 'User Satu',
        'password' => Hash::make('password123'),
        'role' => 'user'
    ]
);

DB::table('users')->updateOrInsert(
    ['email' => 'admin@gmail.com'],
    [
        'name' => 'Admin Satu',
        'password' => Hash::make('admin123'),
        'role' => 'admin'
    ]
);
    }
}
