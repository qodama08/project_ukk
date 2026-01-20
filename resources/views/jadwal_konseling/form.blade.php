@extends('layouts.dashboard')

@section('title', isset($jadwal) ? (request()->routeIs('jadwal_konseling.show') ? 'Detail' : 'Edit') : 'Buat Jadwal Konseling')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/jadwal_konseling">Jadwal Konseling</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($jadwal) ? (request()->routeIs('jadwal_konseling.show') ? 'Detail' : 'Edit') : 'Buat' }} Jadwal Konseling</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4">{{ isset($jadwal) ? (request()->routeIs('jadwal_konseling.show') ? 'Detail' : 'Edit') : 'Buat' }} Jadwal Konseling</h2>

    @php
      $isReadOnly = isset($jadwal) && request()->routeIs('jadwal_konseling.show');
      $isAdmin = auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->roles()->where('nama_role','admin')->exists());
      $isSiswa = auth()->check() && !$isAdmin;
      $showForm = !$isReadOnly || $isAdmin;
    @endphp

    @if($isReadOnly && !$isAdmin)
      <!-- Display-only mode for non-admin users viewing detail -->
      <div class="alert alert-info mb-4">Detail Jadwal Konseling</div>
      <form>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Nama Siswa</label>
              <input type="text" class="form-control" value="{{ $jadwal->nama_siswa ?? '-' }}" readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Kelas</label>
              <input type="text" class="form-control" value="{{ $jadwal->kelas ?? '-' }}" readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Absen</label>
              <input type="text" class="form-control" value="{{ $jadwal->absen ?? '-' }}" readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Tanggal</label>
              <input type="date" class="form-control" value="{{ $jadwal->tanggal ?? '' }}" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Jam</label>
              <input type="time" class="form-control" value="{{ $jadwal->jam ?? '' }}" readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Guru BK</label>
              <input type="text" class="form-control" value="{{ $jadwal->guru->name ?? '-' }}" readonly>
            </div>
            <!-- Kolom tempat dihapus -->
            <div class="mb-3">
              <label class="form-label">Status</label>
              <span class="badge bg-warning" style="padding: 8px 12px; font-size: 14px;">{{ ucfirst($jadwal->status) }}</span>
            </div>
          </div>
        </div>
        <a href="{{ route('jadwal_konseling.index') }}" class="btn btn-secondary">Kembali</a>
      </form>
    @else
      <!-- Editable form for admin or create/edit mode -->
      <form method="POST" action="{{ isset($jadwal) && !request()->routeIs('jadwal_konseling.show') ? url('/jadwal_konseling/'.$jadwal->id) : (isset($jadwal) && request()->routeIs('jadwal_konseling.show') && $isAdmin ? url('/jadwal_konseling/'.$jadwal->id) : url('/jadwal_konseling')) }}">
        @csrf
        @if(isset($jadwal)) @method('PUT') @endif

        <div class="row">
          <div class="col-md-6">
            <!-- Siswa hanya input manual, Admin bisa pilih dropdown -->
            @if($isSiswa)
              <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <input type="text" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa', $jadwal->nama_siswa ?? auth()->user()->name) }}" required>
                @error('nama_siswa')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>
              <div class="mb-3">
                <label class="form-label">Kelas</label>
                <select name="kelas" class="form-control @error('kelas') is-invalid @enderror" required>
                  <option value="">-- Pilih Kelas --</option>
                  <option value="XII TKR 2" {{ old('kelas', $jadwal->kelas ?? (auth()->user()->kelas?->nama_kelas ?? '')) == 'XII TKR 2' ? 'selected' : '' }}>XII TKR 2</option>
                  <option value="XII RPL" {{ old('kelas', $jadwal->kelas ?? (auth()->user()->kelas?->nama_kelas ?? '')) == 'XII RPL' ? 'selected' : '' }}>XII RPL</option>
                  <option value="XII TPM 4" {{ old('kelas', $jadwal->kelas ?? (auth()->user()->kelas?->nama_kelas ?? '')) == 'XII TPM 4' ? 'selected' : '' }}>XII TPM 4</option>
                  <option value="XII TITL" {{ old('kelas', $jadwal->kelas ?? (auth()->user()->kelas?->nama_kelas ?? '')) == 'XII TITL' ? 'selected' : '' }}>XII TITL</option>
                </select>
                @error('kelas')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>
              <div class="mb-3">
                <label class="form-label">Absen</label>
                <input type="number" name="absen" class="form-control @error('absen') is-invalid @enderror" value="{{ old('absen', $jadwal->absen ?? auth()->user()->absen) }}" required>
                @error('absen')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>
            @else
              <!-- Admin: dropdown pilih siswa -->
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
            @endif

            <div class="mb-3">
              <label class="form-label">Tanggal</label>
              <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $jadwal->tanggal ?? '') }}" min="{{ now()->format('Y-m-d') }}" required>
              @error('tanggal')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Jam</label>
              <input type="time" name="jam" class="form-control @error('jam') is-invalid @enderror" value="{{ old('jam', $jadwal->jam ?? '') }}" min="07:00" max="15:00" required>
              @error('jam')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Guru BK</label>
              <select name="guru_bk_id" class="form-control @error('guru_bk_id') is-invalid @enderror" required>
                <option value="">-- Pilih Guru BK --</option>
                @foreach($gurus as $g)
                  <option value="{{ $g->id }}" {{ (old('guru_bk_id', $jadwal->guru_bk_id ?? '')==$g->id)?'selected':'' }}>{{ ucwords(strtolower($g->name)) }}</option>
                @endforeach
              </select>
              @error('guru_bk_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <!-- Kolom tempat dihapus -->

            @if($isAdmin && isset($jadwal))
              <div class="mb-3">
                <label class="form-label">Status (Admin Only)</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror">
                  <option value="pending" {{ (old('status', $jadwal->status ?? '')=='pending')?'selected':'' }}>Menunggu</option>
                  <option value="terjadwal" {{ (old('status', $jadwal->status ?? '')=='terjadwal')?'selected':'' }}>Terjadwal</option>
                  <option value="selesai" {{ (old('status', $jadwal->status ?? '')=='selesai')?'selected':'' }}>Selesai</option>
                  <option value="batal" {{ (old('status', $jadwal->status ?? '')=='batal')?'selected':'' }}>Batal</option>
                </select>
                @error('status')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>
            @endif
          </div>
        </div>

        <div class="mt-4">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="{{ route('jadwal_konseling.index') }}" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    @endif
</div>

@endsection
