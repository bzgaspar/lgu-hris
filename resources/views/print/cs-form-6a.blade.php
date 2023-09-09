<h3 style="
  padding-top: 4pt;
  padding-left: 7pt;
  text-indent: 0pt;
  text-align: left;
">
    CS Form No. 6a <span class="h1">ANNEX B</span>
</h3>
<h3 style="
  padding-top: 1pt;
  padding-left: 7pt;
  text-indent: 0pt;
  text-align: left;
">
    Series of 2020
</h3>
<p style="text-indent: 0pt; text-align: left"><br /></p>
<h2 style="padding-left: 30pt; text-indent: 0pt; text-align: center">
    NOTICE OF ALLOCATION OF MATERNITY LEAVE
</h2>
<p style="text-indent: 0pt; text-align: left"><br /></p>
<ol id="l1">
    <li data-list-text="I.">
        <p
            style="
      padding-top: 4pt;
      padding-left: 18pt;
      text-indent: -11pt;
      text-align: left;
    ">
            FOR FEMALE EMPLOYEE
        </p>
        <p style="text-indent: 0pt; text-align: left"><br /></p>
        <table style="border-collapse: collapse; margin-left: 7.274pt;
    margin-top: -20px;width: 95%"
            cellspacing="0">
            <tr style="height: 10pt">
                <td style="
          width: 284pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    bgcolor="#E7E6E6">
                    <p class="s1"
                        style="
            padding-left: 5pt;
            text-indent: 0pt;
            line-height: 8pt;
            text-align: left;
          ">
                        NAME
                        <i>(Last Name, First Name, Name Extension, if any, and Middle
                            Name)</i>
                    </p>
                </td>
                <td style="
          width: 184pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    bgcolor="#E7E6E6">
                    <p class="s1"
                        style="
            padding-left: 5pt;
            text-indent: 0pt;
            line-height: 8pt;
            text-align: left;
          ">
                        POSITION
                    </p>
                </td>
            </tr>
            <tr style="height: 19pt">
                <td
                    style="
          width: 284pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        ">

                    <p style="text-indent: 0pt; text-align: left">
                        <?php $user_info = App\Http\Controllers\HomeController::getFullName($leaveApplication->users->id); ?>
                        {{ $user_info['full_name'] }}
                    </p>
                </td>
                <td
                    style="
          width: 184pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        ">
                    <p style="text-indent: 0pt; text-align: left">{{ $user_info['position'] }}</p>
                </td>
            </tr>
            <tr style="height: 10pt">
                <td style="
          width: 284pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    bgcolor="#E7E6E6">
                    <p class="s1"
                        style="
            padding-left: 5pt;
            text-indent: 0pt;
            line-height: 8pt;
            text-align: left;
          ">
                        HOME ADDRESS
                    </p>
                </td>
                <td style="
          width: 184pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    bgcolor="#E7E6E6">
                    <p class="s1"
                        style="
            padding-left: 5pt;
            text-indent: 0pt;
            line-height: 8pt;
            text-align: left;
          ">
                        AGENCY and ADDRESS
                    </p>
                </td>
            </tr>
            <tr style="height: 19pt">
                <td
                    style="
          width: 284pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        ">
                    <p style="text-indent: 0pt; text-align: left">
                        @if ($leaveApplication->users->pdsPersonal)
                            {{ $leaveApplication->users->pdsPersonal->barangay }},
                            {{ $leaveApplication->users->pdsPersonal->city }},
                            {{ $leaveApplication->users->pdsPersonal->province }}
                        @endif
                    </p>
                </td>
                <td style="
          width: 184pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    rowspan="3">
                    <p style="text-indent: 0pt; text-align: left"> Local Government Unit - Delfin Albano, Isabela</p>
                </td>
            </tr>
            <tr style="height: 10pt">
                <td style="
          width: 284pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    bgcolor="#E7E6E6">
                    <p class="s1"
                        style="
            padding-left: 5pt;
            text-indent: 0pt;
            line-height: 8pt;
            text-align: left;
          ">
                        CONTACT DETAILS <i>(Phone number and e-mail address)</i>
                    </p>
                </td>
            </tr>
            <tr style="height: 19pt">
                <td
                    style="
          width: 284pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        ">
                    <p style="text-indent: 0pt; text-align: left">
                        @if ($leaveApplication->users->pdsPersonal)
                            {{ $leaveApplication->users->pdsPersonal->mobile_no }}
                            @if ($leaveApplication->users->pdsPersonal->mobile_no)
                                /
                            @endif
                            {{ $leaveApplication->users->pdsPersonal->email }}
                        @endif
                    </p>
                </td>
            </tr>
            <tr style="height: 42pt">
                <td style="
          width: 468pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    colspan="2">
                    <p style="text-indent: 0pt; text-align: left"><br /></p>
                    <p class="s2"
                        style="
            padding-left: 5pt;
            padding-right: 4pt;
            text-indent: 22pt;
            text-align: justify;
          ">
                        I am allocating <u contenteditable="true" class="fw-bold"> click here to edit
                        </u> days
                        <span class="s1">(7 days max.) </span>of my 105-day maternity
                        leave to Mr./Ms.
                        <u contenteditable="true" class="fw-bold"> click here to edit
                        </u>, which benefit is granted under Republic Act No. 11210 or the
                        105-Day Expanded Maternity Law. Attached is the proof of our
                        relationship.
                    </p>
                </td>
            </tr>
            <tr style="height: 23pt">
                <td
                    style="
          width: 284pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
        ">
                    <p style="padding-left: 49pt; text-align: left">
                        @if ($leaveApplication->users->Esignature)
                            <img src="" alt="signature" height="60px" width="60px"
                                style="position:static;margin-top: 20px;margin-left: 55px" class="border">
                        @endif
                        <br>
                        {{ $user_info['full_name'] }}
                    </p>
                    <p class="s1"
                        style="
            padding-left: 50pt;
            text-indent: 0pt;
            line-height: 8pt;
            text-align: left;
          ">
                        SIGNATURE OVER PRINTED NAME
                    </p>
                </td>
                <td
                    style="
          width: 184pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        ">
                    <p style="text-indent: 0pt; text-align: left"><br /></p>
                    <p class="s1"
                        style="
            padding-left: 57pt;
            text-indent: 0pt;
            line-height: 8pt;
            text-align: left;
          ">
                        DATE : <span
                            class="fw-bold">{{ date('F d, Y', strtotime($leaveApplication->created_at)) }}</span>
                    </p>
                </td>
            </tr>
        </table>
        <p style="text-indent: 0pt; text-align: left"><br /></p>
    </li>
    <li data-list-text="II.">
        <p style="padding-left: 18pt; text-indent: -11pt; text-align: left">
            FOR CHILD’S FATHER/ALTERNATE CAREGIVER
        </p>
        <p style="text-indent: 0pt; text-align: left"><br /></p>
        <table style="border-collapse: collapse; margin-left: 7.274pt;width: 95%;margin-top: -25px" cellspacing="0">
            <tr style="height: 10pt">
                <td style="
          width: 283pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    colspan="2" bgcolor="#E7E6E6">
                    <p class="s1"
                        style="
            padding-left: 5pt;
            text-indent: 0pt;
            line-height: 8pt;
            text-align: left;
          ">
                        NAME (Last Name, First Name, Name Extension, if any, and Middle
                        Name)
                    </p>
                </td>
                <td style="
          width: 185pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    bgcolor="#E7E6E6">
                    <p class="s1"
                        style="
            padding-left: 5pt;
            text-indent: 0pt;
            line-height: 8pt;
            text-align: left;
          ">
                        POSITION
                    </p>
                </td>
            </tr>
            <tr style="height: 19pt">
                <td style="
          width: 283pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    colspan="2">
                    <p style="text-indent: 0pt; text-align: left">
                        @if ($leaveApplication->users->pdsFamily)
                            {{ $leaveApplication->users->pdsFamily->Slname }}
                            {{ $leaveApplication->users->pdsFamily->Sfname }}
                            {{ $leaveApplication->users->pdsFamily->Smname }}
                        @endif
                    </p>
                </td>
                <td
                    style="
          width: 185pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        ">
                    <p style="text-indent: 0pt; text-align: left">

                        @if ($leaveApplication->users->pdsFamily)
                            {{ $leaveApplication->users->pdsFamily->Soccupation }}
                        @endif
                    </p>
                </td>
            </tr>
            <tr style="height: 10pt">
                <td style="
          width: 283pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    colspan="2" bgcolor="#E7E6E6">
                    <p class="s1"
                        style="
            padding-left: 5pt;
            text-indent: 0pt;
            line-height: 8pt;
            text-align: left;
          ">
                        HOME ADDRESS
                    </p>
                </td>
                <td style="
          width: 185pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    bgcolor="#E7E6E6">
                    <p class="s1"
                        style="
            padding-left: 5pt;
            text-indent: 0pt;
            line-height: 8pt;
            text-align: left;
          ">
                        AGENCY / EMPLOYER and ADDRESS
                    </p>
                </td>
            </tr>
            <tr style="height: 19pt">
                <td style="
          width: 283pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    colspan="2">
                    <p style="text-indent: 0pt; text-align: left"><br /></p>
                </td>
                <td style="
          width: 185pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    rowspan="3">
                    <p style="text-indent: 0pt; text-align: left">

                        @if ($leaveApplication->users->pdsFamily)
                            {{ $leaveApplication->users->pdsFamily->SempBus }}
                            {{ $leaveApplication->users->pdsFamily->SBusAdd }}
                        @endif
                    </p>
                </td>
            </tr>
            <tr style="height: 10pt">
                <td style="
          width: 283pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    colspan="2" bgcolor="#E7E6E6">
                    <p class="s1"
                        style="
            padding-left: 5pt;
            text-indent: 0pt;
            line-height: 8pt;
            text-align: left;
          ">
                        CONTACT DETAILS <i>(Phone number and e-mail address)</i>
                    </p>
                </td>
            </tr>
            <tr style="height: 19pt">
                <td style="
          width: 283pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    colspan="2">
                    <p style="text-indent: 0pt; text-align: left"><br /></p>
                </td>
            </tr>
            <tr style="height: 22pt">
                <td style="
          width: 187pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    bgcolor="#E7E6E6">
                    <p class="s1"
                        style="
            padding-top: 1pt;
            padding-left: 5pt;
            text-indent: 0pt;
            text-align: left;
          ">
                        RELATIONSHIP TO THE FEMALE EMPLOYEE
                    </p>
                    <p class="s2" style="padding-left: 5pt; text-indent: 0pt; text-align: left">
                        (Please mark the box with “x”)
                    </p>
                </td>
                <td style="
          width: 281pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    colspan="2" rowspan="2">
                    <p style="text-indent: 0pt; text-align: left"><br /></p>
                    <p class="s2"
                        style="
            padding-left: 6pt;
            padding-right: 4pt;
            text-indent: 28pt;
            text-align: justify;
          ">
                        I accept the allocated <u class="fw-bold" contenteditable="true">click here to edit</u> days
                        of the 105-day
                        maternity leave from the abovementioned female employee and I/we
                        submit the attached proof of our relationship. It is understood
                        that the allocated maternity leave is for the care of our/her
                        newborn child.
                    </p>
                </td>
            </tr>
            <tr style="height: 35pt">
                <td style="
          width: 187pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    rowspan="2">
                    <p class="s2" style="padding-left: 20pt; text-indent: 0pt; text-align: left">
                        (Specify:
                        <u contenteditable="true" class="fw-bold"> click here to edit
                        </u>)
                    </p>
                </td>
            </tr>
            <tr style="height: 28pt">
                <td
                    style="
          width: 180pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
        ">
                    <p style="padding-left: 25pt; text-align: left">
                        <br>
                        <u class="fw-bold" contenteditable="true">click here to edit</u>
                    </p>
                    <p class="s1"
                        style="
            padding-left: 22pt;
            text-indent: 0pt;
            line-height: 8pt;
            text-align: left;
          ">
                        SIGNATURE OVER PRINTED NAME
                    </p>
                </td>
                <td
                    style="
          width: 101pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        ">
                    <p style="text-indent: 0pt; text-align: left"><br /></p>
                    <p class="s1"
                        style="
            padding-left: 39pt;
            padding-right: 38pt;
            text-indent: 0pt;
            line-height: 8pt;
            text-align: center;
          ">
                        DATE : <u class="fw-bold" contenteditable="true">click here to edit</u>
                    </p>
                </td>
            </tr>
        </table>
        <ul id="l2">
            <li data-list-text="☐">
                <p class="s1"
                    style="
          padding-top: 5pt;
          padding-left: 13pt;
          text-indent: -8pt;
          text-align: left;
        ">
                    Child’s father
                </p>
            </li>
            <li data-list-text="☐">
                <p class="s1" style="padding-left: 13pt; text-indent: -8pt; text-align: left">
                    Alternate caregiver
                </p>
                <ul id="l3">
                    <li data-list-text="☐">
                        <p class="s1"
                            style="
              padding-left: 21pt;
              text-indent: -8pt;
              text-align: left;
            ">
                            Relative within fourth degree of consanguinity
                        </p>
                    </li>
                    <li data-list-text="☐">
                        <p class="s1"
                            style="
              padding-left: 21pt;
              text-indent: -8pt;
              text-align: left;
            ">
                            Current partner sharing the same household
                        </p>
                    </li>
                </ul>
            </li>
        </ul>
        <p style="text-indent: 0pt; text-align: left"><br /></p>
        <table style="border-collapse: collapse; margin-left: 7.274pt;margin-top: -20px;width: 95%" cellspacing="0">
            <tr style="height: 19pt">
                <td style="
          width: 468pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        "
                    colspan="4" bgcolor="#E7E6E6">
                    <p class="s1"
                        style="
            padding-left: 107pt;
            padding-right: 106pt;
            text-indent: 0pt;
            line-height: 9pt;
            text-align: center;
          ">
                        PROOF OF RELATIONSHIP
                    </p>
                    <p class="s2"
                        style="
            padding-left: 107pt;
            padding-right: 106pt;
            text-indent: 0pt;
            line-height: 8pt;
            text-align: center;
          ">
                        (Please mark the box with “x” and attach a photocopy of the
                        document)
                    </p>
                </td>
            </tr>
            <tr style="height: 23pt">
                <td
                    style="
          width: 105pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        " />
                <td
                    style="
          width: 95pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        " />
                <td
                    style="
          width: 98pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        " />
                <td
                    style="
          width: 170pt;
          border-top-style: solid;
          border-top-width: 1pt;
          border-left-style: solid;
          border-left-width: 1pt;
          border-bottom-style: solid;
          border-bottom-width: 1pt;
          border-right-style: solid;
          border-right-width: 1pt;
        " />
            </tr>
        </table>
        <ul id="l4">
            <li data-list-text="☐">
                <p class="s1" style="padding-left: 15pt; text-indent: -10pt; text-align: left">
                    Child’s Birth Certificate
                </p>
            </li>
        </ul>
        <ul id="l5">
            <li data-list-text="☐">
                <p class="s1" style="padding-left: 15pt; text-indent: -10pt; text-align: left">
                    Marriage Certificate
                </p>
            </li>
        </ul>
        <ul id="l6">
            <li data-list-text="☐">
                <p class="s1" style="padding-left: 15pt; text-indent: -10pt; text-align: left">
                    Barangay Certificate
                </p>
            </li>
        </ul>
        <ul id="l7">
            <li data-list-text="☐">
                <p class="s1"
                    style="
          padding-left: 13pt;
          padding-right: 26pt;
          text-indent: -8pt;
          text-align: left;
        ">
                    Other bona fide document/s that can prove filial relationship
                </p>
            </li>
        </ul>
        <p style="text-indent: 0pt; text-align: left"><br /></p>
    </li>
    <li data-list-text="III.">
        <p style="padding-left: 20pt; text-indent: -13pt; text-align: left;margin-top: -20px">
            FOR THE HRMO AND THE HEAD OF OFFICE/AUTHORIZED OFFICIAL
        </p>
    </li>
