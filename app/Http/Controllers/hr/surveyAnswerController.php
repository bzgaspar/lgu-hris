<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\admin\EmployeePlantilla;
use App\Models\hr\surveyAnswer;
use App\Models\hr\surveyAnswerDetails;
use App\Models\hr\surveyForm;
use App\Models\hr\surveyQuestion;
use App\Models\SurveyFiles;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class surveyAnswerController extends Controller
{
    public const LOCAL_STORAGE_FOLDER = "compliance/";
    public const LOCAL_STORAGE_FOLDER_DELETE = "/public/compliance/";
    private $surveyForm;
    private $surveyAnswerDetails;
    private $surveyAnswer;
    private $user;
    private $surveyFiles;

    public function __construct(surveyForm $surveyForm, User $user, surveyAnswer $surveyAnswer, surveyAnswerDetails $surveyAnswerDetails, SurveyFiles $surveyFiles)
    {
        $this->surveyForm = $surveyForm;
        $this->surveyAnswer = $surveyAnswer;
        $this->surveyAnswerDetails = $surveyAnswerDetails;
        $this->user = $user;
        $this->surveyFiles = $surveyFiles;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveyForm = null;
        try {
            $surveyForm = $this->user->findOrFail(Auth::user()->id)->empPlantilla->surveyForm->first();

            // dd($StandardQuestions);
        } catch(Exception $e) {
            Session::flash('alert', 'danger|Something Went Wrong');
        } finally {
            return view('users.surveyAnswer')->with('surveyForm', $surveyForm);
        }

        // $plantilla = $this->employeePlantilla->where('user_id',Auth::user()->id)->first();
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
            'question' => 'required|min:1',
            'answer' => 'required|min:1',
            'surveyForm' => 'required|min:1',
        ]);
        $form = $this->surveyAnswer;
        $form->user_id = Auth::user()->id;
        $form->form_id = $request->surveyForm;
        if ($form->save()) {
            $details = [];
            if ($request->question) {
                for ($i = 0; $i < count($request->question); $i++) {
                    if ($request->question != "" && $request->answer != "") {
                        $details[] = [
                            'answer_id' => $form->id,
                            'question_id' => $request->question[$i],
                            'formDetails_id' => $request->surveyFormDetails[$i],
                            'answer' => $request->answer[$i],
                            'gap' => (intval($request->standard[$i]) - intval($request->answer[$i])),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
                if ($this->surveyAnswerDetails->insert($details)) {
                    $surveyForm = $this->surveyForm->findOrFail($request->surveyForm);
                    $surveyForm->status=2;
                    $surveyForm->save();
                }
            }
        } else {
            Session::flash('alert', 'danger|Record has not been Saved');
            return redirect()->back();
        }
        Session::flash('alert', 'success|Record has been Saved');
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
        $request->validate([
            'comply_file' => 'required|max:8000',
        ]);

        $this->surveyFiles->answer_details_id = $id;
        $this->surveyFiles->document = $this->saveFile($request->comply_file);

        if ($this->surveyFiles->save()) {
            $details = $this->surveyAnswerDetails->findOrFail($id);
            $details->status = 2;
            $details->save();
            Session::flash('alert', 'success|Files Has Been Uploaded!');
        } else {
            Session::flash('alert', 'danger|Files Has not Been Uploaded!');
        }
        return redirect()->back();
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
