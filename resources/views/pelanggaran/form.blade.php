@extends('layouts.dashboard')

@section('title', isset($item) ? 'Edit Pelanggaran' : 'Buat Pelanggaran')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/pelanggaran">Data Pelanggaran</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($item) ? 'Edit' : 'Buat' }} Pelanggaran</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-4">{{ isset($item) ? 'Edit' : 'Buat' }} Pelanggaran</h2>
    
    @if(isset($item) && $item->siswa_id)
      @php
        $totalPoinSiswa = \App\Models\Pelanggaran::where('siswa_id', $item->siswa_id)->sum('poin');
      @endphp
    @endif
    
    <form method="POST" action="{{ isset($item) ? url('/pelanggaran/'.$item->id) : url('/pelanggaran') }}">
      @csrf
      @if(isset($item)) @method('PUT') @endif
      
      <div class="mb-3">
        <label class="form-label">Siswa (Nama | Kelas | Absen)</label>
        <select name="siswa_id" id="siswa_id" class="form-control @error('siswa_id') is-invalid @enderror" required>
            <option value="">-- Pilih Siswa --</option>
            @foreach($siswa as $s)
              @php
                $isMasximum = $s->total_poin >= 100 && (!isset($item) || $item->siswa_id != $s->id);
                $disabledAttr = $isMasximum ? 'disabled' : '';
              @endphp
                <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id || (isset($item) && $item->siswa_id == $s->id) ? 'selected' : '' }} {{ $disabledAttr }}>
                    {{ $s->name }} | {{ $s->kelas->nama_kelas ?? '-' }} | {{ $s->absen ?? '-' }}
                    @if($s->total_poin > 0)
                      ({{ $s->total_poin }}/100 poin)
                    @endif
                    @if($isMasximum)
                      - MAKSIMAL
                    @endif
                </option>
            @endforeach
        </select>
        @error('siswa_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
        <small class="form-text text-muted d-block mt-2">Siswa yang sudah mencapai 100 poin tidak bisa dipilih</small>
      </div>
      
      @if(isset($item) && $item->siswa_id)
        @php
          $siswaItem = \App\Models\User::find($item->siswa_id);
          $totalPoin = \App\Models\Pelanggaran::where('siswa_id', $item->siswa_id)->sum('poin');
        @endphp
        <div class="alert alert-info mb-3">
          <strong>Status Poin Siswa {{ $siswaItem->name ?? '' }}:</strong> 
          <span class="badge bg-primary">{{ $totalPoin }}/100 poin</span>
          @if($totalPoin >= 100)
            <div class="mt-2 text-danger"><strong>⚠️ Siswa sudah mencapai poin maksimal (100 poin). Tidak bisa menambahkan poin lagi.</strong></div>
          @endif
        </div>
      @endif

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
        <select name="tingkat_warna" class="form-control @error('tingkat_warna') is-invalid @enderror" required>
          <option value="">-- Pilih Tingkat Warna --</option>
          <option value="hijau" {{ (old('tingkat_warna', $item->tingkat_warna ?? '')=='hijau')?'selected':'' }}>Hijau</option>
          <option value="kuning" {{ (old('tingkat_warna', $item->tingkat_warna ?? '')=='kuning')?'selected':'' }}>Kuning</option>
          <option value="merah" {{ (old('tingkat_warna', $item->tingkat_warna ?? '')=='merah')?'selected':'' }}>Merah</option>
        </select>
        @error('tingkat_warna')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="/pelanggaran" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
