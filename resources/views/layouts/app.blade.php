<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BK App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="/dashboard">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="/pelanggaran">Pelanggaran</a></li>
            <li class="nav-item"><a class="nav-link" href="/prestasi">Prestasi</a></li>
            <li class="nav-item"><a class="nav-link" href="/jadwal_konseling">Jadwal Konseling</a></li>
            <li class="nav-item"><a class="nav-link" href="/catatan_konseling">Catatan Konseling</a></li>
          </ul>
          <ul class="navbar-nav ms-auto">
            @auth
              @php
                $unread = \App\Models\Notifikasi::where('user_id', auth()->id())->where('is_read', false)->count();
              @endphp
              <li class="nav-item">
                <a class="nav-link position-relative" href="{{ route('notifikasi.index') }}">Notifikasi
                  @if($unread > 0)
                    <span class="badge bg-danger position-absolute" style="top:0;right:0;transform:translate(50%,-30%);">{{ $unread }}</span>
                  @endif
                </a>
              </li>
            @endauth
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-4">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
