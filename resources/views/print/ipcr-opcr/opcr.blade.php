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
            <h4 class="text-center">OFFICE PERFORMANCE COMMITMENT AND REVIEW (OPCR)</h4>
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
                    <td class="text-start"><b><u>{{ $ipcr->user->first_name }} @if ($ipcr->user->pdsPersonal)
                                    {{ substr($ipcr->user->pdsPersonal->middle_name, 0, 1) }}.
                                @endif {{ $ipcr->user->last_name }}</u></b>
                    </td>
                </tr>
                <tr class="mt-0 pt-0">
                    <td></td>
                    <td class="text-start">
                        {{ $ipcr->user->empPlantilla->EPposition }}
                    </td>
                </tr>
                <tr class="mt-0 pt-0">
                    <td contenteditable="true"></td>
                    <td>
                        Date: <b contenteditable="true"><u>{{ date('F d, Y', strtotime($ipcr->created_at)) }}</u></b>
                    </td>
                </tr>
                <tr>
                    <td class="text-end" contenteditable="true"></td>
                    <td>
                        <div class="mb-0 mt-3">Approved:</div>
                        <p class="mb-0 fw-bold mt-5">ARNOLD EDWARD P. CO</p>
                        <p contenteditable="true" class="text-center">Municipal Mayor</p>
                    </td>
                </tr>
            </table>
            <img src="{{ asset('images/ipcr-table/ipcr-opcr.png') }}" alt="" class="w-100"
                style="mix-blend-mode: darken">
            <table class="table table-bordered border-1 border-dark mb-0">
                <tr class="h-1 bg-warning border-dark">
                    <th width="15%">MFO/PAP</th>
                    <th width="15%">SUCCESS INDICATORS (TARGETS + MEASURES)</th>
                    <th width="5%">Allotted Budget</th>
                    <th width="5%">Individual/ Department Accountable</th>
                    <th width="15%">Actual Accomplishments</th>
                    <th width="12%" colspan="4">Rating</th>
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
                        <td class="bg-success border-dark" colspan="10">{{ $types[$i] }}</td>
                    </tr>
                    @foreach ($ipcr->ipcr_forms_details as $ipcr_item)
                        {{-- {{ dd($loop->iteration - 1) }} --}}
                        @if ($types[$i] === $ipcr_item->ipcr_mfo->type)
                            <tr class="fw-bold" style="white-space: pre-line;">
                                <td style="text-indent: 15px;">
                                    @if ($ipcr_item->ipcr_mfo)
                                        {{ $ipcr_item->ipcr_mfo->question }}
                                    @endif
                                </td>

                                <td>
                                    @if ($ipcr_item->ipcr_Questions)
                                        {{ $ipcr_item->ipcr_Questions->question }}
                                    @endif
                                </td>
                                <td class="text-center">{{ $ipcr_item->ans1 }}</td>
                                <td class="text-center">{{ $ipcr_item->ans2 }}</td>
                                <td class="text-center">{{ $ipcr_item->ans3 }}</td>
                                <td class="text-center">{{ $ipcr_item->rate1 }}</td>
                                <td class="text-center">{{ $ipcr_item->rate2 }}</td>
                                <td class="text-center">{{ $ipcr_item->rate3 }}</td>
                                <td class="text-center"> <?php $total += $ipcr_item->rate4;
                                $count++;
                                $individual[] = $ipcr_item->rate4; ?> {{ $ipcr_item->rate4 }}</td>
                                <td class="text-center">{{ $ipcr_item->remarks }}</td>
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
                    <td class="fw-bold">Total Overall Rating</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="fw-bold text-end">{{ $sum_total }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Final Average Rating</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="fw-bold text-end"> <?php $final_average = 0; ?>
                        @if ($sum_count > 0)
                            {{ number_format($final_average = $sum_total / $sum_count, 5) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Total Overall Rating</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="fw-bold text-end">
                        @if ($final_average > 0)
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
                    <td>
                        <p>&nbsp;</p>
                        <p contenteditable="true" class="mt-5 mb-0 text-center">
                            <b>{{ $ipcr->user->first_name }} @if ($ipcr->user->pdsPersonal)
                                    {{ substr($ipcr->user->pdsPersonal->middle_name, 0, 1) }}.
                                @endif {{ $ipcr->user->last_name }}</b>
                        </p>
                    </td>
                    <td contenteditable="true" class="text-center fw-bold align-bottom"></td>
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
                    <td contenteditable="true" class="text-center fw-bold align-bottom"></td>
                    <td contenteditable="true">
                        <p contenteditable="true">&nbsp;</p>
                        <p class="mt-5 mb-0 text-center">
                            <b>ARNOLD EDWARD P. CO</b>
                        </p>
                    </td>
                    <td contenteditable="true" class="text-center fw-bold align-bottom"></td>
                </tr>
                <tr>
                    <td contenteditable="true" class="text-center">Ratee</td>
                    <td contenteditable="true">Date</td>
                    <td contenteditable="true" class="text-center">Department Head</td>
                    <td contenteditable="true">Date</td>
                    <td contenteditable="true" class="text-center">Municipal Mayor</td>
                    <td contenteditable="true">Date</td>
                </tr>
            </table>
        </div>
    </page>

@endsection
