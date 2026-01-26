@extends('layouts.dashboard')

@section('title', 'Buat Laporan Masalah')

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
                        <li class="breadcrumb-item active" aria-current="page">Buat Laporan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Buat Laporan Masalah Siswa</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('laporan_masalah.store') }}">
        @csrf

        <div class="card mb-4">
            <div class="card-header">
                <h5>Informasi Laporan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Siswa <span class="text-danger">*</span></label>
                            <select name="siswa_id" class="form-control @error('siswa_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswa as $s)
                                    <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->name }} ({{ $s->kelas->nama_kelas ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('siswa_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Kejadian <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kejadian" class="form-control @error('tanggal_kejadian') is-invalid @enderror" 
                                   value="{{ old('tanggal_kejadian') }}" required>
                            @error('tanggal_kejadian')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jam Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" name="jam_pelajaran" class="form-control @error('jam_pelajaran') is-invalid @enderror" 
                                   placeholder="Contoh: Jam 1, Jam 2, dll" value="{{ old('jam_pelajaran') }}" required>
                            @error('jam_pelajaran')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" name="mata_pelajaran" class="form-control @error('mata_pelajaran') is-invalid @enderror" 
                                   value="{{ old('mata_pelajaran') }}" required>
                            @error('mata_pelajaran')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi Masalah <span class="text-danger">*</span></label>
                    <textarea name="deskripsi_masalah" class="form-control @error('deskripsi_masalah') is-invalid @enderror" 
                              rows="5" placeholder="Jelaskan masalah yang dialami siswa..." required>{{ old('deskripsi_masalah') }}</textarea>
                    <small class="form-text text-muted">Minimal 10 karakter, maksimal 1000 karakter</small>
                    @error('deskripsi_masalah')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Buat Laporan</button>
            <a href="{{ route('laporan_masalah.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
