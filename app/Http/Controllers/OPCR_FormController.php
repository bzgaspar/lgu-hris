<?php

namespace App\Http\Controllers;

use App\Models\admin\EmployeePlantilla;
use App\Models\ipcr_mfo;
use App\Models\users\ipcr_forms;
use App\Models\users\ipcr_forms_detail;
use App\Models\users\ipcr_Questions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OPCR_FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // admin ipcr
        return view('hr.pms.ipcr_opcr.opcr');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // admin opcr
        $user_department = EmployeePlantilla::where('user_id', Auth::user()->id)->first();
        if($user_department) {
            $all_indicators = ipcr_Questions::where('dep_id', $user_department->EPdesignation)->get();
            $all_mfo_question = ipcr_mfo::where('dep_id', $user_department->EPdesignation)->get();
        } else {
            $all_indicators = ipcr_Questions::get();
            $all_mfo_question = ipcr_mfo::get();
        }
        return view('users.opcr')
        ->with('all_indicators', $all_indicators)
        ->with('all_mfo_question', $all_mfo_question);
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
            'from' => 'required',
            'to' => 'required',
            'question' => 'required',
            'indicators' => 'required'
        ]);
        $ipcr = new ipcr_forms();
        $ipcr->user_id = Auth::user()->id;
        $ipcr->from = $request->from;
        $ipcr->to = $request->to;
        $ipcr->type = "OPCR";
        $ipcr->save();
        $details = [];
        $rating = 0;
        for($i = 0;$i < count($request->question);$i++) {
            if($request->question[$i]) {
                $details[] = [
                    'form_id' => $ipcr->id,
                    'ques1' => $request->question[$i],
                    'ques2' => $request->indicators[$i],
                    'ans1' => $request->budget[$i],
                    'ans2' => $request->accountable[$i],
                    'ans3' => $request->actual[$i],
                    'rate1' => $request->rate1[$i],
                    'rate2' => $request->rate2[$i],
                    'rate3' => $request->rate3[$i],
                    'rate4' => $request->rate4[$i],
                    'remarks' => $request->remarks[$i],
                ];
                $rating += $request->rate4[$i];
            }
        }
        ipcr_forms_detail::insert($details);
        Session::flash('alert', 'success|OPCR Has be Added!');
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
        $ipcr =  ipcr_forms::where('id', $id)->first();

        return view('print.ipcr-opcr.opcr')->with('ipcr', $ipcr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_department = EmployeePlantilla::where('user_id', Auth::user()->id)->first();
        $all_indicators = ipcr_Questions::where('dep_id', $user_department->EPdesignation)->get();
        $all_mfo_question = ipcr_mfo::where('dep_id', $user_department->EPdesignation)->get();

        // $my_opcr = ipcr_forms::join('ipcr_forms_details', 'ipcr_forms_details.form_id', 'ipcr_forms.id')
        //     ->where('ipcr_forms.id', $id)
        //     ->get();
        $my_opcr = ipcr_forms::where('id', $id)
            ->first();
        return view('users.edit_opcr')
        ->with('my_opcr', $my_opcr)
        ->with('all_indicators', $all_indicators)
        ->with('all_mfo_question', $all_mfo_question);
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
            'from' => 'required',
            'to' => 'required',
            'question' => 'required',
            'indicators' => 'required'
        ]);
        $ipcr =  ipcr_forms::where('id', $id)->first();
        $ipcr->user_id = Auth::user()->id;
        $ipcr->from = $request->from;
        $ipcr->to = $request->to;
        $ipcr->type = "OPCR";
        $ipcr->save();
        $details = [];
        $rating = 0;
        for($i = 0;$i < count($request->question);$i++) {
            if($request->question[$i]) {
                $details[] = [
                    'form_id' => $ipcr->id,
                    'ques1' => $request->question[$i],
                    'ques2' => $request->indicators[$i],
                    'ans1' => $request->budget[$i],
                    'ans2' => $request->accountable[$i],
                    'ans3' => $request->actual[$i],
                    'rate1' => $request->rate1[$i],
                    'rate2' => $request->rate2[$i],
                    'rate3' => $request->rate3[$i],
                    'rate4' => $request->rate4[$i],
                    'remarks' => $request->remarks[$i],
                ];
            }
            $rating += $request->rate4[$i];
        }
        ipcr_forms_detail::where('form_id', $ipcr->id)->delete();
        ipcr_forms_detail::insert($details);
        Session::flash('alert', 'success|OPCR Has be Updated!');
        return redirect()->route('users.IPCR.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ipcr_forms::where('id', $id)->delete();
        return response()->json(null, Response::HTTP_OK);
    }
}
