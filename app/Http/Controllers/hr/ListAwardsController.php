<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\hr\ListAwards;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ListAwardsController extends Controller
{
    public const LOCAL_STORAGE_FOLDER = "listAwards/";
    public const LOCAL_STORAGE_FOLDER_DELETE = "/public/listAwards/";
    private $listAwards;

    public function __construct(ListAwards $listAwards)
    {
        $this->listAwards =   $listAwards;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('hr.RandR.listAwards');
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
        $this->listAwards->user_id = $request->user_id;
        $this->listAwards->title = $request->title;
        $this->listAwards->date = $request->date;
        if($request->document) {
            $this->listAwards->document = $this->saveFile($request->document, $request->user_id);
        }
        $this->listAwards->save();

        return response()->json(null, Response::HTTP_OK);
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
        $listAwards = $this->listAwards->findOrFail($id);
        $listAwards->user_id = $request->user_id;
        $listAwards->title = $request->title;
        $listAwards->date = $request->date;
        if($request->document) {
            $this->deleteFile($listAwards->document);
            $listAwards->document = $this->saveFile($request->document, $request->user_id);
        }
        $listAwards->save();
        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $listAwards = $this->listAwards->findOrFail($id);
        if($listAwards->document) {
            $this->deleteFile($listAwards->document);
        }
        $this->listAwards->destroy($listAwards->id);
        return response()->json(null, Response::HTTP_OK);
    }

    public function saveFile($file, $id)
    {

        // getting original name
        $filenameWithExt = $file->getClientOriginalName();

        //Get just the file name
        $filenameWithoutExy = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        // creating new name
        $filename = $filenameWithoutExy . "-" . time() . "-" . $id . "." . $file->extension();

        // getting file path
        $filename_path = self::LOCAL_STORAGE_FOLDER_DELETE . $filename;
        while (Storage::disk('local')->exists($filename_path)) {
            // creating new name while exist
            $filename = $filenameWithoutExy . "-" . time() . "-" . $id . "." . $file->extension();
            $filename_path = self::LOCAL_STORAGE_FOLDER_DELETE . $filename;
        }

        $file->storeAs(self::LOCAL_STORAGE_FOLDER, $filename);

        return $filename;
    }

    public function deleteFile($filename)
    {
        $filename_path = self::LOCAL_STORAGE_FOLDER_DELETE . $filename;

        if (Storage::disk('local')->exists($filename_path)) {
            Storage::disk('local')->delete($filename_path);
        }
    }
}
