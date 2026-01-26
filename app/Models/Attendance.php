<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'siswa_id',
        'guru_wali_kelas_id',
        'kelas_id',
        'tanggal',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function guruWaliKelas()
    {
        return $this->belongsTo(User::class, 'guru_wali_kelas_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Scopes
    public function scopeByDate($query, $tanggal)
    {
        return $query->where('tanggal', $tanggal);
    }

    public function scopeBySiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    public function scopeByGuru($query, $guruId)
    {
        return $query->where('guru_id', $guruId);
    }

    public function scopeByKelas($query, $kelasId)
    {
        return $query->where('kelas_id', $kelasId);
    }

    public function scopeByGuruWaliKelas($query, $guruWaliKelasId)
    {
        return $query->where('guru_wali_kelas_id', $guruWaliKelasId);
    }

    // Status helpers
    public function isHadir()
    {
        return $this->status === 'hadir';
    }

    public function isIzin()
    {
        return $this->status === 'izin';
    }

    public function isSakit()
    {
        return $this->status === 'sakit';
    }

    public function isAlfa()
    {
        return $this->status === 'alfa';
    }
}
