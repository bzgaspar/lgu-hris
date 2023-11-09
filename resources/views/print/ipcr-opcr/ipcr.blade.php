@extends('layouts.leave_card')

@section('title', 'IPCR')
@section('customCSS')

    <style>
        center .contents * {}

        .row .col {
            padding: 0 !important;
        }

        .table td,
        .table th {
            font-size: 14px;
            padding: 1px;
        }
    </style>

@endsection
@section('content')

    <page size="Legal" layout="landscape">
        <div class="mx-5">
            <h4 class="text-center">INDIVIDUAL PERFORMANCE COMMITMENT AND REVIEW (IPCR)</h4>
            <p contenteditable="true" style="text-indent: 55px">I,
                <b><u>{{ $ipcr->user->first_name }} @if ($ipcr->user->pdsPersonal)
                            {{ substr($ipcr->user->pdsPersonal->middle_name, 0, 1) }}.
                        @endif {{ $ipcr->user->last_name }}</u></b>
                , @if ($ipcr->user->empPlantilla)
                    <b><u>{{ $ipcr->user->empPlantilla->EPposition }}</u></b>
                @endif , Municipal Government of
                Delfin Albano, Isabela, commit to deliver
                and agree to be rated on the f the following targets in accordance with the indicated measures for the
                period
                <b><u>{{ date('F', strtotime($ipcr->from)) }} -
                        {{ date('F', strtotime($ipcr->to)) }},
                        {{ date('Y', strtotime($ipcr->to)) }}</u></b>
            </p>
            <table class="w-100">
                <tr>
                    <td width="70%">&nbsp;</td>
                    <td class="text-center"><b><u>{{ $ipcr->user->first_name }} @if ($ipcr->user->pdsPersonal)
                                    {{ substr($ipcr->user->pdsPersonal->middle_name, 0, 1) }}.
                                @endif {{ $ipcr->user->last_name }}</u></b>
                    </td>
                </tr>
                <tr class="mt-0 pt-0">
                    <td></td>
                    <td class="text-center">
                        Ratee
                    </td>
                </tr>
                <tr class="mt-0 pt-0">
                    <td></td>
                    <td>
                        Date: <b><u>{{ date('F d, Y', strtotime($ipcr->created_at)) }}</u></b>
                    </td>
                </tr>
            </table>
            <table class="table table-bordered border-dark border-1 fw-bold mt-2">
                <tr>
                    <td width="40%">Reviewed by:</td>
                    <td width="10%"></td>
                    <td width="40%">Approved by:</td>
                    <td width="10%"></td>
                </tr>
                <tr heigth="200px">
                    <td class="text-center">
                        <p class="mt-4 mb-0" contenteditable="true">
                            <?php $dep_head = App\Http\Controllers\HomeController::getDepartmentHeadLeave($ipcr->user_id);
                            ?>
                            @if ($dep_head)
                                {{ $dep_head['full_name'] }}
                            @endif
                        </p>
                    </td>
                    <td></td>
                    <td class="text-center">
                        <p class="mt-4 mb-0" contenteditable="true">
                            ARNOLD EDWARD P. CO
                        </p>
                    </td>
                    <td></td>
                </tr>
                <td width="40%"></td>
                <td width="10%">Date</td>
                <td width="40%"></td>
                <td width="10%">Date</td>
            </table>
            <img src="{{ asset('images/ipcr-table/ipcr-opcr.png') }}" alt="" class="w-100"
                style="mix-blend-mode: darken">
            <table class="table table-bordered border-1 border-dark mb-0">
                <tr class="h-1 bg-warning border-dark">
                    <th width="26%">MFO/PAP</th>
                    <th width="26%">SUCCESS INDICATORS (TARGETS + MEASURES)</th>
                    <th width="26%">Actual Accomplishments</th>
                    <th colspan="4">Rating</th>
                    <th width="12%">Remarks</th>
                </tr>
                <?php
                $types = [];
                $summary = [];
                foreach ($ipcr->ipcr_forms_details as $value) {
                    if (!in_array($value->ipcr_mfo->type, $types)) {
                        $types[] = $value->ipcr_mfo->type;
                    }
                }
                ?>
                @for ($i = 0; $i < count($types); $i++)
                    <?php $total = 0;
                    $count = 0;
                    $individual = []; ?>
                    <tr class="fw-bold">
                        <td class="bg-success border-dark" colspan="8">{{ $types[$i] }}</td>
                    </tr>
                    @foreach ($ipcr->ipcr_forms_details as $ipcr_item)
                        {{-- {{ dd($loop->iteration - 1) }} --}}
                        @if ($types[$i] === $ipcr_item->ipcr_mfo->type)
                            <tr class="fw-bold" style="white-space: pre-line;">
                                <td style="text-indent: 15px;">{{ $ipcr_item->ipcr_mfo->question }}</td>
                                <td>{{ $ipcr_item->ipcr_Questions->question }}</td>
                                <td class="text-center">{{ $ipcr_item->ans1 }}</td>
                                <td class="text-center">{{ $ipcr_item->rate1 }}</td>
                                <td class="text-center">{{ $ipcr_item->rate2 }}</td>
                                <td class="text-center">{{ $ipcr_item->rate3 }}</td>
                                <td class="text-center"> <?php $total += $ipcr_item->rate4;
                                $count++;
                                $individual[] = $ipcr_item->rate4; ?> {{ $ipcr_item->rate4 }}</td>
                                <td>{{ $ipcr_item->remarks }}</td>
                            </tr>
                        @endif
                    @endforeach
                    <?php $summary[$types[$i]] = [
                        'total' => $total,
                        'count' => $count,
                        'average' => $total / $count,
                        'individual' => $individual,
                    ]; ?>
                @endfor
            </table>
            <table class="table table-bordered mt-0 border-1 border-dark">
                <tr>
                    <th width="26%">Category</th>
                    <th width="10%">No. of activities</th>
                    <th width="32%">Rating</th>
                    <th width="32%">Rating</th>
                </tr>
                <?php $sum_total = 0;
                $sum_count = 0; ?>
                @foreach ($types as $type)
                    <tr>
                        <td>MFO {{ $loop->iteration }}</td>
                        <td class="text-center">{{ $summary[$type]['count'] }}</td>
                        <td class="text-center">
                            {{-- @if ($summary[$type]['count'] !== 1) --}}
                            @foreach ($summary[$type]['individual'] as $individual)
                                {{ $individual }}
                                @if ($loop->iteration < count($summary[$type]['individual']))
                                    +
                                @endif
                            @endforeach
                            = {{ $summary[$type]['total'] }} / {{ $summary[$type]['count'] }}
                            {{-- @endif --}}
                        </td>
                        <td class="text-end fw-bold "><?php $sum_total += $summary[$type]['average'];
                        $sum_count++; ?>{{ $summary[$type]['average'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Total Overall Rating</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="fw-bold text-end">{{ $sum_total }}</td>
                </tr>
                <tr>
                    <td>Final Average Rating</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="fw-bold text-end">{{ number_format($final_average = $sum_total / $sum_count, 2) }}</td>
                </tr>
                <tr>
                    <td>Total Overall Rating</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="fw-bold text-end">
                        @if ($final_average >= 5)
                            Outstanding
                        @elseif ($final_average >= 4.0 && $final_average <= 5)
                            Very Satisfactory
                        @elseif ($final_average >= 3.0 && $final_average <= 3.99)
                            Satisfactory
                        @elseif ($final_average >= 2.0 && $final_average <= 2.99)
                            Unsatisfactory
                        @elseif ($final_average >= 1.0 && $final_average <= 1.99)
                            Poor
                        @endif
                    </td>
                </tr>
            </table>
            <h3 class="mt-4">
                COMMENTS AND RECOMMENDATIONS FOR DEVELOPMENT PURPOSES:
                <p class="border" contenteditable="true" style="height: 50px;font-size: 14px"></p>
            </h3>
            <table class="table table-bordered border-dark border-1">
                <tr>
                    <th width="24%">Discussed with:</th>
                    <td width="9%"></td>
                    <th width="24%">Reviewed by:</th>
                    <td width="9%"></td>
                    <th width="24%">Final Rating by:</th>
                    <td width="9%"></td>
                </tr>
                <tr>
                    <td class="text-center fw-bold align-bottom">
                        <p>&nbsp;</p>
                        <p class="mt-5 mb-0 text-center">
                            <b>{{ $ipcr->user->first_name }} @if ($ipcr->user->pdsPersonal)
                                    {{ substr($ipcr->user->pdsPersonal->middle_name, 0, 1) }}.
                                @endif {{ $ipcr->user->last_name }}</b>
                        </p>
                    </td>
                    <td class="text-center fw-bold align-bottom"></td>
                    <td>
                        <p style="font-size: 12px" class="mb-4 mt-0">
                            I certify that I discussed my assessment of the performance with the employee.</p>
                        <p class="mt-4 fw-bold text-center mb-0" contenteditable="true">
                            <?php $dep_head = App\Http\Controllers\HomeController::getDepartmentHeadLeave($ipcr->user_id);
                            ?>
                            @if ($dep_head)
                                {{ $dep_head['full_name'] }}
                            @endif
                        </p>
                    </td>
                    <td class="text-center fw-bold align-bottom"></td>
                    <td>
                        <p>&nbsp;</p>
                        <p class="mt-5 mb-0 text-center">
                            <b>ARNOLD EDWARD P. CO</b>
                        </p>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-center">Ratee</td>
                    <td contenteditable="true">Date</td>
                    <td class="text-center">Department Head</td>
                    <td contenteditable="true">Date</td>
                    <td class="text-center">Municipal Mayor</td>
                    <td contenteditable="true">Date</td>
                </tr>
            </table>
        </div>
    </page>

@endsection
