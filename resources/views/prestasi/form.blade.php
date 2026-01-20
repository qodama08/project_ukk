@extends('layouts.dashboard')

@section('title', isset($prestasi) ? 'Edit Prestasi' : 'Catat Prestasi')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/prestasi">Data Prestasi</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($prestasi) ? 'Edit' : 'Catat' }} Prestasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-4">{{ isset($prestasi) ? 'Edit' : 'Catat' }} Prestasi</h2>
    <form method="POST" action="{{ isset($prestasi) ? url('/prestasi/'.$prestasi->id) : url('/prestasi') }}" enctype="multipart/form-data">
      @csrf
      @if(isset($prestasi)) @method('PUT') @endif
      <div class="mb-3">
        <label class="form-label">Siswa (Nama | Kelas | Absen)</label>
        <select name="siswa_id" id="siswa_id" class="form-control @error('siswa_id') is-invalid @enderror" required>
            <option value="">-- Pilih Siswa --</option>
            @foreach($siswa as $s)
                <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                    {{ $s->name }} | {{ $s->kelas->nama_kelas ?? '-' }} | {{ $s->absen ?? '-' }}
                </option>
            @endforeach
        </select>
        @error('siswa_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Prestasi</label>
        <input name="nama_prestasi" type="text" class="form-control @error('nama_prestasi') is-invalid @enderror" value="{{ old('nama_prestasi', $prestasi->nama_prestasi ?? '') }}" required>
        @error('nama_prestasi')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Keterangan</label>
        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $prestasi->deskripsi ?? '') }}</textarea>
        @error('keterangan')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Gambar Prestasi</label>
        <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
        <small class="text-muted">Format: JPG, PNG, GIF, WebP, BMP, SVG, TIFF, ICO (Max 5MB)</small>
        @error('gambar')<span class="invalid-feedback">{{ $message }}</span>@enderror
        @if(isset($prestasi) && $prestasi->gambar)
          <div class="mt-2">
            <p class="text-muted">Gambar saat ini:</p>
            <img src="{{ asset('storage/' . $prestasi->gambar) }}" alt="Prestasi" style="max-width: 200px; max-height: 200px;">
          </div>
        @endif
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="/prestasi" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
