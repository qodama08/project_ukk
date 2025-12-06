@extends('layouts.app')

@section('content')
<h1>{{ isset($item) ? 'Edit' : 'Buat' }} Pelanggaran</h1>

<form method="POST" action="{{ isset($item) ? url('/pelanggaran/'.$item->id) : url('/pelanggaran') }}">
  @csrf
  @if(isset($item)) @method('PUT') @endif


  <div class="mb-3">
    <label class="form-label">Nama Siswa (manual)</label>
    <input name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa', $item->nama_siswa ?? '') }}" placeholder="Contoh: Budi Santoso">
    @error('nama_siswa')<span class="invalid-feedback">{{ $message }}</span>@enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Kelas (manual)</label>
    <input name="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas', $item->kelas ?? '') }}" placeholder="Contoh: 10 A">
    @error('kelas')<span class="invalid-feedback">{{ $message }}</span>@enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Absen (manual)</label>
    <input name="absen" class="form-control @error('absen') is-invalid @enderror" value="{{ old('absen', $item->absen ?? '') }}" placeholder="Contoh: 01">
    @error('absen')<span class="invalid-feedback">{{ $message }}</span>@enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Nama Pelanggaran</label>
    <input name="nama_pelanggaran" class="form-control @error('nama_pelanggaran') is-invalid @enderror" value="{{ old('nama_pelanggaran', $item->nama_pelanggaran ?? '') }}" required>
    @error('nama_pelanggaran')<span class="invalid-feedback">{{ $message }}</span>@enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Poin</label>
    <input name="poin" type="number" class="form-control @error('poin') is-invalid @enderror" value="{{ old('poin', $item->poin ?? 0) }}" required>
    @error('poin')<span class="invalid-feedback">{{ $message }}</span>@enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Tingkat Warna</label>
    <select name="tingkat_warna" class="form-control @error('tingkat_warna') is-invalid @enderror">
      <option value="">-</option>
      <option value="hijau" {{ (old('tingkat_warna', $item->tingkat_warna ?? '')=='hijau')?'selected':'' }}>Hijau</option>
      <option value="kuning" {{ (old('tingkat_warna', $item->tingkat_warna ?? '')=='kuning')?'selected':'' }}>Kuning</option>
      <option value="merah" {{ (old('tingkat_warna', $item->tingkat_warna ?? '')=='merah')?'selected':'' }}>Merah</option>
    </select>
    @error('tingkat_warna')<span class="invalid-feedback">{{ $message }}</span>@enderror
  </div>

  <button type="submit" class="btn btn-primary">Simpan</button>
  <a href="/pelanggaran" class="btn btn-secondary">Batal</a>
</form>

@endsection
