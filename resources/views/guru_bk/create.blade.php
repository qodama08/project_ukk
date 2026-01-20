@extends('layouts.dashboard')

@section('title', 'Tambah Guru BK')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/guru_bk">Guru BK</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Guru BK</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-4">Tambah Guru BK</h2>
    <form method="POST" action="{{ route('guru_bk.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                        value="{{ old('name') }}" required>
                    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                        value="{{ old('email') }}" required>
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="nomor_hp" class="form-control @error('nomor_hp') is-invalid @enderror" 
                        value="{{ old('nomor_hp') }}">
                    @error('nomor_hp')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('guru_bk.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
