@extends('layouts.dashboard')

@section('title', 'Jadwal Konseling')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Jadwal Konseling</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1>Jadwal Konseling</h1>
      <div>
        @if(auth()->check() && !auth()->user()->roles()->where('nama_role', 'admin')->exists())
          <a href="/jadwal_konseling/create" class="btn btn-primary">Ajukan Konseling</a>
        @endif
      </div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr><th>#</th><th>Nama Siswa</th><th>Kelas</th><th>Absen</th><th>Guru</th><th>Tanggal</th><th>Jam</th><th>Status</th><th>Info Batal</th>@if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists())<th>Actions</th>@endif</tr>
      </thead>
      <tbody>
      @foreach($jadwals as $j)
        @php
          $statusClass = 'bg-secondary';
          if ($j->status == 'pending') $statusClass = 'bg-warning text-dark';
          elseif ($j->status == 'terjadwal') $statusClass = 'bg-primary';
          elseif ($j->status == 'selesai') $statusClass = 'bg-success';
          elseif ($j->status == 'batal') $statusClass = 'bg-danger';
          $statusLabels = [
            'pending' => 'Menunggu',
            'terjadwal' => 'Terjadwal',
            'selesai' => 'Selesai',
            'batal' => 'Batal'
          ];
          $statusLabel = $statusLabels[$j->status] ?? ucwords(str_replace('_',' ',$j->status));
        @endphp
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $j->nama_siswa ?? $j->siswa->name ?? '-' }}</td>
          <td>{{ $j->kelas ?? '-' }}</td>
          <td>{{ $j->absen ?? '-' }}</td>
          <td>{{ $j->guru->name ?? '-' }}</td>
          <td>{{ $j->tanggal }}</td>
          <td>{{ $j->jam }}</td>
          <td>
            <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
          </td>
          <td>
            @if($j->status == 'batal' && $j->alasan_batal)
              <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#infoModal{{ $j->id }}" title="Lihat alasan pembatalan">Lihat Alasan</button>
            @elseif($j->status != 'batal')
              <span class="text-muted">-</span>
            @endif
          </td>
          @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists())
          <td>
            <div class="btn-group" role="group">
              {{-- Admin only: can set status to selesai when pending or terjadwal --}}
              @if($j->status == 'pending' || $j->status == 'terjadwal')
                  <form action="{{ url('/jadwal_konseling/'.$j->id.'/set_status') }}" method="POST" style="display:inline-block">
                    @csrf
                    <input type="hidden" name="status" value="selesai">
                    <button class="btn btn-sm btn-success" title="Tandai jadwal sebagai selesai">Set Selesai</button>
                  </form>
                  <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $j->id }}" title="Batalkan jadwal dengan alasan">Batal</button>
              @endif
            </div>
          </td>
          @endif
        </tr>

        {{-- Modal untuk membatalkan jadwal --}}
        @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists())
        <div class="modal fade" id="cancelModal{{ $j->id }}" tabindex="-1" aria-labelledby="cancelModalLabel{{ $j->id }}" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel{{ $j->id }}">Batalkan Jadwal Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="{{ route('jadwal_konseling.cancel', $j->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                  <p><strong>Siswa:</strong> {{ $j->nama_siswa ?? $j->siswa->name ?? '-' }}</p>
                  <p><strong>Tanggal:</strong> {{ $j->tanggal }} {{ $j->jam }}</p>
                  <div class="mb-3">
                    <label for="alasan{{ $j->id }}" class="form-label">Alasan Pembatalan <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="alasan{{ $j->id }}" name="alasan_batal" rows="3" placeholder="Masukkan alasan pembatalan jadwal konseling..." required></textarea>
                    <small class="form-text text-muted">Minimal 5 karakter, maksimal 500 karakter</small>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-danger">Batalkan Jadwal</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        @endif

        {{-- Modal untuk melihat alasan pembatalan --}}
        <div class="modal fade" id="infoModal{{ $j->id }}" tabindex="-1" aria-labelledby="infoModalLabel{{ $j->id }}" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel{{ $j->id }}">Alasan Pembatalan Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p><strong>Siswa:</strong> {{ $j->nama_siswa ?? $j->siswa->name ?? '-' }}</p>
                <p><strong>Tanggal:</strong> {{ $j->tanggal }} {{ $j->jam }}</p>
                <div class="mb-3">
                  <label class="form-label"><strong>Alasan Pembatalan:</strong></label>
                  <div class="card">
                    <div class="card-body">
                      {{ $j->alasan_batal }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>
      @endforeach
      </tbody>
    </table>
</div>

<script>
$(document).ready(function(){
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
@endsection
