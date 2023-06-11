@extends('layouts.app')

@section('title', 'My Records')
@section('content')
    {{-- files --}}
    <div class="row justify-content-center">
        <div class="col-11 col-lg m-1 bg-success bg-gradient text-white rounded">
            <p class=" h3 text-center mb-3 fw-bold">Latest Plantilla</p>
            <div class="row justify-content-between">
                <div class="col-4">
                    <p>
                        No. :
                    </p>
                </div>
                <div class="col text-end">

                    <strong>
                        @if ($user->empPlantilla)
                            {{ $user->empPlantilla->EPno }}
                        @else
                            -
                        @endif
                    </strong>
                </div>
            </div>
            <div class="row">
                <div class="col-4">

                    <p>
                        Position :
                    </p>
                </div>
                <div class="col text-end">
                    <strong>
                        @if ($user->empPlantilla)
                            {{ $user->empPlantilla->EPposition }}
                        @else
                            -
                        @endif
                    </strong>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <p>
                        Department :
                    </p>
                </div>
                <div class="col text-end">
                    <strong>
                        @if ($user->empPlantilla)
                            {{ $user->empPlantilla->department->name }}
                        @else
                            -
                        @endif
                    </strong>
                </div>
            </div>
            <div class="row">
                <div class="col-4">

                    <p>
                        Designation :
                    </p>
                </div>
                <div class="col text-end">
                    <strong>
                        @if ($user->empPlantilla)
                            {{ $user->empPlantilla->designation->name }}
                        @else
                            -
                        @endif
                    </strong>
                </div>
            </div>
        </div>
        <div class="col-11 col-lg m-1 bg-success bg-gradient text-white rounded">
            <p class="h3 text-center mb-3 fw-bold">Leave Credit as of {{ today()->format('j F, Y') }}</p>
            <div class="row justify-content-center">
                <div class="col-11 col-md border border-1 rounded m-1">
                    <p class="text-center">Balance</p>
                    <div class="row">
                        <div class="col">
                            <p>
                                Vacation Leave
                            </p>
                        </div>
                        <div class="col-4 text-end">
                            <?php
                                $vl_balance = 0;
                                $sl_balance = 0;
                            ?>
                            <strong>
                                @if ($user->leaveCreditlatest)
                                    {{
                                    $vl_balance = $user->leaveCreditlatest->elc_vl_balance }}
                                @else
                                    -
                                @endif
                            </strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p>
                                Sick Leave
                            </p>
                        </div>
                        <div class="col-4 text-end">
                            <strong>
                                @if ($user->leaveCreditlatest)
                                    {{ $sl_balance = $user->leaveCreditlatest->elc_sl_balance }}
                                @else
                                    -
                                @endif
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
            <p class="h4 text-center my-3 fw-bold">
                Terminal Leave Balance
            </p>
            <p class="text-center h5 fw-bold">
                @if ($sl_balance || $vl_balance)
                    {{ App\Http\Controllers\HomeController::getTBL(Auth::user()->id, $vl_balance + $sl_balance) }}
                @endif
            </p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-11 col-lg m-1 bg-success bg-gradient text-white rounded">
            <p class=" h3 text-center mb-3 fw-bold">Next Loyalty Award</p>
            <p class="text-center my-3">
                @if ($user->hasloyaltyRecord())
                    {{ date('M, d Y', strtotime($user->loyaltyRecord->next_loyalty)) }}
                    | {{ \Carbon\Carbon::parse($user->loyaltyRecord->next_loyalty)->diffForHumans() }}
                @else
                    -
                @endif
            </p>
        </div>
        <div class="col-11 col-lg m-1 bg-success bg-gradient text-white rounded">
            <div class="row m-2">
                <div class="col">
                    {{-- <button class="btn btn-outline-light w-100">File Application For Leave</button> --}}
                </div>
            </div>
            <div class="row m-2">
                <div class="col">
                    <a target="_blank" href="{{ route('hr.service.edit', Auth::user()->id) }}"
                        class="btn btn-outline-light w-100" title="Print Service Record"><i
                            class="fa-solid fa-print"></i>Print Service Record</a>
                </div>
            </div>
        </div>
    </div>
@endsection
