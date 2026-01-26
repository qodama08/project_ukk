@extends('layouts.auth')

@section('title', 'Register Page')

@section('content')
    <div class="card my-5">
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h3 class="mb-0"><b>Sign up</b></h3>
                    <a href="/login" class="link-primary">Already have an account?</a>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">

                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach

                    </div>

                @endif
                <div class="form-group mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" required name="name" placeholder="Nama Lengkap"
                        autocomplete="off">
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Email Address*</label>
                    <input type="email" class="form-control" required name="email" placeholder="Email Address"
                        autocomplete="off">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" required name="password" placeholder="Password">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Password Confirmation</label>
                    <input type="password" class="form-control" required name="password_confirmation"
                        placeholder="Password Confirmation">
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Kelas <span class="text-danger">*</span></label>
                    <select name="kelas_id" id="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required onchange="updateAbsenOptions()">
                        <option value="">-- Pilih Kelas --</option>
                        @php
                            $kelasOptions = \App\Models\Kelas::with('jurusan')->orderBy('tingkat')->orderBy('nama_kelas')->get();
                        @endphp
                        @foreach($kelasOptions as $kelas)
                            <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }} - {{ $kelas->jurusan->nama_jurusan ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Nomor Absen <span class="text-danger">*</span></label>
                    <select name="absen" id="absen" class="form-control @error('absen') is-invalid @enderror" required>
                        <option value="">-- Pilih Nomor Absen --</option>
                    </select>
                    <small class="form-text text-muted">Pilih kelas terlebih dahulu untuk melihat nomor absen yang tersedia</small>
                    @error('absen')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                </div>

                <div class="form-group mb-3 mt-3">
                    <div style="display: flex; justify-content: center;">
                        {!! NoCaptcha::display(['data-theme' => 'light']) !!}
                    </div>
                    @error('g-recaptcha-response')
                        <span class="text-danger small d-block mt-2 text-center">{{ $message }}</span>
                    @enderror
                </div>
                <p class="mt-4 text-sm text-muted">By Signing up, you agree to our <a href="#" class="text-primary">
                        Terms
                        of Service </a> and <a href="#" class="text-primary"> Privacy Policy</a></p>
                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
                @include('auth.sso')

            </div>

        </form>
    </div>

<script>
function updateAbsenOptions() {
    const kelasId = document.getElementById('kelas_id').value;
    const absenSelect = document.getElementById('absen');
    
    console.log('Selected Kelas ID:', kelasId);
    
    // Clear previous options
    absenSelect.innerHTML = '<option value="">-- Pilih Nomor Absen --</option>';
    
    if (!kelasId) {
        absenSelect.disabled = true;
        return;
    }
    
    absenSelect.disabled = false;
    absenSelect.innerHTML = '<option value="">Loading...</option>';
    
    // Fetch available absen from API
    fetch('/api/available-absen/' + kelasId)
        .then(response => response.json())
        .then(data => {
            console.log('API Response:', data);
            
            if (!data.success) {
                absenSelect.innerHTML = '<option value="">Error loading absen</option>';
                return;
            }
            
            const availableAbsen = data.available_absen;
            
            if (availableAbsen.length === 0) {
                absenSelect.innerHTML = '<option value="">Semua nomor absen sudah digunakan</option>';
                absenSelect.disabled = true;
                return;
            }
            
            // Clear and add options
            absenSelect.innerHTML = '<option value="">-- Pilih Nomor Absen --</option>';
            
            availableAbsen.forEach(absen => {
                const option = document.createElement('option');
                option.value = absen;
                option.textContent = 'Absen ' + absen;
                absenSelect.appendChild(option);
            });
            
            // If there was a previous value and it's still available, select it
            const oldAbsen = '{{ old('absen') }}';
            if (oldAbsen && availableAbsen.includes(parseInt(oldAbsen))) {
                absenSelect.value = oldAbsen;
            }
        })
        .catch(error => {
            console.error('Error fetching available absen:', error);
            absenSelect.innerHTML = '<option value="">Error loading absen</option>';
        });
}

// Initialize on page load if kelas was already selected
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, checking if kelas is selected');
    if (document.getElementById('kelas_id').value) {
        updateAbsenOptions();
    }
});
</script>
@endsection
