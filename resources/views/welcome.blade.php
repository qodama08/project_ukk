@extends('layouts.landing')

@section('title', 'Selamat Datang Di Bimbingan Konseling SMK ANTARTIKA 1 SIDOARJO')


@section('content')
    <!-- [ Header ] start -->
    <header id="home" class="d-flex align-items-center"
        style="position: relative; min-height: 100dvh; background: url('{{ asset('assets/images/my/antartika.png') }}') no-repeat center center; background-size: cover;">
        <!-- Overlay -->
        <div
            style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0.1));">
        </div>

        <div class="container mt-5 pt-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8 text-center">
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

    

    

    <!-- [ CTA ] start -->
    <section class="cta-block"
        style="position: relative; padding: 120px 0; background: url('{{ asset('assets/images/my/antartika.png') }}') no-repeat center center; background-size: cover; background-attachment: fixed;">
        <!-- Overlay -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.6);">
        </div>

        <div class="container" style="position: relative; z-index: 2;">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="text-white mb-4" style="font-size: 2.8rem; font-weight: 600;"><span
                            class="text-primary"></span></h2>
                    <p class="text-white opacity-75 mb-4 lead">
                    </p>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg"><i
                            class="ti ti-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </section>
    <!-- [ CTA ] End -->

    
    
@endsection
