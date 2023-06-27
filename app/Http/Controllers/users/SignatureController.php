<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\users\Signature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SignatureController extends Controller
{
    private $esignature;


    public function __construct(Signature $signature)
    {
        $this->esignature = $signature;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $signature = $this->esignature->where('user_id', Auth::user()->id)->first();
        return view('users.Files.e-signature')
        ->with('signature', $signature)
        ;
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
        $signature = $this->esignature->where('user_id', Auth::user()->id)->first();
        if($signature) {
            $signature->delete();
        }
        $this->esignature->user_id = Auth::user()->id;
        $this->esignature->signature = $request->signature;
        $this->esignature->save();

        if ($this->esignature->save()) {
            Session::flash('alert', 'success|Signature Has Been Save!');
        } else {
            Session::flash('alert', 'danger|Signature Has Not Been Save!');
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
        //
    }
}
