<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\hr\ServiceRecord;
use App\Models\LeaveApplication as ModelsLeaveApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LeaveApplication extends Controller
{
    private $leaveApplication;
    private $serviceRecord;
    public function __construct(ModelsLeaveApplication $leaveApplication,ServiceRecord $serviceRecord)
    {
        $this->leaveApplication = $leaveApplication;
        $this->serviceRecord = $serviceRecord;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_leave = $this->leaveApplication->where('user_id',Auth::user()->id)->paginate(10);
        return view('users.myleave')->with('all_leave',$all_leave);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'details_leave' => 'required',
            'num_days' => 'required',
            'date_to' => 'required',
            'date_from' => 'required',
        ],[
            'type.required' => 'The Type of Leave is Required',
            'details_leave.required' => 'The Details of Leave is Required',
            'num_days.required' => 'The Number of Days of Leave is Required',
            'date_to.required' => 'The Date To  of Leave is Required',
            'date_from.required' => 'The Date From of Leave is Required',
        ]);

        $this->leaveApplication->user_id = Auth::user()->id;
        $this->leaveApplication->type = $request->type;
        $this->leaveApplication->type_other = $request->type_other;
        $this->leaveApplication->details = $request->details_leave;
        $this->leaveApplication->details_other = $request->details_other;
        $this->leaveApplication->num_days = $request->num_days;
        $this->leaveApplication->date_from = $request->date_from;
        $this->leaveApplication->date_to = $request->date_to;

        if ($this->leaveApplication->save()) {
            Session::flash('alert', 'success|Service Record has been Saved!');
        } else {
            Session::flash('alert', 'danger|Service Record has not Saved!');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leaveApplication = $this->leaveApplication->findOrFail($id);
        $salary = $this->serviceRecord->where('user_id',$leaveApplication->user_id)->latest()->first();
        $type = [
            'Vacation Leave' =>' (Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)',
            'Mandatory/Forced' =>' Leave(Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No. 292)',
            'Sick Leave' =>' (Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)',
            'Maternity Leave' =>' (R.A. No. 11210 / IRR issued by CSC, DOLE and SSS)',
            'Paternity Leave' =>' (R.A. No. 8187 / CSC MC No. 71, s. 1998, as amended)',
            'Special Privilege' =>' Leave (Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)',
            'Solo Parent' =>' Leave (RA No. 8972 / CSC MC No. 8, s. 2004)',
            'Study Leave' =>' (Sec. 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292)',
            '10-Day VAWC Leave' =>' (RA No. 9262 / CSC MC No. 15, s. 2005)',
            'Rehabilitation Privilege' =>' (Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)',
            'Special Leave Benefits for Women' =>' (RA No. 9710 / CSC MC No. 25, s. 2010)',
            'Special Emergency' =>' (Calamity) Leave (CSC MC No. 2, s. 2012, as amended)',
            'Adoption Leave' =>' (R.A. No. 8552)',
            'OTHERS' =>'',
        ];
        $details = [
            'Within Philippines',
            'Abroad (Specify)',
            'In Hospital (Specify Illness)',
            'Out Patient (Specify Illness)',
            'Complication',
            'BAR/Board Examination Review',
            'Monetization of Leave Credits',
            'Terminal Leave',
        ];
        return view('print.leaveApplication')
        ->with('details',$details)
        ->with('type',$type)
        ->with('salary',$salary)
        ->with('leaveApplication',$leaveApplication);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->leaveApplication->destroy($id)) {
            Session::flash('alert', 'success|Record has been Deleted');
            return redirect()->back();
        } else {
            Session::flash('alert', 'danger|Record not Deleted');
            return redirect()->back();
        }
    }
}
