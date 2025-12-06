@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Pelanggaran</h1>
  <div>
    @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists())
      <a href="/pelanggaran/create" class="btn btn-primary">+ Buat Pelanggaran</a>
    @endif
  </div>
</div>

{{-- flash message shown in layout; avoid duplicate here --}}

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
      <th>Aksi</th>
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
        @else
          -
        @endif
      </td>
      <td>
        @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists())
          <a href="/pelanggaran/{{ $it->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
        @endif
        <form action="/pelanggaran/{{ $it->id }}" method="POST" style="display:inline-block">
          @csrf
          @method('DELETE')
          @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists())
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
          @endif
        </form>
      </td>
    </tr>
  @empty
    <tr><td colspan="6" class="text-center text-muted">Belum ada pelanggaran</td></tr>
  @endforelse
  </tbody>
</table>

@endsection
