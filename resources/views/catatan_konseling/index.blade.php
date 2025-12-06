@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Catatan Konseling</h1>
  @if(auth()->check() && (auth()->user()->roles()->where('nama_role', 'admin')->exists() || auth()->user()->roles()->where('nama_role', 'guru_bk')->exists()))
    <a href="/catatan_konseling/create" class="btn btn-primary">Buat Catatan</a>
  @endif
</div>

<table class="table table-striped">
  <thead>
    <tr><th>#</th><th>Siswa</th><th>Guru</th><th>Hasil</th><th>Tanggal</th></tr>
  </thead>
  <tbody>
  @foreach($notes as $n)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $n->siswa->name ?? ($n->jadwal->nama_siswa ?? '-') }}</td>
      <td>{{ $n->jadwal->guru->name ?? $n->guru->name ?? '-' }}</td>
        <td>{{ \Illuminate\Support\Str::limit($n->hasil,60) }}</td>
      <td>{{ $n->created_at }}</td>
    </tr>
  @endforeach
  </tbody>
</table>

@endsection
