@extends('layouts.app')

@section('content')
<h1>{{ isset($jadwal) ? (request()->routeIs('jadwal_konseling.show') ? 'Detail' : 'Edit') : 'Buat' }} Jadwal Konseling</h1>

@php
  $isReadOnly = isset($jadwal) && request()->routeIs('jadwal_konseling.show');
  $isAdmin = auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->roles()->where('nama_role','admin')->exists());
  $showForm = !$isReadOnly || $isAdmin;
@endphp

@if($isReadOnly && !$isAdmin)
  <!-- Display-only mode for non-admin users viewing detail -->
  <div class="alert alert-info">Detail Jadwal Konseling</div>
  <div class="mb-3">
    <label class="form-label"><strong>Nama Siswa:</strong></label>
    <p>{{ $jadwal->nama_siswa ?? '-' }}</p>
  </div>
  <div class="mb-3">
    <label class="form-label"><strong>Kelas:</strong></label>
    <p>{{ $jadwal->kelas ?? '-' }}</p>
  </div>
  <div class="mb-3">
    <label class="form-label"><strong>Absen:</strong></label>
    <p>{{ $jadwal->absen ?? '-' }}</p>
  </div>
  <div class="mb-3">
    <label class="form-label"><strong>Tanggal:</strong></label>
    <p>{{ $jadwal->tanggal ?? '-' }}</p>
  </div>
  <div class="mb-3">
    <label class="form-label"><strong>Jam:</strong></label>
    <p>{{ $jadwal->jam ?? '-' }}</p>
  </div>
  <div class="mb-3">
    <label class="form-label"><strong>Guru BK:</strong></label>
    <p>{{ $jadwal->guru->name ?? '-' }}</p>
  </div>
  <div class="mb-3">
    <label class="form-label"><strong>Tempat:</strong></label>
    <p>{{ $jadwal->tempat ?? '-' }}</p>
  </div>
  <div class="mb-3">
    <label class="form-label"><strong>Status:</strong></label>
    <p><span class="badge bg-warning">{{ ucfirst($jadwal->status) }}</span></p>
  </div>
  <a href="{{ route('jadwal_konseling.index') }}" class="btn btn-secondary">Kembali</a>
@else
  <!-- Editable form for admin or create mode -->
  <form method="POST" action="{{ isset($jadwal) && !request()->routeIs('jadwal_konseling.show') ? url('/jadwal_konseling/'.$jadwal->id) : (isset($jadwal) && request()->routeIs('jadwal_konseling.show') && $isAdmin ? url('/jadwal_konseling/'.$jadwal->id) : url('/jadwal_konseling')) }}">
    @csrf
    @if(isset($jadwal)) @method('PUT') @endif

    <div class="mb-3">
      <label class="form-label">Nama Siswa (Manual)</label>
      <input name="nama_siswa" type="text" class="form-control" value="{{ old('nama_siswa', $jadwal->nama_siswa ?? '') }}" placeholder="Masukkan nama siswa" {{ $isReadOnly && !$isAdmin ? 'readonly' : '' }}>
    </div>

    <div class="mb-3">
      <label class="form-label">Kelas (Manual)</label>
      <input name="kelas" type="text" class="form-control" value="{{ old('kelas', $jadwal->kelas ?? '') }}" placeholder="Contoh: 10 A" {{ $isReadOnly && !$isAdmin ? 'readonly' : '' }}>
    </div>

    <div class="mb-3">
      <label class="form-label">Absen (Manual)</label>
      <input name="absen" type="text" class="form-control" value="{{ old('absen', $jadwal->absen ?? '') }}" placeholder="Contoh: 01" {{ $isReadOnly && !$isAdmin ? 'readonly' : '' }}>
    </div>

    <div class="mb-3">
      <label class="form-label">Tanggal</label>
      <input name="tanggal" type="date" class="form-control" value="{{ old('tanggal', $jadwal->tanggal ?? '') }}" {{ $isReadOnly && !$isAdmin ? 'readonly' : '' }}>
    </div>
    <div class="mb-3">
      <label class="form-label">Jam</label>
      <input name="jam" type="time" class="form-control" value="{{ old('jam', $jadwal->jam ?? '') }}" {{ $isReadOnly && !$isAdmin ? 'readonly' : '' }}>
    </div>
    <div class="mb-3">
      <label class="form-label">Guru BK</label>
      <select name="guru_bk_id" class="form-control" {{ $isReadOnly && !$isAdmin ? 'disabled' : '' }}>
        <option value="">-- Pilih Guru BK --</option>
        @foreach($gurus as $g)
          <option value="{{ $g->id }}" {{ (old('guru_bk_id', $jadwal->guru_bk_id ?? '')==$g->id)?'selected':'' }}>Bu {{ ucwords(strtolower($g->name)) }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Tempat</label>
      <input name="tempat" class="form-control" value="{{ old('tempat', $jadwal->tempat ?? '') }}" {{ $isReadOnly && !$isAdmin ? 'readonly' : '' }}>
    </div>

    @if($isAdmin && isset($jadwal))
    <div class="mb-3">
      <label class="form-label">Status (Admin Only)</label>
      <select name="status" class="form-control">
        <option value="pending" {{ (old('status', $jadwal->status ?? '')=='pending')?'selected':'' }}>Menunggu</option>
        <option value="terjadwal" {{ (old('status', $jadwal->status ?? '')=='terjadwal')?'selected':'' }}>Terjadwal</option>
        <option value="selesai" {{ (old('status', $jadwal->status ?? '')=='selesai')?'selected':'' }}>Selesai</option>
        <option value="batal" {{ (old('status', $jadwal->status ?? '')=='batal')?'selected':'' }}>Batal</option>
      </select>
    </div>
    @endif

    @if(!$isReadOnly || $isAdmin)
      <button class="btn btn-primary">Simpan</button>
    @endif
  </form>
@endif

@endsection
