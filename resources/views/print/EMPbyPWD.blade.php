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
                <p class="mb-0">PWD / Single Parent / Indigenous</p>
            </strong>
        </center>
        <div class="mx-4 mt-5">
            <table class="table table-bordered table-sm ">
                <thead>
                    <tr class="text-center">
                        <th width="70%">Deparmtent</th>
                        <th width="10%">PWD</th>
                        <th width="10%">Single Parent</th>
                        <th width="10%">Indigenous</th>
                        <th width="10%">Total</th>
                        {{-- <th width="20%">Designation</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <?php 
                            $total = 0;
                            $total_p = 0;
                            $total_s = 0;
                            $total_i = 0;
                             ?>
                    @forelse ($all_department as $dep)
                        <tr>
                            <td class="ps-2">
                                {{ $dep->name }}
                            </td>
                            <?php
                            $pwd_count = 0;
                            $sp_count = 0;
                            $id_count = 0;
                            foreach ($all_users as $user) {
                                if ($user->dep_id == $dep->id) {
                                    if ($user->pwd != true) {
                                        $pwd_count++;
                                    }
                                    if ($user->solo_parent != true) {
                                        $sp_count++;
                                    }
                                    if ($user->indigenous != true) {
                                        $id_count++;
                                    }
                                }
                            }
                            ?>

                            <td class="text-center">
                                <?php $total_p +=  $pwd_count ?>{{ $pwd_count }}</td>
                            <td class="text-center">
                                <?php $total_s +=  $sp_count ?>{{ $sp_count }}</td>
                            <td class="text-center">
                                <?php $total_i +=  $id_count ?>{{ $id_count }}</td>
                            <td class="text-center">
                                <?php $total += $pwd_count + $sp_count + $id_count ?>
                                {{ $pwd_count + $sp_count + $id_count }}</td>
                        </tr>
                    @empty
                    @endforelse
                    <tr class="fw-bold">
                        <td class="ps-2">Total</td>
                        <td class="text-center">{{$total_p}}</td>
                        <td class="text-center">{{$total_s}}</td>
                        <td class="text-center">{{$total_i}}</td>
                        <td class="text-center">{{$total}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </page>
@endsection
