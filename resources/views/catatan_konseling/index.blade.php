@extends('layouts.dashboard')

@section('title', 'Catatan Konseling')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Catatan Konseling</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Catatan Konseling</h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
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
          <td>{{ $n->jadwal->nama_siswa ?? ($n->siswa->name ?? '-') }}</td>
          <td>{{ $n->jadwal->guru->name ?? $n->guru->name ?? '-' }}</td>
            <td>{{ \Illuminate\Support\Str::limit($n->hasil,60) }}</td>
          <td>{{ $n->created_at }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>

</div>
@endsection
