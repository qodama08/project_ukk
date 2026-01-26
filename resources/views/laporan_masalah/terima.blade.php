@extends('layouts.dashboard')

@section('title', 'Terima Laporan Masalah')

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
                        <li class="breadcrumb-item active" aria-current="page">Terima Laporan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Terima Laporan Masalah</h2>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5>Informasi Laporan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>Siswa:</strong></label>
                            <p>{{ $laporan->siswa->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Tanggal Kejadian:</strong></label>
                            <p>{{ $laporan->tanggal_kejadian->format('d-m-Y') }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label><strong>Mata Pelajaran:</strong></label>
                        <p>{{ $laporan->mata_pelajaran }} (Jam {{ $laporan->jam_pelajaran }})</p>
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

                    @if($laporan->tindakan_guru)
                        <div class="mb-3">
                            <label><strong>Tindakan Guru:</strong></label>
                            <div class="p-3 border rounded bg-light">
                                {{ $laporan->tindakan_guru }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <form method="POST" action="{{ route('laporan_masalah.store_terima', $laporan->id) }}">
                @csrf

                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Catatan Wali Kelas</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea name="catatan_wali_kelas" class="form-control" rows="4" 
                                     placeholder="Tambahkan catatan atau tindakan lanjutan yang akan Anda ambil..."></textarea>
                            <small class="form-text text-muted">Maksimal 500 karakter</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Terima Laporan</button>
                    <a href="{{ route('laporan_masalah.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