</ol>
<p style="text-indent: 0pt; text-align: left"><br /></p>
<table style="border-collapse: collapse; margin-left: 7.274pt;margin-top: -30px;width: 95%" cellspacing="0">
    <tr style="height: 10pt">
        <td style="
      width: 234pt;
      border-top-style: solid;
      border-top-width: 1pt;
      border-left-style: solid;
      border-left-width: 1pt;
      border-right-style: solid;
      border-right-width: 1pt;
    "
            colspan="2" rowspan="2">
            <p style="text-indent: 0pt; text-align: left"><br /></p>
            <p class="s2"
                style="
        padding-left: 5pt;
        padding-right: 7pt;
        text-indent: 22pt;
        text-align: left;
      ">
                I certify that Ms.
                <u contenteditable="true" class="fw-bold"> click here to edit
                </u>has a maternity leave balance of <u contenteditable="true" class="fw-bold"> click here to edit
                </u>days.
                Furthermore, I have
            </p>
            <p class="s2"
                style="
        padding-left: 5pt;
        padding-right: 7pt;
        text-indent: 0pt;
        line-height: 9pt;
        text-align: left;
      ">
                reviewed and evaluated the attached supporting document/s and find
                the herein allocation of maternity leave in order.
            </p>
        </td>
        <td style="
      width: 234pt;
      border-top-style: solid;
      border-top-width: 1pt;
      border-left-style: solid;
      border-left-width: 1pt;
      border-bottom-style: solid;
      border-bottom-width: 1pt;
      border-right-style: solid;
      border-right-width: 1pt;
    "
            bgcolor="#E7E6E6">
            <p class="s1"
                style="
        padding-left: 48pt;
        padding-right: 48pt;
        text-indent: 0pt;
        line-height: 8pt;
        text-align: center;
      ">
                APPROVED:
            </p>
        </td>
    </tr>
    <tr style="height: 37pt">
        <td style="
      width: 234pt;
      border-top-style: solid;
      border-top-width: 1pt;
      border-left-style: solid;
      border-left-width: 1pt;
      border-bottom-style: solid;
      border-bottom-width: 1pt;
      border-right-style: solid;
      border-right-width: 1pt;
    "
            rowspan="2">
            <p style="text-indent: 0pt; text-align: left"><br /></p>
            <p style="padding-left: 80pt; text-align: left">
                <br>
            </p>
            <p class="s1"
                style="
        padding-top: 5pt;
        padding-left: 48pt;
        padding-right: 48pt;
        text-indent: 0pt;
        line-height: 9pt;
        text-align: center; font-weight: bold
      ">
                <ul contenteditable="true" class="fw-bold">click here to edit</ul>
            </p>
            <p class="s1"
                style="
        padding-left: 48pt;
        padding-right: 48pt;
        text-indent: 0pt;
        line-height: 9pt;
        text-align: center;
      ">
                Head of Office/Authorized Official
            </p>
            <p class="s1"
                style="
        padding-top: 8pt;
        padding-left: 48pt;
        padding-right: 48pt;
        text-indent: 0pt;
        line-height: 8pt;
        text-align: center;
      ">
                DATE
            </p>
        </td>
    </tr>
    <tr style="height: 47pt">
        <td
            style="
      width: 148pt;
      border-left-style: solid;
      border-left-width: 1pt;
      border-bottom-style: solid;
      border-bottom-width: 1pt;
    ">
            <p style="padding-left: 25pt; text-align: left" class="mb-0 mt-4">
                @if ($leaveApplication->status == 2)
                    @if ($hr_sig)
                        <img height="60px" width="60px"
                            style="position:absolute;margin-top: -30px;margin-left: -95px" src="{{ $hr_sig }}"
                            alt="HR Head Signature">
                    @endif
                @endif
                ERLIEGY A. BUTAY, MPA
            </p>
            <p class="s1 mb-0 mt-0"
                style="
        padding-left: 61pt;
        text-indent: -55pt;
        line-height: 9pt;
        text-align: left;
      ">
                SIGNATURE OVER PRINTED NAME HRMO
            </p>
        </td>
        <td
            style="
      width: 86pt;
      border-bottom-style: solid;
      border-bottom-width: 1pt;
      border-right-style: solid;
      border-right-width: 1pt;
    ">
            <p style="text-indent: 0pt; text-align: left"><br /></p>
            <p class="s1"
                style="
        padding-top: 7pt;
        padding-left: 31pt;
        padding-right: 31pt;
        text-indent: 0pt;
        text-align: center;
      ">
                DATE
            </p>
        </td>
    </tr>
    <tr style="height: 10pt">
        <td style="
      width: 468pt;
      border-top-style: solid;
      border-top-width: 1pt;
      border-left-style: solid;
      border-left-width: 1pt;
      border-bottom-style: solid;
      border-bottom-width: 1pt;
      border-right-style: solid;
      border-right-width: 1pt;
    "
            colspan="3" bgcolor="#E7E6E6">
            <p class="s1"
                style="
        padding-left: 5pt;
        text-indent: 0pt;
        line-height: 8pt;
        text-align: left;
      ">
                AGENCY, ADDRESS and CONTACT DETAILS
            </p>
        </td>
    </tr>
    <tr style="height: 29pt">
        <td style="
      width: 468pt;
      border-top-style: solid;
      border-top-width: 1pt;
      border-left-style: solid;
      border-left-width: 1pt;
      border-bottom-style: solid;
      border-bottom-width: 1pt;
      border-right-style: solid;
      border-right-width: 1pt;
    "
            colspan="3">
            <p style="text-indent: 0pt; text-align: left"><br /></p>
        </td>
    </tr>
</table>
<p style="text-indent: 0pt; text-align: left"><br /></p>
