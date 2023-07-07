@extends('layouts.print2')

@section('title', 'Application for Leave')
@section('customCSS')
@endsection
@section('content')
    <style>
        #first_table tr td {
            padding: 0px 0px 0px 2px;
        }
    </style>
    <page size="A4">
        <div class="row p-2">
            <div class="col-4 ms-2">
                CS Form No.9 <br class="mb-0">
                Series of 2017
            </div>
            <div class="col text-center">
                <img src="{{ asset('images/DA-logo.png') }}" alt="" width="60px" height="60px"><br>
                REPUBLIC OF THE PHILIPPINES <br>
                Province of Isabela <br>
                <p class="text-uppercase fw-bold mb-0">Municipality of Delfin albano</p>
            </div>
            <div class="col-4">
            </div>
        </div>
        <h3 class="text-center text-uppercase fw-bolder mb-0">application for leave</h3>
        <center class=" mx-3 mt-0 pt-0">
            <table class="table table-bordered table-sm border-dark" style="font-size: 11px" id="first_table">
                <tr class="border-bottom-0">
                    <td width="28%">1. OFFICE/DEPARTMENT</td>
                    <td colspan="3">
                        <div class="row justify-content-center">
                            <div class="col">
                                2. NAME : (Last)
                            </div>
                            <div class="col">
                                (First)
                            </div>
                            <div class="col">
                                (Middle)
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="border-top-0">
                    <td>
                        @if ($leaveApplication->users->empPlantilla)
                            <strong>{{ $leaveApplication->users->empPlantilla->designation->name }}</strong>
                        @endif
                    </td>
                    <td colspan="3">
                        <div class="row justify-content-center">
                            <div class="col">
                                <strong>{{ $leaveApplication->users->last_name }}
                                    {{-- @if ($leaveApplication->users->pdsPersonal)
                                        {{ $leaveApplication->users->pdsPersonal->ext_name }}
                                    @endif --}}
                                </strong>
                            </div>
                            <div class="col">
                                <strong>{{ $leaveApplication->users->first_name }}</strong>
                            </div>
                            <div class="col">
                                <strong>
                                    @if ($leaveApplication->users->pdsPersonal)
                                        {{ $leaveApplication->users->pdsPersonal->middle_name }}
                                    @endif
                                </strong>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="border-bottom-0">
                    <td>3. DATE OF FILING</td>
                    <td colspan="2" width="28%">
                        4. POSITION
                    </td>
                    <td>
                        5. SALARY
                    </td>
                </tr>
                <tr class="border-top-0">
                    <td>
                        <strong>{{ $leaveApplication->created_at->format('F d,Y') }}</strong>
                    </td>
                    <td colspan="2">
                        @if ($leaveApplication->users->empPlantilla)
                            <strong>{{ $leaveApplication->users->empPlantilla->EPposition }}</strong>
                        @endif
                    </td>
                    <td>
                        @if ($salary)
                            <strong>{{ $salary->salary }}</strong>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-center"><span class="fw-bold text-uppercase">6. Details of
                            application</span></td>
                </tr>
                <tr class="fw-bold">
                    <td colspan="3">
                        6.A TYPE OF LEAVE TO BE AVAILED OF
                    </td>
                    <td>
                        6.B DETAILS OF LEAVE
                    </td>
                </tr>
                <tr style="font-size: 10.3px">
                    <td colspan="3" class="ps-3" style="word-break: break-all;">
                        @forelse ($type as $key=>$item)
                            @if ($leaveApplication->type === $key)
                                <input type="checkbox" disabled checked><label for="">&nbsp;
                                    {{ $key }}&nbsp;{{ $item }}</label>
                                <br>
                            @else
                                <input type="checkbox"><label for="">&nbsp;
                                    {{ $key }}&nbsp;{{ $item }}</label> <br>
                            @endif
                        @empty
                        @endforelse
                        <span class="border-bottom border-dark">{{ $leaveApplication->type_other }}</span>
                    </td>
                    <td class="ps-3">
                        In case of Vacation/Special Privilege Leave: <br>
                        @forelse ($details as $item)
                            @if ($leaveApplication->details == $item)
                                @if ($loop->iteration == 3)
                                    In case of Sick Leave: <br>
                                @elseif ($loop->iteration == 5)
                                    In case of Special Leave Benefits for Women <br>
                                    In case of Study Leave: <br>
                                @elseif ($loop->iteration == 7)
                                    Other purpose: <br>
                                @endif
                                <input type="checkbox" disabled checked><label for="">&nbsp;
                                    {{ $item }}</label>
                                <span class="border-bottom border-dark">{{ $leaveApplication->details_other }}</span>
                                <br>
                            @else
                                @if ($loop->iteration == 3)
                                    In case of Sick Leave: <br>
                                @elseif ($loop->iteration == 5)
                                    In case of Special Leave Benefits for Women <br> (Specify Illness)<br>
                                    In case of Study Leave: <br>
                                @elseif ($loop->iteration == 7)
                                    Other purpose: <br>
                                @endif
                                <input type="checkbox"><label for="">&nbsp; {{ $item }}</label> <br>
                            @endif
                        @empty
                        @endforelse
                    </td>
                </tr>
                <tr class="fw-bold">
                    <td colspan="3">
                        6.C TYPE OF LEAVE TO BE AVAILED OF <br>
                        <p class="ps-3 text-decoration-underline">{{ $leaveApplication->num_days }}</p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INCLUSIVE DATES
                        <p class="ps-3 text-decoration-underline">{{ $leaveApplication->date_from }} -
                            {{ $leaveApplication->date_to }}</p>
                    </td>
                    <td>
                        6.D COMMUNICATION <br>
                        &nbsp;&nbsp;<input type="checkbox"><label for="">&nbsp; Not Requested</label><br>

                        &nbsp;&nbsp;<input type="checkbox"  disabled><label
                            for="">&nbsp;Requested</label><br><br>
                        <div class="row justify-conent-center">
                            <div class="col text-center">
                                @if ($leaveApplication->users->empPlantilla)
                                    {{ $leaveApplication->users->empPlantilla->EPno }}
                                @endif
                                <p class="border-top mb-0 border-dark">Employee Number</p>
                            </div>
                            <div class="col text-center">
                                @if ($leaveApplication->users->Esignature)
                                    <img src="{{ $leaveApplication->users->Esignature->signature }}" alt="signature"
                                        height="60px" width="60px" style="position:static;margin-top: -70px">
                                @endif
                                <p class="border-top mb-0 border-dark"
                                    @if ($leaveApplication->users->Esignature) style="margin-top: -19px" @endif>(Signature of
                                    Applicant)
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-center"><span class="fw-bold text-uppercase">7. details of
                            application</span></td>
                </tr>
                <tr class="fw-bold">
                    <td colspan="2">
                        7.A CERTIFICATION OF LEAVE CREDITS
                    </td>
                    <td colspan="2">
                        7. RECOMMENDATION
                    </td>
                </tr>
                <tr>
                    <td colspan="2" width="50%" class="fw-bold pt-2 ps-3 pe-1">
                        As of <span class="fw-bold">{{ date('F d, Y', strtotime(today())) }}</span>
                        <table class="table table-bordered table-sm me-1 border-dark" style="padding: 0px">

                            <tr class="text-center">
                                <td>
                                    &nbsp;
                                </td>
                                <td>Vacation Leave</td>
                                <td>Sick Leave</td>
                            </tr>
                            <tr>
                                <td>Total Earned</td>
                                <td>
                                    @if ($leaveApplication->LeaveApplicationPoints)
                                        {{ $leaveApplication->LeaveApplicationPoints->vl_earned }}
                                    @endif
                                </td>
                                <td>
                                    @if ($leaveApplication->LeaveApplicationPoints)
                                        {{ $leaveApplication->LeaveApplicationPoints->sl_earned }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Less this Application</td>
                                <td>
                                    @if ($leaveApplication->LeaveApplicationPoints)
                                        {{ $leaveApplication->LeaveApplicationPoints->vl_leave }}
                                    @endif
                                </td>
                                <td>
                                    @if ($leaveApplication->LeaveApplicationPoints)
                                        {{ $leaveApplication->LeaveApplicationPoints->sl_leave }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Balance</td>
                                <td>
                                    @if ($leaveApplication->LeaveApplicationPoints)
                                        {{ $leaveApplication->LeaveApplicationPoints->vl_new_balance }}
                                    @endif
                                </td>
                                <td>
                                    @if ($leaveApplication->LeaveApplicationPoints)
                                        {{ $leaveApplication->LeaveApplicationPoints->sl_new_balance }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <br>
                        <p class="mb-0 text-center f-6">
                            ERLIEGY A. BUTAY, MPA
                            @if ($leaveApplication->status == 2)
                                <?php $hr_sig = App\Http\Controllers\HomeController::getHRHeadSignature(); ?>
                                @if ($hr_sig)
                                    <img height="60px" width="60px"
                                        style="position:absolute;margin-top: -30px;margin-left: -95px"
                                        src="{{ $hr_sig }}" alt="HR Head Signature">
                                @endif
                            @endif
                        </p>

                        <p class="border-top border-dark text-center fw-light">Municipal Government Department Head I
                            (MHRMO)</p>
                    </td>
                    <td colspan="2" class="ps-3 pt-2 pe-1">

                        <input type="checkbox" disabled><label for="">&nbsp; For Approval</label><br>

                        <input type="checkbox"><label for="">&nbsp;For Disapproval due to</label>

                        &nbsp; <span contenteditable="true"> </span> <br>
                        <p></p>
                        <p contenteditable="true" class="border-bottom mb-0 border-dark">&nbsp;</p>
                        <br>
                        <br>
                        <?php $dep_head = App\Http\Controllers\HomeController::getDepartmentHeadLeave($leaveApplication->user_id);
                        ?></p>
                        @if ($leaveApplication->status == 2)
                            @if ($dep_head && $dep_head['signature'])
                                <img height="60px" width="60px"
                                    style="position:absolute;margin-top: -30px;margin-left: 160px"
                                    src="{{ $dep_head['signature'] }}" alt="HR Head Signature">
                            @endif
                        @endif
                        <p class="text-center f-6 fw-bold mb-0 p-0" contenteditable="true">
                            @if ($dep_head)
                                {{ $dep_head['full_name'] }}
                            @endif
                        </p>
                        <p  contenteditable="true" class="border-top border-dark text-center mb-0 p-0">Authorized Official</p>
                    </td>
                </tr>
                <tr class="fw-bold">
                    <td colspan="2" class="ps-3">
                        7.C APPROVED FOR: <br>
                        <p class="mb-0">___<span class="text-decoration-underline"
                                contenteditable="true">{{ $leaveApplication->num_days }}</span> __&nbsp;days
                            with pay</p>
                        <p class="mb-0" contenteditable="true">________&nbsp;days without pay</p>
                        <p class="mb-1" contenteditable="true">________&nbsp;others(Specify)</p>
                    </td>
                    <td colspan="2" class="ps-3">
                        7.C DISAPPROVED DUE TO:
                        <p class="border-bottom mb-0 border-dark" contenteditable="true">&nbsp;</p>
                        <p class="border-bottom mb-0 border-dark" contenteditable="true">&nbsp;</p>
                        <p class="border-bottom mb-1 border-dark" contenteditable="true">&nbsp;</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <br>
                        <br>
                        <p class="text-center mb-0 fw-bold" contenteditable="true">ARNOLD EDWARD P. CO</p>
                        <p class="text-center" contenteditable="true">Municipal Mayor</p>
                    </td>
                </tr>
            </table>
        </center>
    </page>
    <page size="Legal" style="font-size: 10px">
        {{-- <center class="pt-3 m-3"> --}}
        <br>
        <div class="row justify-content-center border border-dark mx-3 mt-1">
            <div class="col text-center align-center">
                <h4 style="margin-top: 8px"><strong>INSTRUCTIONS AND REQUIREMENTS</strong></h4>
            </div>
        </div>
        <div class="row border border-dark mx-3" style="text-align: justify;">
            <div class="col border-end border-dark">
                Application for any type of leave shall be made on this Form and to be accomplished at least in duplicate
                with documentary requirements, as follows:
                <ol>
                    <li><strong>Vacation leave*</strong><br> It shall be filed five (5) days in advance, whenever possible,
                        of the effective
                        date of such leave. Vacation leave within in the Philippines or abroad shall be indicated in the
                        form for purposes of securing travel authority and completing clearance from money and work
                        accountabilities.</li>
                    <li> <strong>Mandatory/Forced leave</strong><br> Annual five-day vacation leave shall be forfeited if
                        not taken during the
                        year. In
                        case the scheduled leave has been cancelled in the exigency of the service by the head of agency, it
                        shall
                        no longer be deducted from the accumulated vacation leave. Availment of one (1) day or more Vacation
                        Leave
                        (VL) shall be considered for complying the mandatory/forced leave subject to the conditions under
                        Section
                        25, Rule XVI of the Omnibus Rules Implementing E.O. No. 292.</li>
                    <li> <strong>Sick leave*</strong>
                        <ul>
                            <li>It shall be filed immediately
                                upon employee's return from such leave.</li>
                            <li>
                                If filed in advance or exceeding five (5) days, application shall
                                be accompanied by a medical certificate. In case medical consultation was not availed of, an
                                affidavit
                            </li>
                        </ul>
                        should be executed by an applicant.
                    </li>
                    <li><strong>Maternity leave* – 105 days</strong>
                        <ul>
                            <li>
                                Proof of pregnancy e.g. ultrasound,
                                doctor’s certificate on the expected date of delivery
                            </li>
                            <li>
                                Accomplished Notice of Allocation of
                                Maternity Leave
                                Credits (CS Form No. 6a), if needed
                            </li>
                            <li> Seconded female employees shall enjoy maternity leave with
                                full pay in
                                the recipient agency.</li>
                        </ul>
                    </li>
                    <li>
                        <strong>Paternity leave – 7 days</strong><br>
                        Proof of child’s delivery e.g. birth certificate, medical
                        certificate and marriage contract
                    </li>
                    <li><strong>Special Privilege leave – 3 days</strong><br>
                        It shall be filed/approved for at
                        least one (1) week prior to availment, except on emergency cases. Special privilege leave within the
                        Philippines or abroad shall be indicated in the form for purposes of securing travel authority and
                        completing clearance from money and work accountabilities.</li>
                    <li><strong>Solo Parent leave – 7 days</strong><br> It shall be filed
                        in advance or whenever possible five (5) days before going on such leave with updated Solo Parent
                        Identification Card.</li>
                    <li><strong>Study leave* – up to 6 months</strong>
                        <ul>
                            <li>Shall meet the agency’s internal requirements, if
                                any;</li>
                            <li>Contract between the agency head or authorized representative and the employee concerned.
                            </li>
                        </ul>
                    </li>
                    <li><strong>VAWC leave – 10 days</strong>
                        <ul>
                            <li>
                                It shall be filed in advance or immediately upon the woman employee’s return from
                                such
                                leave.
                            </li>
                            <li>
                                It shall be accompanied by any of the following supporting documents:
                            </li>
                            <ol type="a">
                                <li>
                                    Barangay
                                    Protection Order
                                    (BPO) obtained from the barangay;
                                </li>
                                <li>
                                    Temporary/Permanent Protection Order (TPO/PPO) obtained from
                                    the court;
                                </li>
                                <li>
                                    If the protection order is not yet issued by the barangay or the court, a certification
                                    issued by
                                    the
                                    Punong Barangay/Kagawad or Prosecutor or the Clerk of Court that the application for the
                                    BPO,
                                </li>
                            </ol>
                        </ul>
                    </li>
                </ol>
            </div>
            <div class="col">
                <ol type="a" start="4">
                    TPO or PPO has been filed with the said office shall be sufficient to support the application for the
                    ten-day leave; or
                    <li> In the absence of the BPO/TPO/PPO or the certification, a police report specifying the
                        details of the occurrence of violence on the victim and a medical certificate may be considered, at
                        the
                        discretion of the immediate supervisor of the woman employee concerned.</li>
                </ol>
                <ol start="10">
                    <li>
                        <strong>Rehabilitation leave* – up to 6 months</strong>
                        <ul>
                            <li>
                                Application shall be made within one (1) week from the time of the accident except when a
                                longer
                                period is warranted.
                            </li>
                            <li>
                                Letter request supported by relevant reports such as the police report, if any,
                            </li>
                            <li>
                                Medical certificate on the nature of the injuries, the course of treatment involved, and the
                                need to undergo
                                rest, recuperation, and rehabilitation, as the case may be.
                            </li>
                            <li>
                                Written concurrence of a government physician
                                should be obtained relative to the recommendation for rehabilitation if the attending
                                physician is a private
                                practitioner, particularly on the duration of the period of rehabilitation.
                            </li>
                        </ul>
                    </li>
                    <li> <strong>Special leave benefits for
                            women* – up to 2 months</strong>
                        <ul>
                            <li>
                                The application may be filed in advance, that is, at least five (5) days prior to
                                the scheduled date of the gynecological surgery that will be undergone by the employee. In
                                case of
                                emergency, the application for special leave shall be filed immediately upon employee’s
                                return but during
                                confinement the agency shall be notified of said surgery.
                            </li>
                            <li>
                                The application shall be accompanied by a
                                medical certificate filled out by the proper medical authorities, e.g. the attending surgeon
                                accompanied by
                                a clinical summary reflecting the gynecological disorder which shall be addressed or was
                                addressed by the
                                said surgery; the histopathological report; the operative technique used for the surgery;
                                the duration of
                                the surgery including the peri-operative period (period of confinement around surgery); as
                                well as the
                                employees estimated period of recuperation for the same.
                            </li>
                        </ul>

                    </li>
                    <li>
                        <strong>Special Emergency (Calamity) leave – up to 5 days</strong>
                        <ul>
                            <li>
                                The special emergency leave can be applied for a maximum of five (5) straight working days
                                or
                                staggered basis within thirty (30) days from the actual occurrence of the natural
                                calamity/disaster. Said
                                privilege shall be enjoyed once a year, not in every instance of calamity or disaster.
                            </li>
                            <li>
                                The head of office
                                shall take full responsibility for the grant of special emergency leave and verification of
                                the employee’s
                                eligibility to be granted thereof. Said verification shall include: validation of place of
                                residence based
                                on latest available records of the affected employee; verification that the place of
                                residence is covered in
                                the declaration of calamity area by the proper government agency; and such other proofs as
                                may be necessary.
                            </li>
                        </ul>
                    </li>
                    <li>
                        <strong> Monetization of leave credits</strong><br>
                        Application for monetization of fifty percent (50%) or more of the
                        accumulated leave credits shall be accompanied by letter request to the head of the agency stating
                        the valid
                        and justifiable reasons.
                    </li>
                    <li>
                        <strong>Terminal leave*</strong><br>
                        Proof of employee’s resignation or retirement or separation
                        from the service.
                    </li>
                    <li> <strong>Adoption Leave</strong>
                        <ul>
                            <li>
                                Application for adoption leave shall be filed with an authenticated
                                copy of the Pre-Adoptive Placement Authority issued by the Department of Social Welfare and
                                Development
                                (DSWD).
                            </li>
                        </ul>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center border border-dark mx-3 mt-1">
            <div class="col text-center align-center">
                * For leave of absence for thirty (30) calendar days or more and terminal leave, application shall be
                accompanied by a clearance from money, property and work-related accountabilities (pursuant to CSC
                Memorandum Circular No. 2, s. 1985).
            </div>
        </div>
        {{-- </center> --}}
    </page>

@endsection
