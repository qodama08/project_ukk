@extends('layouts.app')

@section('content')
<h1>Edit Siswa</h1>

<form method="POST" action="/siswa/{{ $siswa->id }}">
  @csrf
  @method('PUT')

  <div class="row">
    <div class="col-md-6">
      <div class="mb-3">
        <label class="form-label">NISN</label>
        <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn', $siswa->nisn) }}" required>
        @error('nisn')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $siswa->name) }}" required>
        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Kelas & Jurusan</label>
        <select name="kelas_id" id="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" onchange="updateHiddenFields()" required>
          <option value="">-- Pilih Kelas & Jurusan --</option>
          @foreach($kelasJurusanOptions as $opt)
            <option value="{{ $opt->id }}" data-jurusan="{{ $opt->jurusan?->id }}" {{ old('kelas_id', $siswa->kelas_id) == $opt->id ? 'selected' : '' }}>{{ $opt->nama_kelas }}</option>
          @endforeach
        </select>
        @error('kelas_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>

      <input type="hidden" name="jurusan_id" id="jurusan_id" value="{{ old('jurusan_id', $siswa->jurusan_id) }}">

      <div class="mb-3">
        <label class="form-label">Absen</label>
        <input type="number" name="absen" class="form-control @error('absen') is-invalid @enderror" value="{{ old('absen', $siswa->absen) }}">
        @error('absen')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Umur</label>
        <input type="number" name="umur" class="form-control @error('umur') is-invalid @enderror" value="{{ old('umur', $siswa->umur) }}">
        @error('umur')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label class="form-label">No. HP Siswa</label>
        <input type="text" name="nomor_hp" class="form-control @error('nomor_hp') is-invalid @enderror" value="{{ old('nomor_hp', $siswa->nomor_hp) }}">
        @error('nomor_hp')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $siswa->alamat) }}</textarea>
        @error('alamat')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Nama Ayah</label>
        <input type="text" name="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah', $siswa->nama_ayah) }}">
        @error('nama_ayah')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Nama Ibu</label>
        <input type="text" name="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu', $siswa->nama_ibu) }}">
        @error('nama_ibu')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Nama Wali</label>
        <input type="text" name="nama_wali" class="form-control @error('nama_wali') is-invalid @enderror" value="{{ old('nama_wali', $siswa->nama_wali) }}">
        @error('nama_wali')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Hubungan Wali</label>
        <input type="text" name="hubungan_wali" class="form-control @error('hubungan_wali') is-invalid @enderror" value="{{ old('hubungan_wali', $siswa->hubungan_wali) }}">
        @error('hubungan_wali')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>

      <div class="mb-3">
        <label class="form-label">No. HP Wali</label>
        <input type="text" name="nomor_hp_wali" class="form-control @error('nomor_hp_wali') is-invalid @enderror" value="{{ old('nomor_hp_wali', $siswa->nomor_hp_wali) }}">
        @error('nomor_hp_wali')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>
  </div>

  <button type="submit" class="btn btn-primary">Perbarui</button>
  <a href="/siswa" class="btn btn-secondary">Batal</a>
</form>

<script>
function updateHiddenFields() {
  const kelasSelect = document.getElementById('kelas_id');
  const option = kelasSelect.options[kelasSelect.selectedIndex];
  const jurusanId = option.getAttribute('data-jurusan');
  document.getElementById('jurusan_id').value = jurusanId || '';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
  updateHiddenFields();
});
</script>

@endsection
