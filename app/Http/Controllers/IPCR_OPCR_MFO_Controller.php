<?php

namespace App\Http\Controllers;

use App\Models\ipcr_mfo;
use Illuminate\Http\Request;

class IPCR_OPCR_MFO_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hr.pms.ipcr_opcr.question');
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
        $MFO_question = new ipcr_mfo();
        $MFO_question->question = $request->question;
        $MFO_question->type = $request->type;
        $MFO_question->dep_id = $request->dep_id;
        $MFO_question->save();

        return response()->json(null, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $MFO_question = ipcr_mfo::findOrFail($id);
        $MFO_question->type = $request->type;
        $MFO_question->question = $request->question;
        $MFO_question->save();

        return response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ipcr_mfo::destroy($id);
        return response()->json(null, 200);
    }
}
