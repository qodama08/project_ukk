@extends('layouts.dashboard')

@section('title', isset($note) ? 'Edit Catatan Konseling' : 'Buat Catatan Konseling')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/catatan_konseling">Catatan Konseling</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($note) ? 'Edit' : 'Buat' }} Catatan Konseling</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-4">{{ isset($note) ? 'Edit' : 'Buat' }} Catatan Konseling</h2>
    <form method="POST" action="{{ isset($note) ? url('/catatan_konseling/'.$note->id) : url('/catatan_konseling') }}">
      @csrf
      @if(isset($note)) @method('PUT') @endif
      <div class="mb-3">
        <label class="form-label">Jadwal Konseling</label>
        <select id="jadwal_id" name="jadwal_id" class="form-control @error('jadwal_id') is-invalid @enderror" onchange="loadJadwalDetails()" required>
          <option value="">-- Pilih Jadwal Konseling --</option>
          @foreach(App\Models\JadwalKonseling::with('siswa','guru','catatan')->orderBy('tanggal','desc')->get() as $j)
            <option value="{{ $j->id }}" data-siswa="{{ $j->nama_siswa ?? ($j->siswa->name ?? '-') }}" data-guru="{{ $j->guru->name ?? '-' }}" {{ (old('jadwal_id', $note->jadwal_id ?? '')==$j->id)?'selected':'' }}>#{{ $j->id }} - {{ $j->nama_siswa ?? $j->siswa->name ?? '-' }} ({{ $j->tanggal }}) {{ $j->jam }}</option>
          @endforeach
        </select>
        @error('jadwal_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Siswa</label>
        <input type="text" id="siswa_name" class="form-control" readonly>
      </div>
      <div class="mb-3">
        <label class="form-label">Guru BK</label>
        <input type="text" id="guru_name" class="form-control" readonly>
      </div>
      <div class="mb-3">
        <label class="form-label">Hasil</label>
        <textarea name="hasil" class="form-control @error('hasil') is-invalid @enderror" required>{{ old('hasil', $note->hasil ?? '') }}</textarea>
        @error('hasil')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <button class="btn btn-primary">Simpan</button>
      <a href="/catatan_konseling" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script>
function loadJadwalDetails() {
  const select = document.getElementById('jadwal_id');
  const option = select.options[select.selectedIndex];
  const siswaName = option.getAttribute('data-siswa') || '';
  const guruName = option.getAttribute('data-guru') || '';
  document.getElementById('siswa_name').value = siswaName;
  document.getElementById('guru_name').value = guruName;
}
window.onload = loadJadwalDetails;
</script>
@endsection
