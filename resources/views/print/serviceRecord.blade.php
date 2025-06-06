@extends('layouts.print2')

@section('title', 'Service Record')
@section('customCSS')

    <style>
        center .contents * {
            font-size: 11px;
        }

        .row .col {
            padding: 0 !important;
        }

        .table td,
        .table th {
            font-size: 11px;
            padding: 3px;
        }
    </style>

@endsection
@section('content')

    <page size="A4">

        <center class="m-3 pt-3">
            <div class="row">
                <div class="col">
                    <img src="{{ asset('images/DA-logo.png') }}" alt="" width="60px" height="60px"><br>
                    Republic of the Philippines <br>
                    Province of Isabela <br>
                    <strong>MUNICIPALITY OF DELFIN ALBANO</strong>
                </div>
            </div>
            <br>
            <p class="text-center text-decoration-underline fs-5 text-uppercase mt-2"><strong>service record</strong></p>
            </div>
            <div class="contents">
                <div class="row" style="padding: 0 !important">
                    <div class="col-7">
                        <div class="row" style="padding: 0 !important">
                            <div style="padding: 0 !important" class="col-2">Name: </div>
                            <div style="padding: 0 !important" class="col border-bottom">{{ $user->last_name }}</div>
                            <div style="padding: 0 !important" class="col border-bottom">{{ $user->first_name }}</div>
                            @if ($user->pdsPersonal)
                                <div style="padding: 0 !important" class="col border-bottom">
                                    {{ $user->pdsPersonal->ext_name }}
                                </div>
                                <div style="padding: 0 !important" class="col border-bottom">
                                    {{ $user->pdsPersonal->middle_name }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        (if Married, give also full mainden name)
                    </div>
                </div>
                <div class="row">
                    <div class="col-7">
                        <div class="row ">
                            <div class="col-2"></div>
                            <div class="col">Last Name</div>
                            <div class="col">First Name</div>
                            <div class="col">Middle Name</div>
                        </div>
                    </div>
                    <div class="col">
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-4">
                        <div class="row">
                            <div style="padding: 0 !important" class="col-4">Birth: </div>
                            <div style="padding: 0 !important" class="col text-start border-bottom">
                                @if ($user->pdsPersonal)
                                    {{ date('M, d Y', strtotime($user->pdsPersonal->date_birth)) }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-7">
                        (Date herewith should be checked with birth or baptismal certificate or some other reliable
                        documents)
                    </div>
                </div>
                <br>

                <div class="row mx-2 text-start">
                    <div class="col">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; This is to certify that the employee named herein above
                        actually rendered service in the office as
                        shown by service record below, each line of which is supported by appointment and other papers
                        actually issued by this office and approved by the authorities concerned:
                    </div>
                </div>
                <table class="table table-bordered table-sm text-center mt-3">
                    <thead>
                        <tr class="text-uppercase table-warning">
                            <th colspan="2">inclusive dates</th>
                            <th colspan="3">record of appointment</th>
                            <th colspan="3"> office / entity</th>
                            <th colspan="2">Separation</th>
                        </tr>
                        <tr class="text-uppercase">
                            <th>from</th>
                            <th>to</th>
                            <th>designation</th>
                            <th>status</th>
                            <th>salary</th>
                            <th>station/place</th>
                            <th>branch</th>
                            <th>l/v abs w/o pay</th>
                            <th>date</th>
                            <th>cause</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user->serviceRecord as $item)
                            <tr>
                                <td>{{ date('m/d/Y', strtotime($item->from)) }}</td>
                                <td>
                                    @if ($item->to == 'PRESENT')
                                        PRESENT
                                        @else
                                        {{ date('m/d/Y', strtotime($item->to)) }}
                                    @endif
                                </td>
                                <td>
                                    @if ($item->empPlantilla)
                                        {{ $item->empPlantilla->EPposition }}
                                    @else
                                        {{ $item->designation }}
                                    @endif
                                </td>
                                <td>{{ $item->status }}</td>
                                <td>{{ number_format($item->salary, 2, '.', ',') }}</td>
                                <td colspan="2">{{ $item->station }}</td>
                                <td>
                                    @if ($item->wo_pay)
                                        {{ $item->wo_pay }}
                                    @else
                                        None
                                    @endif
                                </td>
                                <td>
                                    @if ($item->date)
                                        {{ $item->date }}
                                    @else
                                        None
                                    @endif
                                </td>
                                <td>{{ $item->cause }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">No records yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="row mx-2 text-start">
                    <div class="col">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Issued in compliance with executive orderNumber 54, dated August 10, 1954 and in accordance with
                        Circular Number 58 date August 10, 1958 of the system.
                    </div>
                </div>
                <br>
                <br>
                <br>
                <div class="row mx-2 text-start">
                    <div class="col"><span contenteditable="true"> Date: </span></div>
                </div>
                <div class="row mx-2 text-start">
                    <div class="col"></div>
                    <div class="col text-end text-uppercase">Certified Correct:</div>
                    <div class="col"></div>
                </div>
                <br>
                <br>
                <div class="row mx-2 text-start">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col text-center text-uppercase border-bottom fw-bold">ERLIEGY a. butay mpa</div>
                </div>
                <div class="row mx-2 text-start">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col text-center">Mun. Gov't. Dept. Head I (MHRMO)</div>
                </div>
            </div>
        </center>

    </page>
@endsection
