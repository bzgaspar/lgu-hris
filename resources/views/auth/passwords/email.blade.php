@extends('layouts.login_reg')

@section('title', 'Password Reset')
@section('content')

    <div class="card w-75 border-0 my-auto mx-auto bg-transparent"
        style="postion:absolute;
    top:50%;transform:translateY(-50%)">

        <div class="card-body bg-transparent">
            <h2>Reset Password</h2>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="row">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                    <div class="col">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                        <button type="submit" class="btn btn-outline-success">
                            {{ __('Send Password Reset Link') }}
                        </button>
                </div>
            </form>
        </div>
    </div>
@endsection
