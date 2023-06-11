@extends('layouts.leave_card')

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

    <page size="Legal" layout="landscape">
        <center class="pt-3 m-3">
            <div class="row">
                <div class="col">
                    <img src="{{ asset('images/DA-logo.png') }}" alt="" width="60px" height="60px"><br>
                    REPUBLIC OF THE PHILIPPINES <br>
                    Province of Isabele <br>
                    <strong>MUNICIPALITY OF DELFIN ALBANO</strong> <br>
                    <strong class="fw-bold text-uppercase">municipal human resourse Management Office</strong> <br>
                    <strong class="h3 fw-bold text-uppercase">EMPLOYEE'S LEAVE CARD</strong>
                </div>
            </div>
            <br>
            <table class="table table-borderless text-center">
                <tr>
                    <td>Name: <strong>{{ $user->first_name }} {{ $user->pdsPersonal->middle_name }}
                            {{ $user->last_name }}</strong></td>
                    <td>Position: <strong>
                            @if ($user->empPlantilla)
                                {{ $user->empPlantilla->EPposition }}
                            @endif
                        </strong></td>
                    <td>Department: <strong>
                            @if ($user->empPlantilla)
                                {{ $user->empPlantilla->department->name }}
                            @endif
                        </strong></td>
                    <td>Appoitment Date: <strong>
                            @if ($user->serviceRecord)
                                @if ($user->serviceRecord->first())
                                    {{ $user->serviceRecord->first()->from }}
                                @endif
                            @endif
                        </strong></td>
                </tr>
            </table>

            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th colspan="2">Period</th>
                        <th>Particulars</th>
                        <th colspan="4">Vacation Leave</th>
                        <th colspan="4">Sick Leave</th>
                        <th>Remarks</th>
                    </tr>
                    <tr>
                        <th width="7%">From</th>
                        <th width="7%">to</th>
                        <th width="15%"></th>
                        <th width="7%">Earned</th>
                        <th width="7%">Absence Undertime with Pay</th>
                        <th width="7%">Balance</th>
                        <th width="7%">Absence Undertime with Pay</th>
                        <th width="7%">Earned</th>
                        <th width="7%">Absence Undertime with Pay</th>
                        <th width="7%">Balance</th>
                        <th width="7%">Absence Undertime with Pay</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($user->leaveCard as $item)
                        <tr>
                            <td>{{ $item->elc_period_from }}</td>
                            <td>{{ $item->elc_period_to }}</td>
                            <td>{{ $item->elc_particular }}</td>
                            <td>{{ $item->elc_vl_earned }}</td>
                            <td>{{ $item->elc_vl_auw_p }}</td>
                            <td>{{ $total_vl = $item->elc_vl_balance }}</td>
                            <td>{{ $item->elc_vl_auwo_p }}</td>
                            <td>{{ $item->elc_sl_earned }}</td>
                            <td>{{ $item->elc_sl_auw_p }}</td>
                            <td>{{ $total_sl = $item->elc_sl_balance }}</td>
                            <td>{{ $item->elc_sl_auwo_p }}</td>
                            <td>{{ $item->elc_remarks }}</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>

        </center>
        <div class="row mx-5">
            <div class="col">
                <p class="mb-0">Total Vacation Leave: <span class="fw-bold">{{ $total_vl }}</span></p>
                <p class="mb-0">Total Sick Leave: <span class="fw-bold">{{ $total_sl }}</span></p>
                <p class="mb-0">Total Leave Credit: <span class="fw-bold">{{ $D = $total_sl + $total_vl }}</span></p>
            </div>
            <div class="col">
                <?php
                $TLB = App\Http\Controllers\HomeController::getTBL(Auth::user()->id, $total_sl + $total_vl);

                $S = App\Http\Controllers\HomeController::getHighest_salary(Auth::user()->id); ?>
                <p class="mb-0">TLB = S x D x CF</p>
                <p class="mb-0">TLB =
                    <span class="fw-bold">{{ $S }}</span>
                    x
                    <span class="fw-bold">{{ $D }}</span>
                    x
                    <span class="fw-bold">{{ 0.0481927 }}</span>
                </p>
                <p class="mb-0">TLB = <span class="fw-bold">₱ {{ $TLB }}</span></p>
            </div>
            <div class="col">
                <table class="table table-bordered p-1">
                    <tr>
                        <td>TLB</td>
                        <td>=</td>
                        <td>Terminal Leave Benefits</td>
                    </tr>
                    <tr>
                        <td>S</td>
                        <td>=</td>
                        <td>Highest Monthly Salary Received</td>
                    </tr>
                    <tr>
                        <td>D</td>
                        <td>=</td>
                        <td>No. of accumulated vacation and sick leave credits</td>
                    </tr>
                    <tr>
                        <td>CF</td>
                        <td>=</td>
                        <td>Constant Factor which is 0.0481927</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-4 text-center">
                <p class="float-start">
                    Perpared By:
                </p> <br><br><br><br>
                <?php $user_info = App\Http\Controllers\HomeController::getFullName($user->id); ?>
                <p class="fw-bold mb-0 border-bottom" style="text-indent: 5px">
                    {{ $user_info['full_name'] }}
                </p>
                <p class="fw-bold" style="text-indent: 5px">
                    {{ $user_info['position'] }}
                </p>
            </div>
            <div class="col-8 text-center">
                <br>
                <div class="row mx-2 text-start">
                    <div class="col"></div>
                    <div class="col text-end">Certified Correct:</div>
                    <div class="col"></div>
                </div>
                <br>
                <br>
                <br>
                <div class="row mx-2 text-start">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col text-center text-uppercase border-bottom fw-bold">ERLIEGY a. butay, mpa</div>
                </div>
                <div class="row mx-2 text-start">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col text-center">Mun. Gov't. Dept. HEAD I (MHRMO)</div>
                </div>
            </div>
        </div>

    </page>

@endsection
