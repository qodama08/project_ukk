<!DOCTYPE html>
<html lang="en">
    <!-- [Head] start -->

    <head>
        <title>@yield('title')</title>
        <!-- [Meta] -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description"
            content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
        <meta name="keywords"
            content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
        <meta name="author" content="CodedThemes">

        <!-- [Favicon] icon -->

        <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
        <!-- [Google Font] Family -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
            id="main-font-link">
        <!-- [Tabler Icons] https://tablericons.com -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
        <!-- [Feather Icons] https://feathericons.com -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
        <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
        <!-- [Material Icons] https://fonts.google.com/icons -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
        <!-- [Template CSS Files] -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
        <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">

    </head>
    <!-- [Head] end -->
    <!-- [Body] Start -->

    <body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
        <!-- [ Pre-loader ] start -->
        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>
        <!-- [ Pre-loader ] End -->
        <!-- [ Sidebar Menu ] start -->
        <nav class="pc-sidebar">
            <div class="sidebar-content">
                <ul class="sidebar-menu">
                    <li class="sidebar-item sidebar-large">
                        <a href="{{ route('dashboard') }}" class="sidebar-link sidebar-link-large"><i class="ti ti-home"></i> <span class="ms-2">Dashboard</span></a>
                    </li>
                    <li class="sidebar-item sidebar-large">
                        <a href="{{ route('siswa.index') }}" class="sidebar-link sidebar-link-large"><i class="ti ti-users"></i> <span class="ms-2">Data Siswa</span></a>
                    </li>
                    <li class="sidebar-item sidebar-large">
                        <a href="{{ route('bk_ai.index') }}" class="sidebar-link sidebar-link-large"><i class="ti ti-help"></i> <span class="ms-2">BK AI</span></a>
                    </li>
                    <li class="sidebar-item sidebar-large">
                        <a href="{{ route('guru_bk.index') }}" class="sidebar-link sidebar-link-large"><i class="ti ti-user"></i> <span class="ms-2">Guru BK</span></a>
                    </li>
                    <li class="sidebar-item sidebar-large">
                        <a href="{{ route('prestasi.index') }}" class="sidebar-link sidebar-link-large"><i class="ti ti-award"></i> <span class="ms-2">Prestasi</span></a>
                    </li>
                    <li class="sidebar-item sidebar-large">
                        <a href="{{ route('pelanggaran.index') }}" class="sidebar-link sidebar-link-large"><i class="ti ti-alert-triangle"></i> <span class="ms-2">Pelanggaran</span></a>
                    </li>
                    <li class="sidebar-item sidebar-large">
                        <a href="{{ route('jadwal_konseling.index') }}" class="sidebar-link sidebar-link-large"><i class="ti ti-calendar"></i> <span class="ms-2">Jadwal Konseling</span></a>
                    </li>
                    <li class="sidebar-item sidebar-large">
                        <a href="{{ route('catatan_konseling.index') }}" class="sidebar-link sidebar-link-large"><i class="ti ti-notebook"></i> <span class="ms-2">Catatan Konseling</span></a>
                    </li>
                </ul>
                <style>
                    .sidebar-large {
                        font-size: 1.25rem;
                        font-weight: 600;
                        margin-bottom: 0.5rem;
                    }
                    .sidebar-link-large {
                        padding: 0.75rem 1.25rem;
                        display: flex;
                        align-items: center;
                        border-radius: 8px;
                        transition: background 0.2s;
                    }
                    .sidebar-link-large i {
                        font-size: 1.4em;
                    }
                    .sidebar-link-large:hover, .sidebar-link-large.active {
                        background: #f0f4ff;
                        color: #1976d2;
                        text-decoration: none;
                    }
                </style>
            </div>
        </nav>
        <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
        <header class="pc-header">
            <div class="header-wrapper d-flex justify-content-between align-items-center">
                <div class="me-auto pc-mob-drp">
                    <!-- Kosongkan kiri jika ingin message di kanan -->
                </div>
                <ul class="d-flex align-items-center mb-0" style="list-style:none;gap:10px;">
                    {{-- Fitur message/notifikasi hanya untuk admin --}}
                    @if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists())
                    <li class="dropdown pc-h-item">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0 position-relative" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="ti ti-mail"></i>
                                @php
                                    $unreadCount = \App\Models\Notifikasi::where('user_id', auth()->id())->where('is_read', false)->count();
                                @endphp
                                @if($unreadCount > 0)
                                    <span class="badge rounded-circle bg-danger" style="position: absolute; top: -5px; right: -5px; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; padding: 0; line-height: 1; border: 2px solid white;">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                        </a>
                        @php
                            $notifs = [];
                            if (auth()->check()) {
                                $notifs = \App\Models\Notifikasi::where('user_id', auth()->id())->orderBy('created_at', 'desc')->limit(10)->get();
                            }
                        @endphp
                        <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                 <h5 class="m-0">Message</h5>
                                 <a href="#" class="pc-head-link bg-transparent" id="closeNotifDropdown"><i class="ti ti-x text-danger"></i></a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative"
                                    style="max-height: calc(100vh - 215px)">
                                    <div class="list-group list-group-flush w-100">
                                        @forelse($notifs as $notif)
                                            <div class="list-group-item list-group-item-action p-0 position-relative">
                                                <a href="{{ route('jadwal_konseling.index') }}" class="d-flex p-3 text-decoration-none text-dark markAsRead" data-notif-id="{{ $notif->id }}" style="display:flex;">
                                                    <div class="flex-shrink-0">
                                                        <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="user-image" class="user-avtar">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 w-100">
                                                        <span class="float-end text-muted small">{{ $notif->created_at->format('d/m H:i') }}</span>
                                                        <p class="text-body mb-1"><b>{{ $notif->title }}</b></p>
                                                        <span class="text-muted small">{{ $notif->message }}</span>
                                                    </div>
                                                </a>
                                            </div>
                                        @empty
                                            <div class="text-center text-muted py-2">Tidak ada notifikasi</div>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                @if($notifs->count() > 0)
                                <div class="text-center py-2">
                                    <a href="{{ route('jadwal_konseling.index') }}" class="link-primary markAllAsRead">View all</a>
                                </div>
                                @endif
                        </div>
                    </li>
                    @endif
                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside"
                            aria-expanded="false">
                            <span>{{ auth()->user() ? auth()->user()->name : 'Guest' }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="ti ti-power"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
                    <!-- Duplicate user profile removed -->
        </header>
        <!-- [ Header ] end -->



        <!-- [ Main Content ] start -->
        <div class="pc-container">
            @yield('content')
        </div>
        <!-- [ Main Content ] end -->
        <!-- Footer dihapus sesuai permintaan -->

        <!-- [Page Specific JS] start -->
        <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/dashboard-default.js') }}"></script>
        <!-- [Page Specific JS] end -->
        <!-- Required Js -->
        <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
        <script src="{{ asset('assets/js/pcoded.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>





        <script>
            layout_change('light');
        </script>




        <script>
            change_box_container('false');
        </script>



        <script>
            layout_rtl_change('false');
        </script>


        <script>
            preset_change("preset-1");
        </script>


        <script>
            font_change("Public-Sans");
        </script>


        <script>
            if (window.location.hash === '#_=_') {
                history.replaceState(null, null, window.location.pathname);
            }
        </script>
    </body>
    <!-- [Body] end -->

</html>
