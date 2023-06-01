<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveApplication as ModelsLeaveApplication;
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
        return view('hr.empLeave')->with('all_leave',$all_leave);
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
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
