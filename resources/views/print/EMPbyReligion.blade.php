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
                <p class="mb-0">Religion</p>
            </strong>
        </center>
        <div class="mx-4 mt-5">
            <table class="table table-bordered table-sm ">
                <thead>
                    <tr class="text-center">
                    <th>Religion</th>
                    <th>Count</th>
                    </tr>
                </thead>
                <tbody>

@forelse ($religions as $rel => $count)
<tr>
                            <td class="text-center">
                           {{$rel}}     </td>
                            <td class="text-center">
                                {{$count}}</td>
</tr>
@empty

@endforelse
                </tbody>
            </table>
        </div>
    </page>
@endsection
