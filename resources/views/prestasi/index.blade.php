@extends('layouts.dashboard')

@section('title', 'Data Prestasi')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Prestasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

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
          <th>Gambar</th>
          @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists())
          <th>Aksi</th>
          @endif
        </tr>
      </thead>
      <tbody>
      @forelse($prestasis as $p)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td><strong>{{ $p->siswa->name ?? $p->nama_siswa ?? '-' }}</strong></td>
          <td>{{ $p->siswa->kelas->nama_kelas ?? $p->kelas ?? '-' }}</td>
          <td>{{ $p->siswa->absen ?? $p->absen ?? '-' }}</td>
          <td>{{ $p->nama_prestasi ?? '-' }}</td>
          <td>
            @if($p->gambar)
              <img src="{{ asset('storage/' . $p->gambar) }}" alt="Prestasi" style="max-width: 80px; max-height: 80px; border-radius: 4px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal{{ $p->id }}">
              <!-- Modal untuk preview gambar -->
              <div class="modal fade" id="imageModal{{ $p->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $p->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="imageModalLabel{{ $p->id }}">{{ $p->nama_prestasi }}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                      <img src="{{ asset('storage/' . $p->gambar) }}" alt="Prestasi" style="max-width: 100%; max-height: 500px;">
                    </div>
                  </div>
                </div>
              </div>
            @else
              <span class="text-muted">-</span>
            @endif
          </td>
          @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists())
          <td>
              <a href="/prestasi/{{ $p->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
              <form action="/prestasi/{{ $p->id }}" method="POST" style="display:inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
              </form>
          </td>
          @endif
        </tr>
      @empty
        <tr><td colspan="7" class="text-center text-muted">Belum ada prestasi</td></tr>
      @endforelse
      </tbody>
    </table>

    {{ $prestasis->links() }}
</div>
@endsection
