@extends('layouts.dashboard')

@section('title', 'Data Pelanggaran')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Pelanggaran</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-4">Data Pelanggaran</h2>
    @php
      $isAdmin = auth()->check() && auth()->user()->role == 'admin';
    @endphp
    @if($isAdmin)
      <div class="mb-3 text-end">
        <a href="/pelanggaran/create" class="btn btn-primary">+ Buat Pelanggaran</a>
      </div>
    @endif
    <table class="table table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Nama Siswa</th>
          <th>Kelas</th>
          <th>Absen</th>
          <th>Nama Pelanggaran</th>
          <th>Poin</th>
          <th>Tingkat</th>
          @if($isAdmin)
            <th>Aksi</th>
          @endif
        </tr>
      </thead>
      <tbody>
      @forelse($items as $it)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td><strong>{{ $it->nama_siswa ?? ($it->user->name ?? '-') }}</strong></td>
          <td>{{ $it->kelas ?? '-' }}</td>
          <td>{{ $it->absen ?? '-' }}</td>
          <td>{{ $it->nama_pelanggaran }}</td>
          <td>{{ $it->poin }}</td>
          <td>
            @if($it->tingkat_warna == 'hijau')
              <span class="badge bg-success">Hijau</span>
            @elseif($it->tingkat_warna == 'kuning')
              <span class="badge bg-warning">Kuning</span>
            @elseif($it->tingkat_warna == 'merah')
              <span class="badge bg-danger">Merah</span>
            @endif
          </td>
          @if($isAdmin)
            <td>
              <a href="/pelanggaran/{{ $it->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
              <form action="/pelanggaran/{{ $it->id }}" method="POST" style="display:inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus pelanggaran ini?')">Hapus</button>
              </form>
            </td>
          @endif
        </tr>
      @empty
        <tr><td colspan="{{ $isAdmin ? 9 : 8 }}" class="text-center text-muted">Belum ada data pelanggaran</td></tr>
      @endforelse
      </tbody>
    </table>
</div>
@endsection
