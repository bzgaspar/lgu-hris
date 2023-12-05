<?php

namespace App\Http\Controllers;

use App\Models\Files_201;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class Files201Controller extends Controller
{
    public const LOCAL_STORAGE_FOLDER = "files_201/";
    public const LOCAL_STORAGE_FOLDER_DELETE = "/public/files_201/";
    private $files_201;

    public function __construct(Files_201 $files_201)
    {
        $this->files_201 = $files_201;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files_201 = $this->files_201->where('user_id', Auth::user()->id)->get();
        return view('users.files.files_201')->with('files_201', $files_201)->with('files_201_edit', null);
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

        $request->validate([
            'type' => 'required|min:1',
            'document' => 'required|max:8000|mimes:pdf,jpg,jpeg,png,gif',
        ], [
            'type.required' => 'Type is Empty',
            'document.required' => 'File is Empty',
            'document.max' => 'File is to big',
            'document.mimes' => 'Invalid File type',
        ]);
        $this->files_201->user_id = Auth::user()->id;
        $this->files_201->type = strtoupper($request->type);
        if ($request->document) {
            $this->files_201->document = $this->saveFile($request->document);
        }
        if ($this->files_201->save()) {
            Session::flash('alert', 'success|File has been Saved');
            return redirect()->back();
        } else {
            Session::flash('alert', 'danger|File not Saved');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Files_201  $files_201
     * @return \Illuminate\Http\Response
     */
    public function show(Files_201 $files_201)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Files_201  $files_201
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->files_201->findOrFail($id);

        $files_201 = $this->files_201->where('user_id', Auth::user()->id)->get();
        return view('users.files.files_201')->with('files_201', $files_201)->with('files_201_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Files_201  $files_201
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'type' => 'required|min:1',
            'document' => 'max:8000|mimes:pdf,jpg,jpeg,png,gif',
        ], [
            'type.required' => 'Type is Empty',
            'document.max' => 'File is to big',
            'document.mimes' => 'Invalid File type',
        ]);
        $files_201 = $this->files_201->findOrFail($id);
        $files_201->type = strtoupper($request->type);
        if ($request->document) {
            $files_201->document = $this->saveFile($request->document);
        }
        if ($files_201->save()) {
            Session::flash('alert', 'success|File has been Updated');
            return redirect()->route('users.Files_201.index');
        } else {
            Session::flash('alert', 'danger|File not Updated');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Files_201  $files_201
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $data = $this->files_201->findOrFail($id);
        if($data->document) {
            $this->deleteFile($data->document);
        }
        if ($this->files_201->destroy($id)) {
            Session::flash('alert', 'success|File has been Deleted');
            return redirect()->back();
        } else {
            Session::flash('alert', 'danger|File not Deleted');
            return redirect()->back();
        }
    }

    public function saveFile($file)
    {
        // getting original name
        $filenameWithExt = $file->getClientOriginalName();

        //Get just the file name
        $filenameWithoutExy = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        // creating new name
        $filename = $filenameWithoutExy . "-" . time() . "-" . Auth::user()->id . "." . $file->extension();

        // getting file path
        $filename_path = self::LOCAL_STORAGE_FOLDER_DELETE . $filename;
        while (Storage::disk('local')->exists($filename_path)) {
            // creating new name while exist
            $filename = $filenameWithoutExy . "-" . time() . "-" . Auth::user()->id . "." . $file->extension();
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
