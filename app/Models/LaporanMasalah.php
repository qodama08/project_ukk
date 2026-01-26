<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMasalah extends Model
{
    use HasFactory;

    protected $table = 'laporan_masalah';

    protected $fillable = [
        'siswa_id',
        'guru_mapel_id',
        'guru_wali_kelas_id',
        'admin_id',
        'kelas_id',
        'tanggal_kejadian',
        'jam_pelajaran',
        'mata_pelajaran',
        'deskripsi_masalah',
        'tindakan_guru',
        'status',
        'catatan_wali_kelas',
        'catatan_admin',
        'diterima_wali_at',
        'diteruskan_admin_at',
        'ditanggani_admin_at',
        'selesai_at',
    ];

    protected $casts = [
        'tanggal_kejadian' => 'date',
        'diterima_wali_at' => 'datetime',
        'diteruskan_admin_at' => 'datetime',
        'ditanggani_admin_at' => 'datetime',
        'selesai_at' => 'datetime',
    ];

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function guruMapel()
    {
        return $this->belongsTo(User::class, 'guru_mapel_id');
    }

    public function guruWaliKelas()
    {
        return $this->belongsTo(User::class, 'guru_wali_kelas_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeForGuruMapel($query, $guruMapelId)
    {
        return $query->where('guru_mapel_id', $guruMapelId);
    }

    public function scopeForGuruWaliKelas($query, $guruWaliId)
    {
        return $query->where('guru_wali_kelas_id', $guruWaliId);
    }

    public function scopeForAdmin($query)
    {
        return $query->whereIn('status', ['diteruskan_admin', 'ditanggani']);
    }

    // Status checking methods
    public function isBaru()
    {
        return $this->status === 'baru';
    }

    public function isDiterimaWali()
    {
        return $this->status === 'diterima_wali';
    }

    public function isDiteruskanAdmin()
    {
        return $this->status === 'diteruskan_admin';
    }

    public function isDitangani()
    {
        return $this->status === 'ditanggani';
    }

    public function isSelesai()
    {
        return $this->status === 'selesai';
    }

    // Status transitions
    public function markAsDiterimaWali()
    {
        $this->status = 'diterima_wali';
        $this->diterima_wali_at = now();
        return $this;
    }

    public function markAsDiteruskanAdmin()
    {
        $this->status = 'diteruskan_admin';
        $this->diteruskan_admin_at = now();
        return $this;
    }

    public function markAsDitangani()
    {
        $this->status = 'ditanggani';
        $this->ditanggani_admin_at = now();
        return $this;
    }

    public function markAsSelesai()
    {
        $this->status = 'selesai';
        $this->selesai_at = now();
        return $this;
    }
}
