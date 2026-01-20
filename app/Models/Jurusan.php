<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Jurusan extends Model
{
use HasFactory;
protected $table = 'jurusan';
protected $fillable = ['nama_jurusan'];

protected static function boot()
{
parent::boot();

// Automatically delete related data when jurusan is deleted
static::deleting(function ($jurusan) {
// Delete all kelas in this jurusan, which will cascade delete users
Kelas::where('jurusan_id', $jurusan->id)->delete();
});
}

public function siswa()
{
return $this->hasMany(Siswa::class, 'jurusan_id');
}
}