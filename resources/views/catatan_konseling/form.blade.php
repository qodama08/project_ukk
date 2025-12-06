@extends('layouts.app')

@section('content')
<h1>{{ isset($note) ? 'Edit' : 'Buat' }} Catatan Konseling</h1>

<form method="POST" action="{{ isset($note) ? url('/catatan_konseling/'.$note->id) : url('/catatan_konseling') }}">
  @csrf
  @if(isset($note)) @method('PUT') @endif

  <div class="mb-3">
    <label class="form-label">Jadwal</label>
    <select id="jadwal_id" name="jadwal_id" class="form-control" onchange="loadJadwalDetails()" required>
      <option value="">-- Pilih Jadwal --</option>
      @foreach(App\Models\JadwalKonseling::with('siswa','guru')->get() as $j)
        <option value="{{ $j->id }}" data-siswa="{{ $j->nama_siswa ?? ($j->siswa->name ?? '-') }}" data-guru="{{ $j->guru->name ?? '-' }}" {{ (old('jadwal_id', $note->jadwal_id ?? '')==$j->id)?'selected':'' }}>#{{ $j->id }} - {{ $j->nama_siswa ?? $j->siswa->name ?? '-' }} - {{ $j->tanggal }}</option>
      @endforeach
    </select>
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
    <textarea name="hasil" class="form-control">{{ old('hasil', $note->hasil ?? '') }}</textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Tindak Lanjut</label>
    <textarea name="tindak_lanjut" class="form-control">{{ old('tindak_lanjut', $note->tindak_lanjut ?? '') }}</textarea>
  </div>

  <button class="btn btn-primary">Simpan</button>
</form>

<script>
function loadJadwalDetails() {
  const select = document.getElementById('jadwal_id');
  const option = select.options[select.selectedIndex];
  const siswaName = option.getAttribute('data-siswa') || '';
  const guruName = option.getAttribute('data-guru') || '';
  
  document.getElementById('siswa_name').value = siswaName;
  document.getElementById('guru_name').value = guruName;
}

// Auto-load on page load if jadwal is already selected
document.addEventListener('DOMContentLoaded', function() {
  if (document.getElementById('jadwal_id').value) {
    loadJadwalDetails();
  }
});
</script>

@endsection
