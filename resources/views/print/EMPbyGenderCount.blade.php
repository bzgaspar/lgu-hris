@extends('layouts.print2')

@section('title', 'Plantilla')
@section('customCSS')

    <style>
        center .contents * {}

        .row .col {
            padding: 0 !important;
        }

        .table td,
        .table th {
            font-size: 12px;
            padding: 0;
        }
    </style>

@endsection
@section('content')

    <page size="A4">

        {{-- <center class="pt-3 m-3">
            <div class="row">
                <div class="col">
                    <img src="{{ asset('images/DA-logo.png') }}" alt="" width="60px" height="60px"><br>
                    REPUBLIC OF THE PHILIPPINES <br>
                    Province of Isabele <br>
                    <strong>MUNICIPALITY OF DELFIN ALBANO</strong>
                </div>
            </div>
            <br>
            <p class="text-center text-decoration-underline fs-5 text-uppercase mt-2"><strong>service record</strong></p>
            </div>

        </center> --}}
        <center class="">
            <strong>
                <img src="{{ asset('images/DA-logo.png') }}" alt="" width="60px" height="60px"><br>
                <h5>Employee of LGU Personnel FY {{ date('Y', strtotime(now())) }}</h5>
                <h5>Delfin Albano, Isabla</h5>
                <p class="mb-0">Gender</p>
            </strong>
        </center>
        <div class="mx-4 mt-5">
            <table class="table table-bordered table-sm ">
                <thead>
                    <tr class="text-center">
                        <th width="70%">Deparmtent</th>
                        <th width="10%">Male</th>
                        <th width="10%">Female</th>
                        <th width="10%">Total</th>
                        {{-- <th width="20%">Designation</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <?php 
                            $total = 0;
                            $total_m = 0;
                            $total_f = 0;
                             ?>
                    @forelse ($all_department as $dep)
                        <tr>
                            <td class="ps-2">
                                {{ $dep->name }}
                            </td>
                            <?php
                            $male_count = 0;
                            $female_count = 0;
                            foreach ($all_users as $user) {
                                if ($user->dep_id == $dep->id) {
                                    if ($user->sex == 'male' || $user->sex == 'Male') {
                                        $male_count++;
                                    } elseif ($user->sex == 'female' || $user->sex == 'Female') {
                                        $female_count++;
                                    }
                                }
                            }
                            ?>

                            <td class="text-center">
                                <?php $total_m += $male_count ?>{{ $male_count }}</td>
                            <td class="text-center">
                                <?php $total_f +=  $female_count ?>
                                {{ $female_count }}</td>
                            <td class="text-center">
                                <?php $total += $male_count + $female_count ?>
                                {{ $male_count + $female_count }}</td>
                        </tr>
                    @empty
                    @endforelse
                    <tr class="fw-bold">
                        <td class="ps-2">Total</td>
                        <td class="text-center">{{$total_m}}</td>
                        <td class="text-center">{{$total_f}}</td>
                        <td class="text-center">{{$total}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </page>
@endsection
