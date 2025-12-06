<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\User;

echo "Users with role field 'admin':\n";
$u1 = User::where('role','admin')->get();
foreach($u1 as $u){ echo "- {$u->id}: {$u->name} ({$u->email})\n"; }

echo "\nUsers with pivot role 'admin' (user_roles->roles.nama_role='admin'):\n";
$u2 = User::whereHas('roles', function($q){ $q->where('nama_role','admin'); })->get();
foreach($u2 as $u){ echo "- {$u->id}: {$u->name} ({$u->email})\n"; }

if ($u1->isEmpty() && $u2->isEmpty()) {
    echo "\nNo admin users found.\n";
}
