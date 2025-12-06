@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Data Siswa</h1>
  <div>
    @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists())
      <a href="/siswa/create" class="btn btn-primary">+ Tambah Siswa</a>
    @endif
  </div>
</div>

{{-- flash message shown in layout; avoid duplicate here --}}

@php
  $isAdmin = auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists();
@endphp

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Absen</th>
        @if($isAdmin)
          <th>Aksi</th>
        @endif
      </tr>
    </thead>
    <tbody>
    @forelse($siswa as $s)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td><strong>{{ $s->name }}</strong></td>
        <td>{{ ($s->kelas->nama_kelas ?? '-') }}</td>
        <td>{{ $s->absen ?? '-' }}</td>
        @if($isAdmin)
          <td>
            <a href="/siswa/{{ $s->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
            <form action="/siswa/{{ $s->id }}" method="POST" style="display:inline-block">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus siswa ini?')">Hapus</button>
            </form>
          </td>
        @endif
      </tr>
    @empty
      <tr><td colspan="{{ $isAdmin ? 5 : 4 }}" class="text-center text-muted">Belum ada data siswa</td></tr>
    @endforelse
    </tbody>
  </table>
</div>

{{ $siswa->links() }}

@endsection
