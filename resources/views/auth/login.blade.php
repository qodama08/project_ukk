@extends('layouts.auth')

@section('title', 'Login Page')

@section('content')
    <div class="card my-5">
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h3 class="mb-0"><b>Login</b></h3>
                    <a href="/register" class="link-primary">Don't have an account?</a>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">

                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach

                    </div>

                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="form-group mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" placeholder="Email Address"
                        value="{{ session('registered_email') }}" autocomplete="off" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password</label>

                    @if (session('registered_email'))
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password"
                            autofocus required>
                    @else
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password"
                            required>
                    @endif
                </div>
                <div class="d-flex mt-1 justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" name="remember">
                        <label class="form-check-label text-muted" for="customCheckc1">Keep me sign
                            in</label>
                    </div>
                    <a href="{{ route('forgot_password.email_form') }}" class="text-secondary f-w-400">Forgot Password?</a>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                @include('auth.sso')
            </div>
        </form>
    </div>
@endsection
