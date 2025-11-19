<?php


namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
use HasFactory, Notifiable;


protected $fillable = [
'name', 'email', 'password','role'
];


protected $hidden = [
'password', 'remember_token'
];


public function roles()
{
return $this->belongsToMany(Role::class, 'user_roles');
}


public function waliKelas()
{
return $this->hasOne(Kelas::class, 'wali_kelas_id');
}
}