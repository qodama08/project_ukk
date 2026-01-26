@extends('layouts.dashboard')

@section('title', 'Edit Kehadiran')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/attendance">Kehadiran Siswa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Kehadiran</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Edit Kehadiran</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('attendance.update', $attendance->id) }}">
        @csrf
        @method('PUT')

        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label"><strong>Siswa:</strong></label>
                    <p>{{ $attendance->siswa->name }}</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Tanggal:</strong></label>
                            <p>{{ $attendance->tanggal->format('d-m-Y') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Kelas:</strong></label>
                            <p>{{ $attendance->kelas->nama_kelas }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="hadir" {{ $attendance->status === 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="izin" {{ $attendance->status === 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="sakit" {{ $attendance->status === 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="alfa" {{ $attendance->status === 'alfa' ? 'selected' : '' }}>Alfa</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" value="{{ $attendance->keterangan ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
