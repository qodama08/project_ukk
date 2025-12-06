<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class JadwalKonseling extends Model
{
use HasFactory;
protected $table = 'jadwal_konseling';
protected $fillable = ['siswa_id','nama_siswa','kelas','absen','guru_bk_id','tanggal','jam','tempat','status'];


public function siswa() { return $this->belongsTo(User::class,'siswa_id'); }
public function guru() { return $this->belongsTo(User::class,'guru_bk_id'); }
public function catatan() { return $this->hasOne(\App\Models\CatatanKonseling::class,'jadwal_id'); }
}