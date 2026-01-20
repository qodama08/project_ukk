@extends('layouts.dashboard')

@section('title', 'Daftar Guru BK')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Guru BK</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-4">Daftar Guru BK</h2>
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
        </div>
        <div class="col-md-4 text-end">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('guru_bk.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Guru BK
                </a>
            @endif
        </div>
    </div>

    @if($gurus->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        @if(auth()->user()->role === 'admin')
                        <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($gurus as $guru)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $guru->name }}</td>
                            <td>{{ $guru->email }}</td>
                            <td>{{ $guru->nomor_hp ?? '-' }}</td>
                            @if(auth()->user()->role === 'admin')
                            <td>
                                <a href="{{ route('guru_bk.edit', $guru->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('guru_bk.destroy', $guru->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $gurus->links() }}
        </div>
    @else
        <div class="alert alert-info">
            Tidak ada Guru BK yang terdaftar
        </div>
    @endif
</div>
@endsection
