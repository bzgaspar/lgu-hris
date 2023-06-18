<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\hr\LeaveCredit;
use App\Models\reference\earned;
use App\Models\reference\hours;
use App\Models\reference\minutes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LeaveRecordController extends Controller
{
    private $leavecredit;
    private $users;
    private $minutes;
    private $hours;
    private $earned;

    public function __construct(LeaveCredit $leavecredit, User $users, minutes $minutes, hours $hours, earned $earned)
    {
        $this->leavecredit = $leavecredit;
        $this->users = $users;
        $this->minutes = $minutes;
        $this->hours = $hours;
        $this->earned = $earned;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $users = $this->users
            ->where('first_name', 'like', '%'.$request->search.'%')
            ->orwhere('last_name', 'like', '%'.$request->search.'%')
            ->EMP()
            ->latest()
            ->paginate(30);
        } else {
            $users = $this->users
            ->EMP()
            ->latest()
            ->paginate(30);
        }

        return view('hr.leavecredit')
        ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $leave = $request->toArray();
        $timestamps =
        [
            'created_at' =>  now(),
            'updated_at' =>  now(),
        ];

        if($this->leavecredit->create(array_merge($leave, $timestamps))) {

            return response()->json(null, Response::HTTP_OK);
        }
    }


    public function print($id)
    {
        $user = $this->users->findOrFail($id);
        return view('print.leavecard')->with('user', $user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leavecard = $this->leavecredit->where('user_id', $id)->latest()->paginate(20);
        $user = $this->users->findOrFail($id);
        $minutes = $this->minutes->get();
        $hours = $this->hours->get();
        return view('hr.tardiness')
        ->with('user', $user)
        ->with('minutes', $minutes)
        ->with('hours', $hours)
        ->with('leavecard', $leavecard);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->users->findOrFail($id);
        $leavecard = $this->leavecredit->where('user_id', $id)->latest()->paginate(20);
        return view('hr.leavecard')
        ->with('user', $user)
        ->with('leavecard', $leavecard);
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
        $leave = $request->toArray();
        $check_leave = $this->leavecredit->findOrFail($request->id);
        $timestamps =
        [
            'updated_at' =>  now(),
        ];
        $this->leavecredit->where('id', $request->id)->update(array_merge($leave, $timestamps));
        $difference_vl = $request->elc_vl_balance - $check_leave->elc_vl_balance;
        $difference_sl = $request->elc_sl_balance - $check_leave->elc_sl_balance;
        $following_leave = $this->leavecredit->where('id', '>', $request->id)->where('user_id', $request->user_id)->get();
        if($following_leave) {
            foreach($following_leave as $leave_current) {
                $update_follow_leave = $this->leavecredit->findOrFail($leave_current->id);
                $update_follow_leave->elc_vl_balance = $update_follow_leave->elc_vl_balance + $difference_vl;
                $update_follow_leave->elc_sl_balance = $update_follow_leave->elc_sl_balance + $difference_sl;
                $update_follow_leave->save();
            }
        }

        return response()->json(null, Response::HTTP_OK);
        // $request->validate([
        //     'from' => 'required',
        //     'to' => 'required',
        // ]);
        // $dates = $this->leavecredit->select('elc_period_from','elc_period_to')->where('user_id',$id)->get();

        // foreach($dates as $date)
        // {
        //     if($date->elc_period_from == $request->from && $date->elc_period_to == $request->to)
        //     {
        //         Session::flash('alert', 'danger|Invalid Date');
        //         return redirect()->back();
        //     }
        // }
        // if($request->from > $request->to){
        //     Session::flash('alert', 'danger|Invalid Date');
        //     return redirect()->back();
        // }
        // // total days
        // $diff_in_days = Carbon::parse($request->to)->diffInDays(Carbon::parse($request->from)) + 1;

        // $month = date('m', strtotime($request->from));
        // // getting last inserted record
        // $leavecredit = $this->leavecredit->where('user_id', $id)->latest()->first();

        // // getting sl vl balance
        // if ($leavecredit) {
        //     $balance_vl = $leavecredit->elc_vl_balance;
        //     $balance_sl = $leavecredit->elc_sl_balance;
        // } else {
        //     $balance_vl = 0;
        //     $balance_sl = 0;
        // }

        // // checking in days is greater than 3
        // if ($diff_in_days == 31 || ($month == "02" && $diff_in_days == 28 || $diff_in_days == 29)) {
        //     $diff_in_days = 30;
        // }
        // // getting earned credit
        // $earned = $this->earned->findOrFail($diff_in_days);
        // //  getting total deduction minus earned
        // $total_vl_deduction = $request->vl_m + $request->vl_h +$request->vl_d;
        // $total_sl_deduction = $request->sl_m + $request->sl_h +$request->sl_d;
        // // total earned
        // $total_vl_earned = $earned->value - $total_vl_deduction;
        // $total_sl_earned = $earned->value - $total_sl_deduction;

        // // getting new balance
        // $balance_vl += $total_vl_earned;
        // $balance_sl += $total_sl_earned;

        // $this->leavecredit->user_id = $id;
        // $this->leavecredit->elc_period_from = $request->from;
        // $this->leavecredit->elc_period_to = $request->to;
        // $this->leavecredit->elc_particular = $request->particular;
        // $this->leavecredit->elc_vl_earned = $earned->value ;
        // $this->leavecredit->elc_vl_balance = $balance_vl;
        // $this->leavecredit->elc_sl_earned = $earned->value ;
        // $this->leavecredit->elc_sl_balance = $balance_sl;
        // $this->leavecredit->elc_remarks = $request->remarks;

        // if ($request->with_pay_vl == 0) {
        //     $this->leavecredit->elc_vl_auw_p = $total_vl_deduction;
        // } else {
        //     $this->leavecredit->elc_vl_auwo_p = $total_vl_deduction;
        // }

        // if ($request->with_pay_sl == 0) {
        //     $this->leavecredit->elc_sl_auw_p = $total_sl_deduction;
        // } else {
        //     $this->leavecredit->elc_sl_auwo_p = $total_sl_deduction;
        // }

        // if ($this->leavecredit->save()) {
        //     Session::flash('alert', 'success|Record has been Saved');
        //     return redirect()->back();
        // } else {
        //     Session::flash('alert', 'danger|Record not Save');
        //     return redirect()->back();
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->leavecredit->destroy($id)) {
            return response()->json(null, Response::HTTP_OK);
        } else {
            return response()->json(null, Response::HTTP_OK);
        }
    }
}
