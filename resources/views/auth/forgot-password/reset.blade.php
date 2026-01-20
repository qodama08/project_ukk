@extends('layouts.auth')

@section('title', 'Reset Password dengan OTP')

@section('content')
    <div class="card my-5">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="card-body">
                <div class="mb-4">
                    <h2 class="mb-4"><b>Reset Password</b></h2>
                    <div class="my-2">
                        <p class="mb-2">Masukkan email, kode OTP, dan password baru Anda untuk mereset password</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="form-group mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Kode OTP</label>
                    <input type="text" name="otp" class="form-control" placeholder="Masukkan 6 digit kode OTP" maxlength="6" value="{{ old('otp') }}" required>
                    <small class="text-muted">Cek email Anda untuk menerima kode OTP</small>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>

                <div class="mt-3 text-center">
                    <p>Belum menerima OTP? <a href="{{ route('forgot_password.email_form') }}">Kirim ulang</a></p>
                </div>
            </div>
        </form>
    </div>
@endsection
