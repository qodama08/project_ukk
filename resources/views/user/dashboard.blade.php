
@php
try {
    $totalSiswa = class_exists('\App\Models\User') ? \App\Models\User::whereNotNull('nisn')->count() : 0;
    $totalGuruBK = 0;
    if (class_exists('\App\Models\User') && method_exists(\App\Models\User::class, 'roles')) {
        $totalGuruBK = \App\Models\User::whereHas('roles', function($q){ $q->where('nama_role','guru_bk'); })->count();
    }
    $totalJadwal = class_exists('\App\Models\JadwalKonseling') ? \App\Models\JadwalKonseling::count() : 0;
    $totalPrestasi = class_exists('\App\Models\Prestasi') ? \App\Models\Prestasi::count() : 0;
} catch (\Throwable $e) {
    $totalSiswa = $totalGuruBK = $totalJadwal = $totalPelanggaran = 0;
}
@endphp

<div class="row">
    <div class="col-md-3">
        <div class="card border-left-primary shadow-sm">
            <div class="card-body">
                <h6 class="card-title mb-0">Total Siswa</h6>
                <div class="h3 mb-0 font-weight-bold text-primary">{{ $totalSiswa }}</div>
            </div>
            <a href="{{ url('/siswa') }}" class="card-footer bg-white">
                <span class="small">Lihat Data →</span>
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-success shadow-sm">
            <div class="card-body">
                <h6 class="card-title mb-0">Guru BK</h6>
                <div class="h3 mb-0 font-weight-bold text-success">{{ $totalGuruBK }}</div>
            </div>
            <a href="{{ url('/users') }}" class="card-footer bg-white">
                <span class="small">Kelola →</span>
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-info shadow-sm">
            <div class="card-body">
                <h6 class="card-title mb-0">Jadwal Konseling</h6>
                <div class="h3 mb-0 font-weight-bold text-info">{{ $totalJadwal }}</div>
            </div>
            <a href="{{ url('/jadwal_konseling') }}" class="card-footer bg-white">
                <span class="small">Lihat →</span>
            </a>
        </div>
    </div>

    <div class="col-md-3">
            <div class="card border-left-warning shadow-sm">
            <div class="card-body">
                <h6 class="card-title mb-0">Prestasi</h6>
                <div class="h3 mb-0 font-weight-bold text-warning">{{ $totalPrestasi }}</div>
            </div>
            <a href="{{ url('/prestasi') }}" class="card-footer bg-white">
                <span class="small">Lihat →</span>
            </a>
        </div>
    </div>
</div>

<hr class="my-4">

<div class="row">
    <h6 class="mb-3"><strong>Kelola Fitur BK</strong></h6>

    <div class="col-md-3 mb-3">
        <a href="{{ url('/pelanggaran') }}" class="text-decoration-none">
            <div class="card h-100 shadow-sm hover">
                <div class="card-body text-center">
                    <div class="mb-2"><i class="fas fa-ban fa-2x text-danger"></i></div>
                    <h6 class="card-title">Pelanggaran</h6>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3 mb-3">
        <a href="{{ url('/prestasi') }}" class="text-decoration-none">
            <div class="card h-100 shadow-sm hover">
                <div class="card-body text-center">
                    <div class="mb-2"><i class="fas fa-trophy fa-2x text-warning"></i></div>
                    <h6 class="card-title">Prestasi</h6>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3 mb-3">
        <a href="{{ url('/jadwal_konseling') }}" class="text-decoration-none">
            <div class="card h-100 shadow-sm hover">
                <div class="card-body text-center">
                    <div class="mb-2"><i class="fas fa-calendar fa-2x text-info"></i></div>
                    <h6 class="card-title">Jadwal Konseling</h6>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3 mb-3">
        <a href="{{ url('/catatan_konseling') }}" class="text-decoration-none">
            <div class="card h-100 shadow-sm hover">
                <div class="card-body text-center">
                    <div class="mb-2"><i class="fas fa-notes-medical fa-2x text-success"></i></div>
                    <h6 class="card-title">Catatan Konseling</h6>
                </div>
            </div>
        </a>
    </div>
</div>

<style>
    .border-left-primary {
        border-left: 4px solid #007bff !important;
    }
    .border-left-success {
        border-left: 4px solid #28a745 !important;
    }
    .border-left-info {
        border-left: 4px solid #17a2b8 !important;
    }
    .border-left-warning {
        border-left: 4px solid #ffc107 !important;
    }
    .card.hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
        transition: all 0.3s ease;
    }
</style>
