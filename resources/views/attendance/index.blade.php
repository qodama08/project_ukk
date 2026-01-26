@extends('layouts.dashboard')

@section('title', 'Kehadiran Siswa')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kehadiran Siswa</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Kehadiran Siswa</h1>
        <div>
            @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'guru_wali_kelas')->exists())
                <a href="/attendance/create" class="btn btn-primary">Catat Kehadiran</a>
            @endif
        </div>
    </div>

    @if($attendance->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Guru Wali Kelas</th>
                    @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'guru_wali_kelas')->exists())
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($attendance as $a)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $a->siswa->name ?? '-' }}</td>
                        <td>{{ $a->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $a->tanggal->format('d-m-Y') }}</td>
                        <td>
                            @php
                                $statusClass = 'bg-secondary';
                                $statusLabel = $a->status;
                                
                                if ($a->status === 'hadir') {
                                    $statusClass = 'bg-success';
                                    $statusLabel = 'Hadir';
                                } elseif ($a->status === 'izin') {
                                    $statusClass = 'bg-info';
                                    $statusLabel = 'Izin';
                                } elseif ($a->status === 'sakit') {
                                    $statusClass = 'bg-warning text-dark';
                                    $statusLabel = 'Sakit';
                                } elseif ($a->status === 'alfa') {
                                    $statusClass = 'bg-danger';
                                    $statusLabel = 'Alfa';
                                }
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                        </td>
                        <td>{{ $a->keterangan ?? '-' }}</td>
                        <td>{{ $a->guruWaliKelas->name ?? '-' }}</td>
                        @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'guru_wali_kelas')->exists() && auth()->id() === $a->guru_wali_kelas_id)
                            <td>
                                <a href="/attendance/{{ $a->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                                <form action="/attendance/{{ $a->id }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $attendance->links() }}
    @else
        <div class="alert alert-info">
            Belum ada data kehadiran.
        </div>
    @endif
</div>
@endsection
