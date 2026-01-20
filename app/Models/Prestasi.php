<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Prestasi extends Model
{
    use HasFactory;
    protected $table = 'prestasi';
    protected $fillable = ['nama_siswa','kelas','absen','nama_prestasi','deskripsi','siswa_id','tingkat','kategori','tanggal','gambar'];
    
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}