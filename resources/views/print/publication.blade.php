@extends('layouts.print2')

@section('title', 'Publication')
@section('customCSS')

    <style>
        * {
            font-size: 12px
        }

        .row .col {
            padding: 0 !important;
        }

        .table td,
        .table th {
            font-size: 12px;
            padding: 0;
        }

        page {
            padding-right: 10px;
            padding-left: 10px;
        }
    </style>

@endsection
@section('content')


    {{-- @forelse ($all_publication as $item) --}}
    <page size="Legal" layout="landscape">
        {{-- <center class="pt-3 m-3"> --}}
        <div class="row">
            <div class="col-4 ms-2">
                CS Form No.9 <br class="mb-0">
                Series of 2017
            </div>
            <div class="col text-center">
                <img src="{{ asset('images/DA-logo.png') }}" alt="" width="60px" height="60px"><br>
                REPUBLIC OF THE PHILIPPINES <br>
                <strong>MGO DELFIN ALBANO (MAGSAYSAY), ISABELA</strong> <br>
                <strong class="fw-bold">Request for Publication of Vacant Position</strong>
            </div>
            <div class="col-4">
            </div>
        </div>
        <br>
        <p class="mb-0 ms-2">
            To: CIVIL SERVICE COMMISSION (CSC) <br>
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            This is to request the publication of the following vacant position of MGO DELFIN ALBANO (MAGSAYSAY), ISABELA in
            the CSC Website.
        </p>
        <br>
        <div class="row justify-content-end">
            <div class="col-4 text-center">
                Date: {{ date('F d, Y', strtotime(now())) }}
            </div>
        </div>
        <div class="mx-3">

            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Position Title</th>
                        <th rowspan="2">Plantilla Item No.</th>
                        <th rowspan="2">Salara / Job / Pay Grade</th>
                        <th rowspan="2">Monthly Salary</th>
                        <th colspan="5">Qualification Standards</th>
                        <th rowspan="2">Place of Assignment</th>
                    </tr>
                    <tr>
                        <th>Education</th>
                        <th>Training</th>
                        <th>Experience</th>
                        <th>Eligibility</th>
                        <th>Competency (if applicable)</th>
                    </tr>
                </thead>
                <tbody>
                    <input type="hidden" value="{{ $i = 0 }}">
                    @forelse ($all_publication as $item)
                        @if ($i < 4)
                            <input type="hidden" value="{{ $i++ }}">
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->itemno }}</td>
                                <td>{{ $item->salarygrade }}</td>
                                <td>{{ $item->monthly }}</td>
                                <td>{{ $item->education }}</td>
                                <td>{{ $item->trainig }}</td>
                                <td>{{ $item->experience }}</td>
                                <td>{{ $item->eligibility }}</td>
                                <td>{{ $item->competency }}</td>
                                <td>{{ $item->assignment }}</td>
                            </tr>
                        @else
                            <input type="hidden" value="{{ $i = 0 }}">
                </tbody>
            </table>
            <p>
                Interested and qualified should signify their interest in writing. Attach the following documents to the
                application letter and send to the address below not later than
                {{ date('F d, Y', strtotime(now() . ' + 10 day')) }}
                <br>
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                1. Resident of Delfin Albano, Isabela
                <br>
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                2. Fully Accomplished Personal Data Sheet (PDS) with recent Passport-sized Picture(CS Form No. 212 Revised
                2017) which can be downloaded in www.csc.gov.ph
                <br>
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                3. Performance Rating in the present position for one(1) year (if applicable)
                <br>
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                4.Photocopy of certificate of eligibilty/rating/license, and
                <br>
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                5. Photocopy of Transcript of Records.
                <br>
                <strong class="text-uppercase">qualified applicants</strong> are advised to hand over or send through
                courier/email their application to <br>
            <div class="ms-2">

                <div class="row">
                    <div class="col-3 border-bottom text-center border-dark">
                        HON. ARNOLD EDWARD P. CO
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 border-bottom text-center border-dark">
                        Municipal Mayor
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 border-bottom text-center border-dark">
                        Delfin Albano, Isabela
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 border-bottom text-center border-dark">
                        delfinalbano_ge@yahoo.com
                    </div>
                </div>
            </div>
            <br>
            <strong class="text-uppercase">applicantions with incomplete documents shall not be entertained.</strong>
            </p>
        </div>

        {{-- </center> --}}
    </page>
    <page size="Legal" layout="landscape">
        {{-- <center class="pt-3 m-3"> --}}
        <div class="row">
            <div class="col-4 ms-2">
                CS Form No.9 <br class="mb-0">
                Series of 2017
            </div>
            <div class="col text-center">
                <img src="{{ asset('images/DA-logo.png') }}" alt="" width="60px" height="60px"><br>
                REPUBLIC OF THE PHILIPPINES <br>
                <strong>MGO DELFIN ALBANO (MAGSAYSAY), ISABELA</strong> <br>
                <strong class="fw-bold">Request for Publication of Vacant Position</strong>
            </div>
            <div class="col-4">
            </div>
        </div>
        <br>
        <p class="mb-0 ms-2">
            To: CIVIL SERVICE COMMISSION (CSC) <br>
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            This is to request the publication of the following vacant position of MGO DELFIN ALBANO (MAGSAYSAY), ISABELA in
            the CSC Website.
        </p>
        <br>
        <div class="row justify-content-end">
            <div class="col-4 text-center">
                Date: {{ date('F d, Y', strtotime(now())) }}
            </div>
        </div>
        <div class="mx-3">

            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Position Title</th>
                        <th rowspan="2">Plantilla Item No.</th>
                        <th rowspan="2">Salara / Job / Pay Grade</th>
                        <th rowspan="2">Monthly Salary</th>
                        <th colspan="5">Qualification Standards</th>
                        <th rowspan="2">Place of Assignment</th>
                    </tr>
                    <tr>
                        <th>Education</th>
                        <th>Training</th>
                        <th>Experience</th>
                        <th>Eligibility</th>
                        <th>Competency (if applicable)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->itemno }}</td>
                        <td>{{ $item->salarygrade }}</td>
                        <td>{{ $item->monthly }}</td>
                        <td>{{ $item->education }}</td>
                        <td>{{ $item->trainig }}</td>
                        <td>{{ $item->experience }}</td>
                        <td>{{ $item->eligibility }}</td>
                        <td>{{ $item->competency }}</td>
                        <td>{{ $item->assignment }}</td>
                    </tr>
                    @endif
                @empty
                    @endforelse
                </tbody>
            </table>
            <p>
                Interested and qualified should signify their interest in writing. Attach the following documents to the
                application letter and send to the address below not later than
                {{ date('F d, Y', strtotime(now() . ' + 10 day')) }}
                <br>
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                1. Resident of Delfin Albano, Isabela
                <br>
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                2. Fully Accomplished Personal Data Sheet (PDS) with recent Passport-sized Picture(CS Form No. 212 Revised
                2017) which can be downloaded in www.csc.gov.ph
                <br>
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                3. Performance Rating in the present position for one(1) year (if applicable)
                <br>
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                4.Photocopy of certificate of eligibilty/rating/license, and
                <br>
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                5. Photocopy of Transcript of Records.
                <br>
                <strong class="text-uppercase">qualified applicants</strong> are advised to hand over or send through
                courier/email their application to <br>
            <div class="ms-2">

                <div class="row">
                    <div class="col-3 border-bottom text-center border-dark">
                        HON. ARNOLD EDWARD P. CO
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 border-bottom text-center border-dark">
                        Municipal Mayor
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 border-bottom text-center border-dark">
                        Delfin Albano, Isabela
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 border-bottom text-center border-dark">
                        delfinalbano_ge@yahoo.com
                    </div>
                </div>
            </div>
            <br>
            <strong class="text-uppercase">applicantions with incomplete documents shall not be entertained.</strong>
            </p>
        </div>

        {{-- </center> --}}
    </page>
    {{-- @empty --}}
    {{-- @endforelse --}}

@endsection
