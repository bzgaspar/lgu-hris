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

        <center class="">
            <strong>
                <img src="{{ asset('images/DA-logo.png') }}" alt="" width="60px" height="60px"><br>
                <h5>Employee of LGU Personnel FY {{ date('Y', strtotime(now())) }}</h5>
                <h5>Delfin Albano, Isabla</h5>
                <p class="mb-0">Covid 19 Response</p>
            </strong>
        </center>
        <div class="mx-4 mt-5">
            <table class="table table-bordered table-sm ">
                <thead>
                    <tr class="text-center">
                        <th width="40%">Deparmtent</th>
                        <th width="10%">1st Dose</th>
                        <th width="10%">2nd Dose</th>
                        <th width="10%">1st Booster</th>
                        <th width="10%">2nd Booster</th>
                        <th width="10%">Total</th>
                        {{-- <th width="20%">Designation</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <?php 
                            $total = 0;
                            $total_1 = 0;
                            $total_2 = 0;
                            $total_3 = 0;
                            $total_4 = 0;
                             ?>
                    @forelse ($all_department as $dep)
                        <tr>
                            <td class="ps-2">
                                {{ $dep->name }}
                            </td>
                            <?php
                            $first_count = 0;
                            $second_count = 0;
                            $third_count = 0;
                            $fourth_count = 0;
                            foreach ($all_users as $user) {
                                if ($user->dep_id == $dep->id) {
                                    if ($user->booster == 1) {
                                        $first_count++;
                                    }
                                    if ($user->booster == 2) {
                                        $second_count++;
                                    }
                                    if ($user->booster == 3) {
                                        $third_count++;
                                    }
                                    if ($user->booster == 4) {
                                        $fourth_count++;
                                    }
                                }
                            }
                            ?>

                            <td class="text-center">
                                <?php $total_1 +=  $first_count ?>
                                {{ $first_count }}</td>
                            <td class="text-center">
                                <?php $total_2 +=  $second_count ?>
                                {{ $second_count }}</td>
                            <td class="text-center">
                                <?php $total_3 +=  $third_count ?>
                                {{ $third_count }}</td>
                            <td class="text-center">
                                <?php $total_4 +=  $fourth_count ?>
                                {{ $fourth_count }}</td>
                            <td class="text-center">
                                <?php $total += $first_count + $second_count + $third_count + $fourth_count ?>
                                {{ $first_count + $second_count + $third_count + $fourth_count }}</td>
                        </tr>
                    @empty
                    @endforelse
                    <tr class="fw-bold">
                        <td class="ps-2">Total</td>
                        <td class="text-center">{{$total_1}}</td>
                        <td class="text-center">{{$total_2}}</td>
                        <td class="text-center">{{$total_3}}</td>
                        <td class="text-center">{{$total_4}}</td>
                        <td class="text-center">{{$total}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </page>
@endsection
