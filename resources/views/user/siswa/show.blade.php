@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>{{ $siswa->name }}</h1>
  <div>
    <a href="/siswa/{{ $siswa->id }}/edit" class="btn btn-warning">Edit</a>
    <a href="/siswa" class="btn btn-secondary">Kembali</a>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h5>Informasi Siswa</h5>
      </div>
      <div class="card-body">
        <table class="table table-borderless">
          <tr>
            <td><strong>NISN</strong></td>
            <td>{{ $siswa->nisn }}</td>
          </tr>
          <tr>
            <td><strong>Nama</strong></td>
            <td>{{ $siswa->name }}</td>
          </tr>
          <tr>
            <td><strong>Kelas</strong></td>
            <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
          </tr>
          <tr>
            <td><strong>Jurusan</strong></td>
            <td>{{ $siswa->jurusan->nama_jurusan ?? '-' }}</td>
          </tr>
          <tr>
            <td><strong>Absen</strong></td>
            <td>{{ $siswa->absen ?? '-' }}</td>
          </tr>
          <tr>
            <td><strong>Umur</strong></td>
            <td>{{ $siswa->umur ?? '-' }}</td>
          </tr>
          <tr>
            <td><strong>No. HP</strong></td>
            <td>{{ $siswa->nomor_hp ?? '-' }}</td>
          </tr>
          <tr>
            <td><strong>Alamat</strong></td>
            <td>{{ $siswa->alamat ?? '-' }}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-info text-white">
        <h5>Informasi Orang Tua/Wali</h5>
      </div>
      <div class="card-body">
        <table class="table table-borderless">
          <tr>
            <td><strong>Nama Ayah</strong></td>
            <td>{{ $siswa->nama_ayah ?? '-' }}</td>
          </tr>
          <tr>
            <td><strong>Nama Ibu</strong></td>
            <td>{{ $siswa->nama_ibu ?? '-' }}</td>
          </tr>
          <tr>
            <td><strong>Nama Wali</strong></td>
            <td>{{ $siswa->nama_wali ?? '-' }}</td>
          </tr>
          <tr>
            <td><strong>Hubungan Wali</strong></td>
            <td>{{ $siswa->hubungan_wali ?? '-' }}</td>
          </tr>
          <tr>
            <td><strong>No. HP Wali</strong></td>
            <td>{{ $siswa->nomor_hp_wali ?? '-' }}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
