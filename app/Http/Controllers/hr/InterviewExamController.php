<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\hr\AdditionalPoints;
use App\Models\hr\InterviewExam;
use App\Models\hr\Publication;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class InterviewExamController extends Controller
{
    private $interviewExam;
    private $user;
    private $publication;
    private $additionalPoints;


    public function __construct(InterviewExam $interviewExam, User $user, Publication $publication, AdditionalPoints $additionalPoints)
    {
        $this->interviewExam = $interviewExam;
        $this->user = $user;
        $this->additionalPoints = $additionalPoints;
        $this->publication = $publication;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $interview = $this->interviewExam;
        $interview->app_id = $request->app_id;
        $interview->user_id = $request->user_id;
        $interview->pub_id = $request->pub_id;
        $interview->written_exam = $request->written_exam;
        $interview->potential = $request->potential;
        $interview->pspt = $request->pspt;
        $interview->oral_exam = $request->oral_exam;
        $interview->background = $request->background;
        $interview->performance = $request->performance;
        $interview->rater_id = Auth::user()->id;

        $additionalPoints = $this->additionalPoints;
        $additionalPoints->app_id = $request->app_id;
        $additionalPoints->user_id = $request->user_id;
        $additionalPoints->pub_id = $request->pub_id;
        $additionalPoints->experience = $request->experience;
        $additionalPoints->eligibility = $request->eligibility;
        $additionalPoints->education = $request->education;
        $additionalPoints->rater_id = Auth::user()->id;

        if ($interview->save() && $additionalPoints->save()) {
            Session::flash('alert', 'success|Exam has been rated');
            return redirect()->back();
        } else {
            Session::flash('alert', 'danger|Exam has not been rated');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
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
        if($request->written_exam_date) {
            $request->validate([
                'written_exam_date' => 'required'
            ]);
            $interview = $this->interviewExam->findOrFail($id);
            $interview->written_exam_date = $request->written_exam_date;
            $user = $this->user->findOrFail($interview->user_id);
            $publication = $this->publication->findOrFail($interview->pub_id);
            $date = Carbon::parse($request->written_exam_date)->toDayDateTimeString();
            if ($interview->save()) {
                $details = [
                    'name' => $user->first_name,
                    'innerMessage' => 'Thankyou for your patience. You have been invited to take the written exam in LGU Delfin ALbano Municipal Hall in '.$date .'. Look for the HR Office. Thankyou and Goodluck.',
                ];

                Mail::send('mail.mailling', $details, function ($message) use ($user, $publication) {
                    $message->from(env('MAIL_FROM_ADDRESS'), config('app.name'))
                    ->to($user->email, $user->first_name)
                    ->subject('Written Exam : '.$publication->title.".");
                });

                Session::flash('alert', 'success|Exam has been Set');
                return redirect()->back();
            } else {
                Session::flash('alert', 'danger|Exam has not been Set');
                return redirect()->back();
            }
        } elseif($request->oral_exam_date) {
            $request->validate([
                'oral_exam_date' => 'required'
            ]);
            $interview = $this->interviewExam->findOrFail($id);
            $interview->oral_exam_date = $request->oral_exam_date;

            $user = $this->user->findOrFail($interview->user_id);
            $publication = $this->publication->findOrFail($interview->pub_id);
            $date = Carbon::parse($request->oral_exam_date)->toDayDateTimeString();

            if ($interview->save()) {

                $details = [
                    'name' => $user->first_name,
                    'innerMessage' => 'Thankyou for your patience. You have been invited to take the Oral Interview in LGU Delfin ALbano Municipal Hall in '.$date .'. Look for the HR Office. Thankyou and Goodluck.',
                ];

                Mail::send('mail.mailling', $details, function ($message) use ($user, $publication) {
                    $message->from(env('MAIL_FROM_ADDRESS'), config('app.name'))
                    ->to($user->email, $user->first_name)
                    ->subject('Oral Interview : '.$publication->title.".");
                });

                Session::flash('alert', 'success|Exam has been Set');
                return redirect()->back();
            } else {
                Session::flash('alert', 'danger|Exam has not been Set');
                return redirect()->back();
            }
        } else {
            $interview = $this->interviewExam->findOrFail($id);
            $interview->app_id = $request->app_id;
            $interview->user_id = $request->user_id;
            $interview->pub_id = $request->pub_id;
            $interview->potential = $request->potential;
            $interview->pspt = $request->pspt;
            $interview->written_exam = $request->written_exam;
            $interview->oral_exam = $request->oral_exam;
            $interview->background = $request->background;
            $interview->performance = $request->performance;
            $interview->performance = $request->performance;
            $interview->rater_id = Auth::user()->id;

            $additionalPoints = $this->additionalPoints->findOrFail($request->additionalPoints_id);
            $additionalPoints->app_id = $request->app_id;
            $additionalPoints->user_id = $request->user_id;
            $additionalPoints->pub_id = $request->pub_id;
            $additionalPoints->experience = $request->experience;
            $additionalPoints->eligibility = $request->eligibility;
            $additionalPoints->education = $request->education;
            $additionalPoints->rater_id = Auth::user()->id;

            if ($interview->save() && $additionalPoints->save()) {
                Session::flash('alert', 'success|Exam has been rated');
                return redirect()->back();
            } else {
                Session::flash('alert', 'danger|Exam has not been rated');
                return redirect()->back();
            }
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
        //
    }
}
