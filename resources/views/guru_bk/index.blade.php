@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h1>Daftar Guru BK</h1>
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gurus as $guru)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $guru->name }}</td>
                            <td>{{ $guru->email }}</td>
                            <td>{{ $guru->nomor_hp ?? '-' }}</td>
                            <td>
                                @if(auth()->user()->role === 'admin')
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
                                @else
                                    -
                                @endif
                            </td>
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
