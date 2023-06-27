<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\hr\YearlyIPCR;
use App\Models\users\Ipcr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class YearlyIPCRController extends Controller
{
    private $yearlyIPCR;

    public function __construct(YearlyIPCR $yearlyIPCR)
    {
        $this->yearlyIPCR = $yearlyIPCR;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hr.pms.yearly');


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hr.pms.yearlyTop');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $total = round(($request->average * .8) + ($request->add_points * .2), 2);

        $this->yearlyIPCR->dep_id = $request->dep_id['id'];
        $this->yearlyIPCR->year = $request->year;
        $this->yearlyIPCR->add_points = $request->add_points;
        $this->yearlyIPCR->total = $total;
        $this->yearlyIPCR->save();


        return response()->json(null, Response::HTTP_OK);
    }

    public function getAverage($dep_id)
    {

        $average = 0;
        $ratings = Ipcr::join('users', 'users.id', 'ipcrs.user_id')
        ->join('employee_plantillas', 'users.id', 'employee_plantillas.user_id')
        ->join('departments', 'departments.id', 'employee_plantillas.dep_id')
        ->select('departments.id', 'ipcrs.from', 'ipcrs.to', 'ipcrs.rating')
        ->where('departments.id', $dep_id)
        ->where('users.role', '3')
        ->get();
        foreach($ratings as $rating) {
            $average += $rating->rating;
        }
        return round($average/2, 2);
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
        $this->yearlyIPCR->destroy($id);
        return response()->json(null, Response::HTTP_OK);
    }
}
