@extends('layouts.leave_card')

@section('title', 'All Applicants')
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

        {{-- <center class="pt-3 m-3">
            <div class="row">
                <div class="col">
                    <img src="{{ asset('images/DA-logo.png') }}" alt="" width="60px" height="60px"><br>
                    REPUBLIC OF THE PHILIPPINES <br>
                    Province of Isabele <br>
                    <strong>MUNICIPALITY OF DELFIN ALBANO</strong>
                </div>
            </div>
            <br>
            <p class="text-center text-decoration-underline fs-5 text-uppercase mt-2"><strong>service record</strong></p>
            </div>

        </center> --}}
        <center class="pt-4">
            <strong>
                <h5>LIST OF APPLICANTS FOR PERMANENT POSITION {{ date('m/Y', strtotime(now())) }}</h5>
                <h5>LGU-Delfin Albano, Isabla</h5>
            </strong>
        </center>
        <div class="mx-4">

            <table class="table table-bordered table-sm ">
                <thead>
                    <tr class="text-center">
                        <th>Date</th>
                        <th>Position Applied</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Educational Attainment</th>
                        <th>Eligibility</th>
                        <th>Training</th>
                        <th>Experience</th>
                        <th>Etnicity</th>
                        <th>Disability</th>
                        <th>Civil Status</th>
                        <th>Religion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($all_users as $item)
                        <tr>
                            <td class="ps-2">
                                @if ($item->application)
                                    {{ date('m/d/Y', strtotime($item->application[0]->created_at)) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="ps-2">
                                @if ($item->application)
                                    {{ $item->application[0]->publication->title }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="ps-2">
                                @if ($item->application)
                                    {{ $item->first_name }}
                                    @if ($item->pdsPersonal)
                                        {{ $item->pdsPersonal->middle_name }}
                                    @endif
                                    {{ $item->last_name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="ps-2">
                                @if ($item->application)
                                    {{ $item->first_name }}
                                    @if ($item->pdsPersonal)
                                        {{ $item->pdsPersonal->barangay }}
                                        {{ $item->pdsPersonal->city }}
                                        {{ $item->pdsPersonal->province }}
                                    @endif
                                    {{ $item->last_name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="ps-2">
                                @if ($item->EducCollege && $item->EducCollege->count() > 0)
                                    {{ $item->EducCollege[0]->EDBEDC }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="ps-2">
                                @if ($item->pdsCivilService && $item->pdsCivilService->count() > 0)
                                    {{ $item->pdsCivilService[0]->CSCareer }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="ps-2">
                                @if ($item->pdsLearningDevelopment && $item->pdsLearningDevelopment->count() > 0)
                                    <?php $total = 0; ?>
                                    @foreach ($item->pdsLearningDevelopment as $data)
                                        <?php $total += $data->LDnumhour; ?>
                                    @endforeach
                                    {{ $total }} hrs
                                @else
                                    -
                                @endif
                            </td>
                            <td class="ps-2">
                                @if ($item->pdsWorkExperience && $item->pdsWorkExperience->count() > 0)
                                    @foreach (collect($item->pdsWorkExperience)->sortByDesc('WEidfrom') as $exp)
                                        @if ($loop->iteration === 1)
                                            {{ $exp->WEpostit }}
                                        @endif
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td class="ps-2">
                                @if ($item->pdsOther)
                                    @if ($item->pdsOther->Q40a)
                                        No
                                    @else
                                        Yes
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td class="ps-2">
                                @if ($item->pdsOther)
                                    @if ($item->pdsOther->Q40b)
                                        No
                                    @else
                                        Yes
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td class="ps-2">
                                @if ($item->pdsPersonal)
                                    {{ $item->pdsPersonal->civil_service }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="ps-2">
                                @if ($item->pdsOther)
                                    {{ $item->pdsOther->IDc1 }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </page>
@endsection
