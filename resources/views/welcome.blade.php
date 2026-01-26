@extends('layouts.landing')

@section('title', 'Selamat Datang Di Bimbingan Konseling SMK ANTARTIKA 1 SIDOARJO')

@section('content')
    <!-- [ Header ] start -->
    <header id="home" class="d-flex align-items-center justify-content-center"
        style="position: relative; min-height: 100vh; width: 100%; background: linear-gradient(135deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.3) 100%), url('{{ asset('assets/images/my/bimbingankonseling.png') }}') no-repeat center center; background-size: cover; background-attachment: fixed;">
        <div class="container mt-5 pt-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8 text-center" style="position: relative; z-index: 1;">
                    <h1 class="mt-sm-3 text-white mb-4 f-w-600 wow fadeInUp" data-wow-delay="0.2s" style="font-size: 3.5rem;">
                        Selamat Datang di Bimbingan Konseling
                        <br>
                        <span class="text-primary">SMK ANTARTIKA 1 SIDOARJO</span>
                    </h1>
                    <h5 class="mb-4 text-white opacity-75 wow fadeInUp" data-wow-delay="0.4s" style="font-size: 1.25rem;">
                        <br class="d-none d-md-block">
                    </h5>
                </div>
            </div>
        </div>
    </header>
    <!-- [ Header ] End -->

    

    


    
    
@endsection
