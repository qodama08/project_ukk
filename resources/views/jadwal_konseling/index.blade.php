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
        <tr><th>#</th><th>Nama Siswa</th><th>Kelas</th><th>Absen</th><th>Guru</th><th>Tanggal</th><th>Jam</th><th>Status</th>@if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists())<th>Actions</th>@endif</tr>
      </thead>
      <tbody>
      @foreach($jadwals as $j)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $j->nama_siswa ?? $j->siswa->name ?? '-' }}</td>
          <td>{{ $j->kelas ?? '-' }}</td>
          <td>{{ $j->absen ?? '-' }}</td>
          <td>{{ $j->guru->name ?? '-' }}</td>
          <td>{{ $j->tanggal }}</td>
          <td>{{ $j->jam }}</td>
          <td>
            @php
              $note = $j->catatan ?? null;
            @endphp

            @if($note)
              @php
                $noteStatus = $note->status ?? 'pending';
                $noteBadge = ($noteStatus == 'setuju') ? 'bg-success' : 'bg-warning text-dark';
                $noteLabel = ($noteStatus == 'setuju') ? 'Disetujui' : 'Menunggu';
              @endphp
              <span class="badge {{ $noteBadge }}">{{ $noteLabel }}</span>
            @else
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
              <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
            @endif
          </td>
          @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists())
          <td>
            {{-- Admin only: can set status to selesai when pending --}}
            @if($j->status == 'pending')
                <form action="{{ url('/jadwal_konseling/'.$j->id.'/set_status') }}" method="POST" style="display:inline-block">
                  @csrf
                  <input type="hidden" name="status" value="selesai">
                  <button class="btn btn-sm btn-success">Set Selesai</button>
                </form>
            @endif
          </td>
          @endif
        </tr>
      @endforeach
      </tbody>
    </table>
</div>
@endsection
