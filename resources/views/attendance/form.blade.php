@extends('layouts.dashboard')

@section('title', 'Catat Kehadiran Siswa')

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
                        <li class="breadcrumb-item active" aria-current="page">Catat Kehadiran</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Catat Kehadiran Siswa</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('attendance.store') }}">
        @csrf

        <div class="card mb-4">
            <div class="card-header">
                <h5>Informasi Kehadiran</h5>
            </div>
            <div class="card-body">
                <div class="mb-4 p-3 border rounded bg-light">
                    <p><strong>Kelas:</strong> {{ $kelas->nama_kelas }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" required value="{{ old('tanggal') }}">
                </div>

                <div id="entries-container">
                    <div class="entry-row mb-4 p-3 border rounded">
                        <h6 class="mb-3">Siswa #1</h6>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                                    <select name="entries[0][siswa_id]" class="form-control" required>
                                        <option value="">-- Pilih Siswa --</option>
                                        @foreach($siswa as $s)
                                            <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->absen ?? '-' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="entries[0][status]" class="form-control" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="hadir">Hadir</option>
                                        <option value="izin">Izin</option>
                                        <option value="sakit">Sakit</option>
                                        <option value="alfa">Alfa</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="entries[0][keterangan]" class="form-control" placeholder="Contoh: Sakit flu, dll">
                        </div>

                        <button type="button" class="btn btn-sm btn-danger remove-entry" onclick="removeEntry(this)">Hapus Baris</button>
                    </div>
                </div>

                <button type="button" class="btn btn-secondary mt-3" onclick="addEntry()">+ Tambah Siswa Lain</button>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan Kehadiran</button>
            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
let entryCount = 1;

function addEntry() {
    const container = document.getElementById('entries-container');
    const html = `
        <div class="entry-row mb-4 p-3 border rounded">
            <h6 class="mb-3">Siswa #${entryCount + 1}</h6>
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                        <select name="entries[${entryCount}][siswa_id]" class="form-control" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswa as $s)
                                <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->absen ?? '-' }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="entries[${entryCount}][status]" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alfa">Alfa</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <input type="text" name="entries[${entryCount}][keterangan]" class="form-control" placeholder="Contoh: Sakit flu, dll">
            </div>

            <button type="button" class="btn btn-sm btn-danger remove-entry" onclick="removeEntry(this)">Hapus Baris</button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    entryCount++;
}

function removeEntry(btn) {
    btn.closest('.entry-row').remove();
}
</script>
@endsection
