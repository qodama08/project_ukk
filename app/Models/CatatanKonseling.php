<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class CatatanKonseling extends Model
{
use HasFactory;
protected $table = 'catatan_konseling';
const CREATED_AT = 'created_at';
const UPDATED_AT = null;
protected $fillable = ['jadwal_id','siswa_id','guru_bk_id','hasil','tindak_lanjut','evaluasi','status','created_at'];


public function jadwal() { return $this->belongsTo(JadwalKonseling::class,'jadwal_id'); }
public function siswa() { return $this->belongsTo(User::class,'siswa_id'); }
public function guru() { return $this->belongsTo(User::class,'guru_bk_id'); }
}