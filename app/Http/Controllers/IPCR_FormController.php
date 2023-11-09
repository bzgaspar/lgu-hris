<?php

namespace App\Http\Controllers;

use App\Models\admin\EmployeePlantilla;
use App\Models\ipcr_mfo;
use App\Models\users\Ipcr;
use App\Models\users\ipcr_forms;
use App\Models\users\ipcr_forms_detail;
use App\Models\users\ipcr_Questions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IPCR_FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_department = EmployeePlantilla::where('user_id', Auth::user()->id)->first();
        $all_indicators = ipcr_Questions::where('dep_id', $user_department->EPdesignation)->get();
        $all_mfo_question = ipcr_mfo::where('dep_id', $user_department->EPdesignation)->get();
        return view('users.ipcr')
        ->with('all_indicators', $all_indicators)
        ->with('all_mfo_question', $all_mfo_question);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_department = EmployeePlantilla::where('user_id', Auth::user()->id)->first();
        $all_indicators = ipcr_Questions::where('dep_id', $user_department->EPdesignation)->get();
        $all_mfo_question = ipcr_mfo::where('dep_id', $user_department->EPdesignation)->get();
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
            'to' => 'required'
        ]);
        $ipcr = new ipcr_forms();
        $ipcr->user_id = Auth::user()->id;
        $ipcr->from = $request->from;
        $ipcr->to = $request->to;
        $ipcr->type = "IPCR";
        $ipcr->save();
        $details = [];
        $rating = 0;
        for($i = 0;$i < count($request->question);$i++) {
            if($request->question[$i]) {
                $details[] = [
                    'form_id' => $ipcr->id,
                    'ques1' => $request->question[$i],
                    'ques2' => $request->indicators[$i],
                    'ans1' => $request->actual[$i],
                    'rate1' => $request->rate1[$i],
                    'rate2' => $request->rate2[$i],
                    'rate3' => $request->rate3[$i],
                    'rate4' => $request->rate4[$i],
                    'remarks' => $request->remarks[$i],
                ];
            }
            $rating += $request->rate4[$i];
        }
        ipcr_forms_detail::insert($details);
        $aveRating = $rating / count($request->question);
        $equivalent = "";
        if($aveRating >= 5.0) {
            $equivalent = "Outstanding";
        } elseif($aveRating >= 4.0 && $aveRating <= 4.99) {
            $equivalent = "Very Satisfactory";
        } elseif($aveRating >= 3.0 && $aveRating <= 3.99) {
            $equivalent = "Satisfactory";
        } elseif($aveRating >= 2.0 && $aveRating <= 2.99) {
            $equivalent = "Unsatisfactory";
        } elseif($aveRating >= 1.0 && $aveRating <= 1.99) {
            $equivalent = "Poor";
        }
        $pms = new Ipcr();
        $pms->user_id = Auth::user()->id;
        $pms->from = $request->from;
        $pms->to = $request->to;
        $pms->rating = $aveRating;
        $pms->equivalent = $equivalent;
        $pms->save();

        Session::flash('alert', 'success|IPCR Has be Added!');
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

        return view('print.ipcr-opcr.ipcr')->with('ipcr', $ipcr);
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

        // $my_ipcr = ipcr_forms::join('ipcr_forms_details', 'ipcr_forms_details.form_id', 'ipcr_forms.id')
        //     ->where('ipcr_forms.id', $id)
        //     ->get();
        $my_ipcr = ipcr_forms::where('id', $id)
            ->first();
        return view('users.edit_ipcr')
        ->with('my_ipcr', $my_ipcr)
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
            'to' => 'required'
        ]);
        $ipcr =  ipcr_forms::where('id', $id)->first();
        $ipcr->user_id = Auth::user()->id;
        $ipcr->from = $request->from;
        $ipcr->to = $request->to;
        $ipcr->type = "IPCR";
        $ipcr->save();
        $details = [];
        $rating = 0;
        for($i = 0;$i < count($request->question);$i++) {
            if($request->question[$i]) {
                $details[] = [
                    'form_id' => $ipcr->id,
                    'ques1' => $request->question[$i],
                    'ques2' => $request->indicators[$i],
                    'ans1' => $request->actual[$i],
                    'rate1' => $request->rate1[$i],
                    'rate2' => $request->rate2[$i],
                    'rate3' => $request->rate3[$i],
                    'rate4' => $request->rate4[$i],
                    'remarks' => $request->remarks[$i],
                ];
                $rating += $request->rate4[$i];
            }
        }
        ipcr_forms_detail::where('form_id', $ipcr->id)->delete();
        ipcr_forms_detail::insert($details);
        $aveRating = $rating / count($request->question);
        $equivalent = "";
        if($aveRating >= 5.0) {
            $equivalent = "Outstanding";
        } elseif($aveRating >= 4.0 && $aveRating <= 4.99) {
            $equivalent = "Very Satisfactory";
        } elseif($aveRating >= 3.0 && $aveRating <= 3.99) {
            $equivalent = "Satisfactory";
        } elseif($aveRating >= 2.0 && $aveRating <= 2.99) {
            $equivalent = "Unsatisfactory";
        } elseif($aveRating >= 1.0 && $aveRating <= 1.99) {
            $equivalent = "Poor";
        }
        $pms =  Ipcr::where('user_id', Auth::user()->id)
        ->where('from', $request->from)
        ->where('to', $request->to)
        ->first();
        $pms->user_id = Auth::user()->id;
        $pms->from = $request->from;
        $pms->to = $request->to;
        $pms->rating = $aveRating;
        $pms->equivalent = $equivalent;
        $pms->save();
        Session::flash('alert', 'success|IPCR Has be Updated!');
        return redirect()->route('users.IPCR.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ipcr =  ipcr_forms::where('id', $id)->first();
        Ipcr::where('user_id', Auth::user()->id)
        ->where('from', $ipcr->from)
        ->where('to', $ipcr->to)
        ->delete();
        $ipcr->delete();
        return response()->json(null, Response::HTTP_OK);
    }
}
