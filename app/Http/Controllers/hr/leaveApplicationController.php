<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Http\Controllers\users\LeaveApplication;
use App\Models\hr\LeaveCredit;
use Illuminate\Http\Request;
use App\Models\LeaveApplication as ModelsLeaveApplication;
use App\Models\LeaveApplicationPoints;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class leaveApplicationController extends Controller
{
    private $leaveApplication;
    public function __construct(ModelsLeaveApplication $leaveApplication)
    {
        $this->leaveApplication = $leaveApplication;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_leave = $this->leaveApplication->paginate(10);
        return view('hr.empLeave')->with('all_leave', $all_leave);
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
        //
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

        $prev_credit = LeaveCredit::where('user_id', $leaveApplication->users->id)->orderByDesc('elc_period_from')->first();
        if($prev_credit) {
            $new_date = date('Y-m-d', strtotime($prev_credit->elc_period_from . ' +1 day'));
            $new_balance_sl = floatval($prev_credit->elc_sl_balance);
            $new_balance_vl = floatval($prev_credit->elc_vl_balance);

            $leaveAppPoints = new LeaveApplicationPoints();
            $leaveAppPoints->leave_app_id = $leaveApplication->id;
            $leaveAppPoints->vl_earned = $prev_credit->elc_vl_balance;
            $leaveAppPoints->sl_earned = $prev_credit->elc_sl_balance;
            if(strtolower($leaveApplication->type) === "vacation leave" || strtolower($leaveApplication->type) === "mandatory force leave" || strtolower($leaveApplication->type) === "sick leave") {
                if($leaveApplication->type == 'Sick Leave') {
                    $new_balance_sl -= floatval($leaveApplication->num_days);
                    $leaveAppPoints->sl_leave = $leaveApplication->num_days;
                } else {
                    $new_balance_vl -= floatval($leaveApplication->num_days);
                    $leaveAppPoints->vl_leave = $leaveApplication->num_days;
                }
                $leave_credit = new LeaveCredit();
                $leave_credit->user_id = $leaveApplication->user_id;
                $leave_credit->elc_period_from = $new_date;
                $leave_credit->elc_period_to = $new_date;
                $leave_credit->elc_vl_earned = 0;
                $leave_credit->elc_sl_earned = 0;
                $leave_credit->elc_vl_balance = $new_balance_vl;
                $leave_credit->elc_sl_balance = $new_balance_sl;
                $leave_credit->elc_remarks = 'Filed Leave in ' . $leaveApplication->type . ' ' . $leaveApplication->date_from . ' to ' . $leaveApplication->date_to;
                $leave_credit->save();
            }
            $leaveAppPoints->sl_new_balance = $new_balance_sl;
            $leaveAppPoints->vl_new_balance = $new_balance_vl;
            $leaveAppPoints->save();
        } else {
            if(strtolower($leaveApplication->type) === "vacation leave" || strtolower($leaveApplication->type) === "mandatory force leave" || strtolower($leaveApplication->type) === "sick leave") {
                $new_balance_sl = 0;
                $new_balance_vl = 0;
                if($leaveApplication->type == 'Sick Leave') {
                    $new_balance_sl = -floatval($leaveApplication->num_days);
                } else {
                    $new_balance_vl = -floatval($leaveApplication->num_days);
                }
                $leaveAppPoints = new LeaveApplicationPoints();
                $leaveAppPoints->leave_app_id = $leaveApplication->id;
                $leaveAppPoints->vl_earned = 0;
                $leaveAppPoints->sl_earned = 0;
                $leaveAppPoints->sl_new_balance = -$leaveApplication->num_days;
                $leaveAppPoints->vl_new_balance =  -$leaveApplication->num_days;
                $leaveAppPoints->save();
                $leave_credit = new LeaveCredit();
                $leave_credit->user_id = $leaveApplication->user_id;
                $leave_credit->elc_period_from = $$leaveApplication->date_from;
                $leave_credit->elc_period_to = $$leaveApplication->date_to;
                $leave_credit->elc_vl_earned = 0;
                $leave_credit->elc_sl_earned = 0;
                $leave_credit->elc_vl_balance = $new_balance_vl;
                $leave_credit->elc_sl_balance = $new_balance_sl;
                $leave_credit->elc_remarks = 'Filed Leave in ' . $leaveApplication->type . ' ' . $leaveApplication->date_from . ' to ' . $leaveApplication->date_to;
                $leave_credit->save();
            } else {
                $leaveAppPoints = new LeaveApplicationPoints();
                $leaveAppPoints->leave_app_id = $leaveApplication->id;
                $leaveAppPoints->vl_earned = 0;
                $leaveAppPoints->sl_earned = 0;
                $leaveAppPoints->sl_new_balance = 0;
                $leaveAppPoints->vl_new_balance = 0;
                $leaveAppPoints->save();
            }
        }

        $leaveApplication->status = 2;
        if ($leaveApplication->save()) {
            Session::flash('alert', 'success|Service Record has been Accepted!');
        } else {
            Session::flash('alert', 'danger|Service Record has not Accepted!');
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leaveApplication = $this->leaveApplication->findOrFail($id);
        $leaveApplication->status = 3;
        if ($leaveApplication->save()) {
            Session::flash('alert', 'success|Service Record has been Rejected!');
        } else {
            Session::flash('alert', 'danger|Service Record has not Rejected!');
        }
        return redirect()->back();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->leaveApplication->destroy($id);
        return response()->json(null, Response::HTTP_OK);
    }

    public static function getLeaves($id)
    {

        $prev_credit = LeaveCredit::where('user_id', $id)->orderByDesc('elc_period_from')->get();

        return $prev_credit;
    }
}
