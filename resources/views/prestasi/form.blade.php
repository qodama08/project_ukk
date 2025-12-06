@extends('layouts.app')

@section('content')
<h1>{{ isset($prestasi) ? 'Edit' : 'Catat' }} Prestasi</h1>

<form method="POST" action="{{ isset($prestasi) ? url('/prestasi/'.$prestasi->id) : url('/prestasi') }}">
  @csrf
  @if(isset($prestasi)) @method('PUT') @endif

  <div class="mb-3">
    <label class="form-label">Nama Siswa</label>
    <input name="nama_siswa" type="text" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa', $prestasi->nama_siswa ?? '') }}" placeholder="Ketik nama siswa secara manual">
    @error('nama_siswa')<span class="invalid-feedback">{{ $message }}</span>@enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Kelas</label>
    <input name="kelas" type="text" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas', $prestasi->kelas ?? '') }}">
    @error('kelas')<span class="invalid-feedback">{{ $message }}</span>@enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Absen</label>
    <input name="absen" type="text" class="form-control @error('absen') is-invalid @enderror" value="{{ old('absen', $prestasi->absen ?? '') }}">
    @error('absen')<span class="invalid-feedback">{{ $message }}</span>@enderror
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

  <button type="submit" class="btn btn-primary">Simpan</button>
  <a href="/prestasi" class="btn btn-secondary">Batal</a>
</form>

@endsection
