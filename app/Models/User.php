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
'nisn', 'name', 'email', 'password', 'role', 'kelas_id', 'jurusan_id', 'absen', 'umur', 'nomor_hp', 'alamat',
'nama_ayah', 'nama_ibu', 'nama_wali', 'hubungan_wali', 'nomor_hp_wali'
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

public function kelas()
{
return $this->belongsTo(Kelas::class, 'kelas_id');
}

public function jurusan()
{
return $this->belongsTo(Jurusan::class, 'jurusan_id');
}

public function pelanggaranLogs()
{
return $this->hasMany(LogPelanggaran::class, 'siswa_id');
}

public function prestasi()
{
return $this->hasMany(Prestasi::class, 'siswa_id');
}
}