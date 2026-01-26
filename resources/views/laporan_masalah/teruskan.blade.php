@extends('layouts.dashboard')

@section('title', 'Teruskan Laporan ke Admin')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/laporan_masalah">Laporan Masalah</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Teruskan ke Admin</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Teruskan Laporan ke Admin</h2>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Informasi Laporan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>Siswa:</strong></label>
                            <p>{{ $laporan->siswa->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Kelas:</strong></label>
                            <p>{{ $laporan->kelas->nama_kelas }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>Tanggal Kejadian:</strong></label>
                            <p>{{ $laporan->tanggal_kejadian->format('d-m-Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Mata Pelajaran:</strong></label>
                            <p>{{ $laporan->mata_pelajaran }} (Jam {{ $laporan->jam_pelajaran }})</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label><strong>Guru Mata Pelajaran:</strong></label>
                        <p>{{ $laporan->guruMapel->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label><strong>Deskripsi Masalah:</strong></label>
                        <div class="p-3 border rounded bg-light">
                            {{ $laporan->deskripsi_masalah }}
                        </div>
                    </div>

                    @if($laporan->catatan_wali_kelas)
                        <div class="mb-3">
                            <label><strong>Catatan Wali Kelas Sebelumnya:</strong></label>
                            <div class="p-3 border rounded bg-light">
                                {{ $laporan->catatan_wali_kelas }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <form method="POST" action="{{ route('laporan_masalah.store_teruskan', $laporan->id) }}">
                @csrf

                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Catatan untuk Admin</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Catatan / Rekomendasi (Opsional)</label>
                            <textarea name="catatan_wali_kelas" class="form-control" rows="4" 
                                     placeholder="Berikan catatan atau rekomendasi untuk admin mengenai penanganan masalah ini..."></textarea>
                            <small class="form-text text-muted">Maksimal 500 karakter</small>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning mb-4">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Perhatian:</strong> Laporan ini akan diteruskan kepada admin dan akan ditandai sebagai "Diteruskan ke Admin".
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Teruskan ke Admin</button>
                    <a href="{{ route('laporan_masalah.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
