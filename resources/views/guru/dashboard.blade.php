@php
try {
    $user = auth()->user();
    $totalJadwalSaya = class_exists('\App\Models\JadwalKonseling') ? \App\Models\JadwalKonseling::where('guru_bk_id', $user->id)->count() : 0;
    $totalCatatanSaya = class_exists('\App\Models\CatatanKonseling') ? \App\Models\CatatanKonseling::where('guru_bk_id', $user->id)->count() : 0;
    $totalSiswa = class_exists('\App\Models\User') ? \App\Models\User::whereNotNull('nisn')->count() : 0;
} catch (\Throwable $e) {
    $totalJadwalSaya = $totalCatatanSaya = $totalSiswa = 0;
}
@endphp

<div class="row">
    <div class="col-md-3">
        <div class="card border-left-primary shadow-sm">
            <div class="card-body">
                <h6 class="card-title mb-0">Jadwal Saya</h6>
                <div class="h3 mb-0 font-weight-bold text-primary">{{ $totalJadwalSaya }}</div>
            </div>
            <a href="{{ url('/jadwal_konseling') }}" class="card-footer bg-white">
                <span class="small">Lihat →</span>
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-success shadow-sm">
            <div class="card-body">
                <h6 class="card-title mb-0">Catatan Konseling</h6>
                <div class="h3 mb-0 font-weight-bold text-success">{{ $totalCatatanSaya }}</div>
            </div>
            <a href="{{ url('/catatan_konseling') }}" class="card-footer bg-white">
                <span class="small">Lihat →</span>
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-info shadow-sm">
            <div class="card-body">
                <h6 class="card-title mb-0">Total Siswa</h6>
                <div class="h3 mb-0 font-weight-bold text-info">{{ $totalSiswa }}</div>
            </div>
            <a href="{{ url('/siswa') }}" class="card-footer bg-white">
                <span class="small">Lihat →</span>
            </a>
        </div>
    </div>
</div>

<hr class="my-4">

<div class="row">
    <h6 class="mb-3"><strong>Fitur BK</strong></h6>

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

    <div class="col-md-3 mb-3">
        <a href="{{ url('/siswa') }}" class="text-decoration-none">
            <div class="card h-100 shadow-sm hover">
                <div class="card-body text-center">
                    <div class="mb-2"><i class="fas fa-users fa-2x text-primary"></i></div>
                    <h6 class="card-title">Data Siswa</h6>
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
    .card.hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
        transition: all 0.3s ease;
    }
</style>
