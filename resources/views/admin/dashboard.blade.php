@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')

<div class="row">

    <!-- CARD: Total Siswa -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Total Siswa</h5>
                <p class="card-text fs-3 fw-bold">120</p>
                <a href="#" class="btn btn-primary btn-sm">Lihat Data</a>
            </div>
        </div>
    </div>

    <!-- CARD: Total Guru BK -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Guru BK</h5>
                <p class="card-text fs-3 fw-bold">5</p>
                <a href="#" class="btn btn-primary btn-sm">Kelola Guru BK</a>
            </div>
        </div>
    </div>

    <!-- CARD: Jadwal Konseling -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Jadwal Konseling</h5>
                <p class="card-text fs-3 fw-bold">8 Jadwal</p>
                <a href="#" class="btn btn-primary btn-sm">Lihat Jadwal</a>
            </div>
        </div>
    </div>

</div>

<hr>

<!-- MENU FITUR ADMIN -->
<div class="row mt-4">

    <h4 class="mb-3">Fitur Admin</h4>

    <!-- Data Siswa -->
    <div class="col-md-3">
        <a href="#" class="text-decoration-none">
            <div class="card p-3 text-center shadow-sm">
                <i class="ti ti-users fs-1 mb-2"></i>
                <h6>Kelola Data Siswa</h6>
            </div>
        </a>
    </div>

    <!-- Guru BK -->
    <div class="col-md-3">
        <a href="#" class="text-decoration-none">
            <div class="card p-3 text-center shadow-sm">
                <i class="ti ti-user-heart fs-1 mb-2"></i>
                <h6>Kelola Guru BK</h6>
            </div>
        </a>
    </div>

    <!-- Konseling Individu -->
    <div class="col-md-3">
        <a href="#" class="text-decoration-none">
            <div class="card p-3 text-center shadow-sm">
                <i class="ti ti-user-check fs-1 mb-2"></i>
                <h6>Konseling Individu</h6>
            </div>
        </a>
    </div>

    <!-- Konseling Kelompok -->
    <div class="col-md-3">
        <a href="#" class="text-decoration-none">
            <div class="card p-3 text-center shadow-sm">
                <i class="ti ti-users-group fs-1 mb-2"></i>
                <h6>Konseling Kelompok</h6>
            </div>
        </a>
    </div>

</div>

<div class="row mt-4">

    <!-- Laporan -->
    <div class="col-md-3">
        <a href="/admin/laporan" class="text-decoration-none">
            <div class="card p-3 text-center shadow-sm">
                <i class="ti ti-report fs-1 mb-2"></i>
                <h6>Laporan Konseling</h6>
            </div>
        </a>
    </div>

    <!-- Pengumuman -->
    <div class="col-md-3">
        <a href="/admin/pengumuman" class="text-decoration-none">
            <div class="card p-3 text-center shadow-sm">
                <i class="ti ti-megaphone fs-1 mb-2"></i>
                <h6>Pengumuman</h6>
            </div>
        </a>
    </div>

    <!-- Manajemen User -->
    <div class="col-md-3">
        <a href="#" class="text-decoration-none">
            <div class="card p-3 text-center shadow-sm">
                <i class="ti ti-lock fs-1 mb-2"></i>
                <h6>Manajemen User & Role</h6>
            </div>
        </a>
    </div>

</div>

@endsection
