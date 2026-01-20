@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h3 class="card-title text-center mb-4">Verifikasi Kode OTP</h3>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Terjadi Kesalahan!</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.verify-otp') }}">
                        @csrf

                        <!-- Email (Read-only) -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $email }}" readonly>
                        </div>

                        <!-- OTP Input -->
                        <div class="mb-3">
                            <label for="otp" class="form-label">Masukkan Kode OTP</label>
                            <input type="text" 
                                   class="form-control form-control-lg text-center @error('otp') is-invalid @enderror" 
                                   id="otp" 
                                   name="otp" 
                                   placeholder="000000"
                                   maxlength="6" 
                                   pattern="\d{6}"
                                   required
                                   autofocus>
                            <small class="form-text text-muted d-block mt-2">Kami telah mengirim kode OTP ke email Anda. Kode OTP berlaku selama 5 menit.</small>
                            @error('otp')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Hidden Email Field -->
                        <input type="hidden" name="email" value="{{ $email }}">

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Verifikasi OTP
                            </button>
                        </div>
                    </form>

                    <!-- Resend OTP -->
                    <div class="mt-3 text-center">
                        <small>Tidak menerima kode OTP? 
                            <a href="{{ route('forgot_password.email_form') }}">Kirim Ulang</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
