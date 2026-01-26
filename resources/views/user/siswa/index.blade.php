@extends('layouts.dashboard')

@section('title', 'Data Siswa')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Data Siswa</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-2">Data Siswa</h2>
    @php
      $isAdmin = auth()->check() && auth()->user()->role == 'admin';
    @endphp
    @if($isAdmin)
      <div class="mb-2 text-end">
        <a href="/siswa/create" class="btn btn-primary">+ Tambah Siswa</a>
      </div>
    @endif
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="table-responsive">
      <table class="table table-striped table-hover table-sm">
        <thead class="table-dark" style="font-weight: 600; font-size: 0.95rem; letter-spacing: 0.3px;">
          <tr>
            <th style="padding: 12px 8px; text-align: center; width: 5%;">#</th>
            <th style="padding: 12px 8px;">Nama</th>
            @if($isAdmin)
              <th style="padding: 12px 8px; text-align: center;">Aksi</th>
            @endif
          </tr>
        </thead>
        <tbody>
        @forelse($siswa as $s)
          <tr>
            <td style="padding: 10px 8px; text-align: center; vertical-align: middle;">{{ $loop->iteration }}</td>
            <td style="padding: 10px 8px; vertical-align: middle;"><strong>{{ $s->name }} | {{ $s->kelas->nama_kelas ?? '-' }} | {{ $s->absen ?? '-' }}</strong></td>
            @if($isAdmin)
              <td style="padding: 10px 8px; text-align: center; vertical-align: middle;">
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
          <tr><td colspan="{{ $isAdmin ? 3 : 2 }}" class="text-center text-muted py-2">Belum ada data siswa</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
</div>
@endsection
