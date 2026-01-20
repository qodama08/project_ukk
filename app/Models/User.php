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

protected static function boot()
{
parent::boot();

// Automatically delete related data when user is deleted
static::deleting(function ($user) {
// Delete jadwal konseling records where user is siswa or guru_bk
$user->jadwalKonselingAsSiswa()->delete();
$user->jadwalKonselingAsGuruBK()->delete();

// Delete catatan konseling records
$user->catatanKonselingAsSiswa()->delete();
$user->catatanKonselingAsGuruBK()->delete();

// Delete prestasi records
$user->prestasi()->delete();

// Delete pelanggaran records if user_id exists
if ($user->pelanggaran) {
$user->pelanggaran()->delete();
}

// Delete notifikasi records if any
if ($user->notifikasi) {
$user->notifikasi()->delete();
}

// If user is wali_kelas, set to null in kelas table
Kelas::where('wali_kelas_id', $user->id)->update(['wali_kelas_id' => null]);
});
}

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

public function jadwalKonselingAsSiswa()
{
return $this->hasMany(JadwalKonseling::class, 'siswa_id');
}

public function jadwalKonselingAsGuruBK()
{
return $this->hasMany(JadwalKonseling::class, 'guru_bk_id');
}

public function catatanKonselingAsSiswa()
{
return $this->hasMany(CatatanKonseling::class, 'siswa_id');
}

public function catatanKonselingAsGuruBK()
{
return $this->hasMany(CatatanKonseling::class, 'guru_bk_id');
}

public function pelanggaranLogs()
{
return $this->hasMany(LogPelanggaran::class, 'siswa_id');
}

public function prestasi()
{
return $this->hasMany(Prestasi::class, 'siswa_id');
}

public function pelanggaran()
{
return $this->hasMany(Pelanggaran::class, 'user_id');
}

public function notifikasi()
{
return $this->hasMany(Notifikasi::class, 'user_id');
}
}