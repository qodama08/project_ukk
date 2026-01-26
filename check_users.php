<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';

use Illuminate\Support\Facades\DB;

$app->make(\Illuminate\Contracts\Http\Kernel::class);

// Get all users
$users = DB::table('users')->select('id', 'name', 'email', 'role', 'kelas_id')->get();

echo "Total Users: " . count($users) . "\n\n";

foreach ($users as $user) {
    $roles = DB::table('user_roles')
        ->join('roles', 'user_roles.role_id', '=', 'roles.id')
        ->where('user_roles.user_id', $user->id)
        ->pluck('nama_role')
        ->implode(', ');
    
    echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Role (enum): {$user->role} | Roles (pivot): {$roles} | Kelas ID: {$user->kelas_id}\n";
}
