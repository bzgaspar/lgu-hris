<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\hr\Publication;
use Illuminate\Http\Request;
use App\Models\admin\Department;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PublicationController extends Controller
{
    public const LOCAL_STORAGE_FOLDER = "publicationFiles/";
    public const LOCAL_STORAGE_FOLDER_DELETE = "/public/publicationFiles/";
    private $publication;
    private $department;

    public function __construct(Publication $publication, Department $department)
    {
        $this->publication = $publication;
        $this->department = $department;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_department = $this->department->get();
        $publication = $this->publication->paginate(10);
        return view('hr.publication')
        ->with('all_department', $all_department)
        ->with('publication', $publication)
        ->with('edit_pub', null);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_publication = $this->publication->where('status', '1')->get();

        return view('print.publication')->with('all_publication', $all_publication);
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
            'title' => 'required',
            'itemno' => 'required',
            'salarygrade' => 'required',
            'monthly' => 'required',
            'education' => 'required',
            'trainig' => 'required',
            'experience' => 'required',
            'eligibility' => 'required',
            'competency' => 'required',
            'assignment' => 'required',
            'document'=>'max:8000|mimes:pdf',
        ]);

        $this->publication->title = $request->title;
        $this->publication->itemno = $request->itemno;
        $this->publication->salarygrade = $request->salarygrade;
        $this->publication->monthly = $request->monthly;
        $this->publication->education = $request->education;
        $this->publication->trainig = $request->trainig;
        $this->publication->experience = $request->experience;
        $this->publication->eligibility = $request->eligibility;
        $this->publication->competency = $request->competency;
        $this->publication->assignment = $request->assignment;
        if ($request->document) {
            $this->publication->document = $this->saveFile($request->document);
        }
        if ($this->publication->save()) {
            Session::flash('alert', 'success|Record has been Saved');
            return redirect()->route('hr.publication.index');
        } else {
            Session::flash('alert', 'danger|Record not Save');
            return redirect()->back();
        }
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
        $publication = $this->publication->paginate(10);
        $edit_pub = $this->publication->findOrFail($id);
        return view('hr.publication')
        ->with('publication', $publication)
        ->with('edit_pub', $edit_pub);
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
            'title' => 'required',
            'itemno' => 'required',
            'salarygrade' => 'required',
            'monthly' => 'required',
            'education' => 'required',
            'trainig' => 'required',
            'experience' => 'required',
            'eligibility' => 'required',
            'competency' => 'required',
            'assignment' => 'required',
            'document'=>'max:8000|mimes:pdf',
        ]);

        $publication = $this->publication->findOrFail($id);

        $publication->title = $request->title;
        $publication->itemno = $request->itemno;
        $publication->salarygrade = $request->salarygrade;
        $publication->monthly = $request->monthly;
        $publication->education = $request->education;
        $publication->trainig = $request->trainig;
        $publication->experience = $request->experience;
        $publication->eligibility = $request->eligibility;
        $publication->competency = $request->competency;
        $publication->assignment = $request->assignment;
        $publication->document = $request->document;

        if ($request->document) {
            $this->deleteFile($publication->document);
            $publication->document = $this->saveFile($request->document);
        }
        if ($publication->save()) {
            Session::flash('alert', 'success|Record has been Saved');
            return redirect()->route('hr.publication.index');
        } else {
            Session::flash('alert', 'danger|Record not Save');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pub = $this->publication->findOrFail($id);

        if ($pub->status != 0) {
            $pub->status = 0;
            if ($pub->save()) {
                Session::flash('alert', 'success|Record has been Deactivated');
                return response()->json(null, Response::HTTP_OK);
            } else {
                Session::flash('alert', 'danger|Record not Deactivated');
                return response()->json(null, Response::HTTP_OK);
            }
        } else {
            if ($this->publication->destroy($id)) {
                if($pub->document) {
                    $this->deleteFile($pub->document);
                }
                Session::flash('alert', 'success|Record has been Deleted');
                return response()->json(null, Response::HTTP_OK);
            } else {
                Session::flash('alert', 'danger|Record not Deleted');
                return response()->json(null, Response::HTTP_OK);
            }
        }
    }

    public function saveFile($file)
    {

        // getting original name
        $filenameWithExt = $file->getClientOriginalName();

        //Get just the file name
        $filenameWithoutExy = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        // creating new name
        $filename = $filenameWithoutExy."-".time()."-".Auth::user()->id.".". $file->extension();

        // getting file path
        $filename_path = self::LOCAL_STORAGE_FOLDER_DELETE . $filename;
        while (Storage::disk('local')->exists($filename_path)) {
            // creating new name while exist
            $filename = $filenameWithoutExy."-".time()."-".Auth::user()->id.".". $file->extension();
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
