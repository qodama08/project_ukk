@extends('layouts.dashboard')
@section('title', 'Dashboard Page')

@section('content')
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Home</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>

                            <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        @php
            $user = auth()->user();
            $isAdmin = $user && $user->role == 'admin';
            $isGuruBK = $user && $user->roles && $user->roles()->where('nama_role', 'guru_bk')->exists();
        @endphp

        @if ($isAdmin)
            @include('admin.dashboard')
        @elseif ($isGuruBK)
            @include('guru.dashboard')
        @else
            @include('user.dashboard')
        @endif

    </div>
@endsection
