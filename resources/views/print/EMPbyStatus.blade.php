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
                <p class="mb-0">Employment Status</p>
            </strong>
        </center>
        <div class="mx-4 mt-5">
            <table class="table table-bordered table-sm ">
                <thead>
                    <tr class="text-center">
                        <th width="40%">Deparmtent</th>
                        <th width="10%">Permanent</th>
                        <th width="10%">COS</th>
                        <th width="10%">Co-Terminus</th>
                        <th width="10%">Appointed</th>
                        <th width="10%">Elective</th>
                        <th width="10%">Total</th>
                        {{-- <th width="20%">Designation</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <?php 
                            $total = 0;
                            $total_p = 0;
                            $total_c = 0;
                            $total_ct = 0;
                            $total_a = 0;
                            $total_e = 0;
                             ?>
                    @forelse ($all_department as $dep)
                        <tr>
                            <td class="ps-2">
                                {{ $dep->name }}
                            </td>
                            <?php
                            $permanent_count = 0;
                            $cos_count = 0;
                            $ct_count = 0;
                            $appointed_count = 0;
                            $elective_count = 0;
                            foreach ($all_users as $user) {
                                if ($user->dep_id == $dep->id) {
                                    if ($user->status == 1) {
                                        $permanent_count++;
                                    }
                                    if ($user->status == 2) {
                                        $ct_count++;
                                    }
                                    if ($user->status == 3) {
                                        $cos_count++;
                                    }
                                    if ($user->status == 4) {
                                        $appointed_count++;
                                    }
                                    if ($user->status == 5) {
                                        $elective_count++;
                                    }
                                }
                            }
                            ?>

                            <td class="text-center">
                                <?php $total_p +=  $permanent_count ?>
                                {{ $permanent_count }}</td>
                            <td class="text-center">
                                <?php $total_c +=  $cos_count ?>
                                {{ $cos_count }}</td>
                            <td class="text-center">
                                <?php $total_ct +=  $ct_count ?>
                                {{ $ct_count }}</td>
                            <td class="text-center">
                                <?php $total_a +=  $appointed_count ?>
                                {{ $appointed_count }}</td>
                            <td class="text-center">
                                <?php $total_e +=  $elective_count ?>
                                {{ $elective_count }}</td>
                            <td class="text-center">
                                
                                <?php $total += $permanent_count + $cos_count + $ct_count+ $appointed_count+ $elective_count ?>
                                {{ $permanent_count + $cos_count + $ct_count+ $appointed_count+ $elective_count }}</td>
                        </tr>
                    @empty
                    @endforelse
                    <tr class="fw-bold">
                        <td class="ps-2">Total</td>
                        <td class="text-center">{{$total_p}}</td>
                        <td class="text-center">{{$total_c}}</td>
                        <td class="text-center">{{$total_ct}}</td>
                        <td class="text-center">{{$total_a}}</td>
                        <td class="text-center">{{$total_e}}</td>
                        <td class="text-center">{{$total}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </page>
@endsection
