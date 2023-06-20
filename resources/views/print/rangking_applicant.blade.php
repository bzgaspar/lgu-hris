@extends('layouts.print2')

@section('title', 'Service Record')
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

    {{-- <page size="A4" layout="landscape"> --}}
    <page size="A4">
        <center class="pt-3 m-3">
            <div class="row">
                <div class="col">
                    <img src="{{ asset('images/DA-logo.png') }}" alt="" width="60px" height="60px"><br>
                    REPUBLIC OF THE PHILIPPINES <br>
                    Province of Isabele <br>
                    <strong>MUNICIPALITY OF DELFIN ALBANO</strong> <br>
                    <strong class="fw-bold text-uppercase">municipal human resourse Management Office</strong>
                </div>
            </div>
            <br>

            <div class="table-responsive" id="no-more-tables">
                <table class="table table-hover table-striped smnall table-sm text-center">
                    <thead>
                        <tr class="table-light">
                            <th class="numeric" width="10%">Rank</th>
                            <th class="numeric">Applicant Name</th>
                            <th class="numeric">Total Points</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @forelse ($ranking as $item)
                            {{ dd($item) }}
                        @empty
                            <td colspan="4">No Applicants</td>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                </div>
            </div>

        </center>
    </page>

@endsection
