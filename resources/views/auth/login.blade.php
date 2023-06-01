@extends('layouts.login_reg')

@section('title', 'Login')
@section('content')

    <div class="card w-75 border-0 my-auto mx-auto bg-transparent"
        style="postion:absolute;
    top:50%;transform:translateY(-50%)">

        <div class="card-body bg-transparent">
            <h2>Login to Your Account</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="div">
                    <p class="text-center">
                        Not yet Registered? <a href="{{ route('register') }}"
                            class="text-decoration-none text-success fw-bold">Register Here!</a>
                    </p>
                </div>

                <div class="row">
                    <label for="email" class="col-12 col-md-3 col-form-label text-md-end">{{ __('Email Address') }}</label>

                    <div class="col-12 col-md-9">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <label for="password" class="col-12 col-md-3 col-form-label text-md-end">{{ __('Password') }}</label>

                    <div class="col-12 col-md-9">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-12 col-md-9 offset-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-0">
                    <button type="submit" class="btn btn-success  w-100">
                        <i class="fa-solid fa-right-to-bracket"></i> {{ __('Login') }}
                    </button>
                </div>
                <div class="row mt-2 text-center">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
