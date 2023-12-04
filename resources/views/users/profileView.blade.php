@extends('layouts.app')

@section('title', 'Profile View | ' . $user->first_name)
@section('content')
    <div class="row justify-content-center">
        <div class="col-6 text-center">
            <img src="{{ asset('storage/user_avatar/' . $user->avatar) }}" alt=""
                class="avatar-img mx-auto d-block" />
            <p class="fw-bold">{{ $user->first_name }}
                @if ($user->pdsPersonal)
                    {{ $user->pdsPersonal->middle_name }}
                @endif
                {{ $user->last_name }}
            </p>
            <p>
                @if ($user->empPlantilla)
                    {{ $user->empPlantilla->EPposition }}
                @endif
            </p>
        </div>
    </div>
    <profile-view :user_id="{{ $user->id }}" :user_role="{{ $user->role }}" />
@endsection
