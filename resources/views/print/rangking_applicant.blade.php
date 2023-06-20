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
            font-size: 10px;
            padding: 0;
        }

        .b {
            font-size: 12px
        }
    </style>

@endsection
@section('content')

    <page size="A4" layout="landscape">
        <center class="pt-3 m-3">
            <div class="row">
                <div class="col">
                    <img src="{{ asset('images/DA-logo.png') }}" alt="" width="60px" height="60px"><br>
                    REPUBLIC OF THE PHILIPPINES <br>
                    Province of Isabela <br>
                    <strong>MUNICIPALITY OF DELFIN ALBANO</strong> <br>
                    <strong class="fw-bold text-uppercase">municipal human resourse Management Office</strong>
                </div>
            </div>
            <h4 class="mt-2 mb-0 fw-bold float-left">
                {{ $publication->title }}</h4>


        </center>
        <div class="row g-0 gy-0 justify-content-center">
            <div class="col-11 m-0 p-0">
                <div class="container-fluid">
                    @forelse ($ranking as $item)
                        @if ($loop->iteration < 10)
                            <?php $over_all = 0; ?>
                            <h5 class="mx-auto mt-3">{{ $item['name'] }}</h5>
                            <table class="table table-bordered text-center small">
                                <tr>
                                    <th class="bg-secondary text-white">HRMPSB</th>
                                    <th>EXPERIENCE 15%</th>
                                    <th>EDUCATION 15%</th>
                                    <th>ELIGIBILITY 10%</th>
                                    <th>WRITTEN EXAM 10%</th>
                                    <th>ORAL EXAM 10%</th>
                                    <th>BACKGROUND 10%</th>
                                    <th>PEFORMANCE 10%</th>
                                    <th>PSPT 10%</th>
                                    <th>POTENTIAL 10%</th>
                                    <th>Total 100%</th>
                                </tr>
                                @for ($i = 0; $i < count($item['additional_points_raters']); $i++)
                                    <tr>
                                        <?php $sum = 0; ?>
                                        <td class="bg-secondary text-white fw-bold">{{ $i + 1 }}</td>
                                        @if ($item['additional_points_raters'])
                                            <td>
                                                <?php $sum += round($item['additional_points_raters'][$i]['experience'] * 0.15, 2); ?>
                                                {{ round($item['additional_points_raters'][$i]['experience'] * 0.15, 2) }}
                                            </td>
                                            <td>
                                                <?php $sum += round($item['additional_points_raters'][$i]['education'] * 0.15, 2); ?>
                                                {{ round($item['additional_points_raters'][$i]['education'] * 0.15, 2) }}
                                            </td>
                                            <td>
                                                <?php $sum += round($item['additional_points_raters'][$i]['eligibility'] * 0.1, 2); ?>
                                                {{ round($item['additional_points_raters'][$i]['eligibility'] * 0.1, 2) }}
                                            </td>
                                        @else
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        @endif
                                        @if ($item['interview_exam_raters'])
                                            <td>
                                                <?php $sum += round($item['interview_exam_raters'][$i]['written_exam'] * 0.1, 2); ?>
                                                {{ round($item['interview_exam_raters'][$i]['written_exam'] * 0.1, 2) }}
                                            </td>
                                            <td>
                                                <?php $sum += round($item['interview_exam_raters'][$i]['oral_exam'] * 0.1, 2); ?>
                                                {{ round($item['interview_exam_raters'][$i]['oral_exam'] * 0.1, 2) }}
                                            </td>
                                            <td>
                                                <?php $sum += round($item['interview_exam_raters'][$i]['background'] * 0.1, 2); ?>
                                                {{ round($item['interview_exam_raters'][$i]['background'] * 0.1, 2) }}
                                            </td>
                                            <td>
                                                <?php $sum += round($item['interview_exam_raters'][$i]['performance'] * 0.1, 2); ?>
                                                {{ round($item['interview_exam_raters'][$i]['performance'] * 0.1, 2) }}
                                            </td>
                                            <td>
                                                <?php $sum += round($item['interview_exam_raters'][$i]['pspt'] * 0.1, 2); ?>
                                                {{ round($item['interview_exam_raters'][$i]['pspt'] * 0.1, 2) }}
                                            </td>
                                            <td>
                                                <?php $sum += round($item['interview_exam_raters'][$i]['potential'] * 0.1, 2); ?>
                                                {{ round($item['interview_exam_raters'][$i]['potential'] * 0.1, 2) }}
                                            </td>
                                            <td>{{ round($sum, 2) }}</td>
                                        @else
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        @endif
                                    </tr>
                                    <?php
                                    $over_all += $sum;
                                    ?>
                                @endfor
                                <tr>
                                    <td colspan="10" class="bg-secondary text-white fw-bold text-end">Total</td>
                                    <td class="bg-secondary text-white fw-bold">
                                        @if ($over_all > 0)
                                            {{ round($over_all / count($item['additional_points_raters']), 2) }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                </tr>

                            </table>

                            <?php
                            $i++;
                            ?>
                        @endif
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-11">
                <div class="container-fluid">
                    <div class="row mt-5 mx-5">
                        <div class="col text-center">
                            <b class="border-bottom">ERLIEGY A. BUTAY, MPA</b> <br>
                            MGDH I (MHRMO)
                        </div>
                        <div class="col text-center">
                            <b class="border-bottom">ROSALIE L. MARQUEZ, RSW</b> <br>
                            GAD, Focal Person
                        </div>
                        <div class="col text-center">
                            <b class="border-bottom">HON. ALEX M. MACARILAY</b> <br>
                            Chair, Good Gov't, Public Ethics & Accountability
                        </div>
                        <div class="col text-center">
                            <b class="border-bottom">JOCELYN A. MANIBOG</b> <br>
                            Municipal Administrator-Designate
                        </div>
                        <div class="col text-center">
                            <b class="border-bottom">RHOMEL G. SALVADOR</b> <br>
                            Administrative Officer IV (MHRMO II)
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </page>

@endsection
