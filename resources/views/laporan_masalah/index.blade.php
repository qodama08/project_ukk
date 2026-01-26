@extends('layouts.dashboard')

@section('title', 'Laporan Masalah')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Laporan Masalah</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Laporan Masalah Siswa</h1>
        <div>
            @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'guru_mapel')->exists())
                <a href="/laporan_masalah/create" class="btn btn-primary">Buat Laporan</a>
            @endif
        </div>
    </div>

    @if($laporan->count() > 0)
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Siswa</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Mata Pelajaran</th>
                    <th>Guru Mapel</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $l)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $l->siswa->name ?? '-' }}</td>
                        <td>{{ $l->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $l->tanggal_kejadian->format('d-m-Y') }}</td>
                        <td>{{ $l->jam_pelajaran }}</td>
                        <td>{{ $l->mata_pelajaran }}</td>
                        <td>{{ $l->guruMapel->name ?? '-' }}</td>
                        <td>
                            @php
                                $statusClass = 'bg-secondary';
                                $statusLabel = $l->status;
                                
                                if ($l->status === 'baru') {
                                    $statusClass = 'bg-info';
                                    $statusLabel = 'Baru';
                                } elseif ($l->status === 'diterima_wali') {
                                    $statusClass = 'bg-warning text-dark';
                                    $statusLabel = 'Diterima Wali';
                                } elseif ($l->status === 'diteruskan_admin') {
                                    $statusClass = 'bg-primary';
                                    $statusLabel = 'Diteruskan Admin';
                                } elseif ($l->status === 'ditanggani') {
                                    $statusClass = 'bg-warning text-dark';
                                    $statusLabel = 'Ditanggani';
                                } elseif ($l->status === 'selesai') {
                                    $statusClass = 'bg-success';
                                    $statusLabel = 'Selesai';
                                }
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                        </td>
                        <td>
                            <a href="/laporan_masalah/{{ $l->id }}" class="btn btn-sm btn-info">Detail</a>
                            
                            @if($l->status === 'baru' && auth()->check() && auth()->user()->waliKelas && auth()->user()->waliKelas->id === $l->kelas_id)
                                <a href="/laporan_masalah/{{ $l->id }}/terima" class="btn btn-sm btn-success">Terima</a>
                            @endif
                            
                            @if($l->status === 'diterima_wali' && auth()->check() && auth()->user()->waliKelas && auth()->user()->waliKelas->id === $l->kelas_id)
                                <a href="/laporan_masalah/{{ $l->id }}/teruskan" class="btn btn-sm btn-primary">Teruskan</a>
                            @endif
                            
                            @if(in_array($l->status, ['diteruskan_admin', 'ditanggani']) && auth()->check() && auth()->user()->role === 'admin')
                                <a href="/laporan_masalah/{{ $l->id }}/handle" class="btn btn-sm btn-warning">Handle</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $laporan->links() }}
    @else
        <div class="alert alert-info">
            Belum ada laporan masalah.
        </div>
    @endif
</div>
@endsection
