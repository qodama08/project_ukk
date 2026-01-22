<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Pelanggaran extends Model
{
use HasFactory;
protected $table = 'pelanggaran';
protected $fillable = ['nama_pelanggaran','poin','tingkat_warna','opsi_pengawasan','siswa_id','user_id','nama_siswa','kelas','absen','notified_at'];
protected $casts = [
    'notified_at' => 'datetime',
];


public function siswa()
{
	return $this->belongsTo(User::class, 'siswa_id');
}

public function user()
{
return $this->belongsTo(User::class, 'user_id');
}

public function logs()
{
return $this->hasMany(LogPelanggaran::class, 'pelanggaran_id');
}

public static function getTotalPoinSiswa($siswaId)
{
    return self::where('siswa_id', $siswaId)->sum('poin');
}
}