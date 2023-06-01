
@extends('layouts.login_reg')

@section('title', 'Verify Email')
@section('content')

    <div class="card w-75 border-0 my-auto mx-auto bg-transparent"
        style="postion:absolute;
    top:50%;transform:translateY(-50%)">

        <div class="card-body bg-transparent">
            <h2>Verify you Email</h2>
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }},
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit"
                    class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
            </form>
        </div>
    </div>
@endsection
