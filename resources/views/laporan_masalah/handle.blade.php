@extends('layouts.dashboard')

@section('title', 'Tangani Laporan Masalah')

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
                        <li class="breadcrumb-item active" aria-current="page">Tangani Laporan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Tangani Laporan Masalah</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
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
                            <label><strong>Catatan dari Wali Kelas:</strong></label>
                            <div class="p-3 border rounded bg-light">
                                {{ $laporan->catatan_wali_kelas }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Status Laporan</h5>
                </div>
                <div class="card-body">
                    @php
                        $statusClass = 'bg-secondary';
                        $statusLabel = $laporan->status;
                        
                        if ($laporan->status === 'diteruskan_admin') {
                            $statusClass = 'bg-primary';
                            $statusLabel = 'Diteruskan ke Admin';
                        } elseif ($laporan->status === 'ditanggani') {
                            $statusClass = 'bg-warning text-dark';
                            $statusLabel = 'Sedang Ditanggani';
                        }
                    @endphp
                    <p><span class="badge {{ $statusClass }}" style="font-size: 14px; padding: 8px;">{{ $statusLabel }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5>Catatan Admin</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('laporan_masalah.store_handle', $laporan->id) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Catatan / Tindakan Admin <span class="text-danger">*</span></label>
                    <textarea name="catatan_admin" class="form-control @error('catatan_admin') is-invalid @enderror" 
                              rows="6" placeholder="Jelaskan tindakan yang Anda ambil untuk menangani masalah ini..." required>{{ old('catatan_admin') }}</textarea>
                    <small class="form-text text-muted">Minimal 10 karakter, maksimal 1000 karakter</small>
                    @error('catatan_admin')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Penyelesaian <span class="text-danger">*</span></label>
                    <select name="tindakan" class="form-control @error('tindakan') is-invalid @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="ditanggani">Sedang Ditanggani (Belum Selesai)</option>
                        <option value="selesai">Selesai (Masalah Sudah Ditangani)</option>
                    </select>
                    @error('tindakan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Info:</strong> Jika Anda memilih "Sedang Ditanggani", laporan dapat diubah lagi di kemudian hari. 
                    Jika "Selesai", laporan akan ditandai sebagai selesai dan tidak dapat diubah.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan Tindakan</button>
                    <a href="{{ route('laporan_masalah.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
