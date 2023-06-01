<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\hr\ServiceRecord as HrServiceRecord;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\admin\Department;
use App\Models\admin\EmployeePlantilla;
use Illuminate\Support\Facades\Session;

class ServiceRecord extends Controller
{
    private $users;
    private $service;
    private $department;
    private $employeePlantilla;

    public function __construct(User $users, HrServiceRecord $service, Department $department, EmployeePlantilla $employeePlantilla)
    {
        $this->users = $users;
        $this->service = $service;
        $this->department = $department;
        $this->employeePlantilla = $employeePlantilla;
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

        return view('hr.servicerecord')
        ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $this->users->findOrFail($request->id);
        return view('print.serviceRecord')->with('user', $user);
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
            'from' => 'required|date',
            'to' => 'required|date',
            'status' => 'required',
            'station' => 'required',
            'salary' => 'required',
        ]);

        $this->service->user_id = $request->user_id;
        $this->service->designation = $request->designation;
        $this->service->from = $request->from;
        $this->service->to = $request->to;
        $this->service->status = $request->status;
        $this->service->salary = $request->salary;
        $this->service->station = $request->station;
        $this->service->date = $request->date;
        $this->service->wo_pay = $request->wo_pay;
        $this->service->cause = $request->cause;


        if ($this->service->save()) {
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
        $user = $this->users->findOrFail($id);
        $service = $this->service->where('user_id', $id)->paginate(20);
        $all_department = $this->department->get();
        return view('hr.showservice')
        ->with('service', $service)
        ->with('all_department', $all_department)
        ->with('edit_service', null)
        ->with('user', $user);
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
        return view('print.serviceRecord')->with('user', $user);
    }
    public function edit_record($id)
    {
        $edit_service = $this->service->findOrFail($id);

        $service = $this->service->where('user_id', $edit_service->user_id)->paginate(20);
        $user = $this->users->findOrFail($edit_service->user_id);
        return view('hr.showservice')
        ->with('edit_service', $edit_service)
        ->with('service', $service)
        ->with('user', $user);
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
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date',
            'status' => 'required',
            'station' => 'required',
            'salary' => 'required',
        ]);
        $edit_service = $this->service->findOrFail($id);
        $edit_service->designation = $request->designation;
        $edit_service->from = $request->from;
        $edit_service->to = $request->to;
        $edit_service->status = $request->status;
        $edit_service->salary = $request->salary;
        $edit_service->station = $request->station;
        $edit_service->date = $request->date;
        $edit_service->wo_pay = $request->wo_pay;
        $edit_service->cause = $request->cause;


        if ($edit_service->save()) {
            Session::flash('alert', 'success|Service Record has been Updated!');
        } else {
            Session::flash('alert', 'danger|Service Record has not Updated!');
        }
        return redirect()->route('hr.service.show', $request->user_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->service->destroy($id)) {
            Session::flash('alert', 'success|Record has been Deleted');
            return back();
        } else {
            Session::flash('alert', 'danger|Record not Deleted');
            return back();
        }
    }
}
