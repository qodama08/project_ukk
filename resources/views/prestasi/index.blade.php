@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Prestasi</h1>
  <div>
    @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists())
      <a href="/prestasi/create" class="btn btn-primary">+ Catat Prestasi</a>
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
      <th>Prestasi</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
  @forelse($prestasis as $p)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td><strong>{{ $p->nama_siswa ?? '-' }}</strong></td>
      <td>{{ $p->kelas ?? '-' }}</td>
      <td>{{ $p->absen ?? '-' }}</td>
      <td>{{ $p->nama_prestasi ?? '-' }}</td>
      <td>
        @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists())
          <a href="/prestasi/{{ $p->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
          <form action="/prestasi/{{ $p->id }}" method="POST" style="display:inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
          </form>
        @endif
      </td>
    </tr>
  @empty
    <tr><td colspan="6" class="text-center text-muted">Belum ada prestasi</td></tr>
  @endforelse
  </tbody>
</table>

{{ $prestasis->links() }}

@endsection
