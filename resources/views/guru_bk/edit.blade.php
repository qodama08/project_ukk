@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Edit Guru BK</h1>

    <form method="POST" action="{{ route('guru_bk.update', $guru_bk->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                        value="{{ old('name', $guru_bk->name) }}" required>
                    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                        value="{{ old('email', $guru_bk->email) }}" required>
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="nomor_hp" class="form-control @error('nomor_hp') is-invalid @enderror" 
                        value="{{ old('nomor_hp', $guru_bk->nomor_hp) }}">
                    @error('nomor_hp')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('guru_bk.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
