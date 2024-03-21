@extends('layouts.leave_card')

@section('title', 'Service Record')
@section('customCSS')

    <style>
        center .contents * {}

        .row .col {
            padding: 0 !important;
        }

        .table {
            page-break-before: auto;
        }

        .table td,
        .table th {
            font-size: 14px;
            padding: 0;
        }

        .b {
            font-size: 14px
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
                Ranking Scores for {{ $publication->title }}</h4>


        </center>
        <div class="row g-0 gy-0 justify-content-center">
            <div class="col-11 m-0 p-0">
                <div class="container-fluid">
                    @forelse ($ranking as $item)
                        @if ($loop->iteration < 10)
                            <?php $over_all = 0; ?>
                            <h5 class="mx-auto mt-4">{{ $loop->iteration }}. {{ $item['name'] }}</h5>
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
                                @if (count($item) > 0)
                                    
                                @for ($i = 0; $i < count($item['additional_points_raters']); $i++)
                                    <tr>
                                        <?php $sum = 0; ?>
                                        <td class="bg-secondary text-white fw-bold">{{ $i + 1 }}</td>
                                        @if ($item['additional_points_raters'])
                                            <td>
                                                {{ $score = round($item['additional_points_raters'][$i]['experience'] * 0.15, 2) }}

                                                <?php $sum += $score; ?>
                                            </td>
                                            <td>
                                                {{ $score = round($item['additional_points_raters'][$i]['education'] * 0.15, 2) }}
                                                <?php $sum += $score; ?>
                                            </td>
                                            <td>
                                                {{ $score = round($item['additional_points_raters'][$i]['eligibility'] * 0.1, 2) }}
                                                <?php $sum += $score; ?>
                                            </td>
                                        @else
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        @endif
                                        @if ($item['interview_exam_raters'])
                                            <td>
                                                {{ $score = round($item['interview_exam_raters'][$i]['written_exam'] * 0.1, 2) }}
                                                <?php $sum += $score; ?>
                                            </td>
                                            <td>
                                                {{ $score = round($item['interview_exam_raters'][$i]['oral_exam'] * 0.1, 2) }}
                                                <?php $sum += $score; ?>
                                            </td>
                                            <td>
                                                {{ $score = round($item['interview_exam_raters'][$i]['background'] * 0.1, 2) }}
                                                <?php $sum += $score; ?>
                                            </td>
                                            <td>
                                                {{ $score = round($item['interview_exam_raters'][$i]['performance'] * 0.1, 2) }}
                                                <?php $sum += $score; ?>
                                            </td>
                                            <td>
                                                {{ $score = round($item['interview_exam_raters'][$i]['pspt'] * 0.1, 2) }}
                                                <?php $sum += $score; ?>
                                            </td>
                                            <td>
                                                {{ $score = round($item['interview_exam_raters'][$i]['potential'] * 0.1, 2) }}
                                                <?php $sum += $score; ?>
                                            </td>
                                            <td>{{ $sum }}</td>
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
                                @endif
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
                       @else{
                        <p class="text-center">No rates yet</p>
                       }
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

                        @foreach ($hrmpsb as $item)
                            <div class="col text-center" contenteditable="true">
                                <b class="border-bottom" contenteditable="true">
                                    <?php $name = App\Http\Controllers\HomeController::getFullName($item->user_id); ?>
                                    {{ $name['full_name'] }}
                                </b>
                                <br>
                                {{ $item->position }}
                            </div>
                        @endforeach
                        {{-- <div class="col text-center">
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
                            Administrative Officer IV (HRMO II)
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </page>

@endsection
