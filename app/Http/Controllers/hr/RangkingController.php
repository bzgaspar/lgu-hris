<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\hr\hrmpsb;
use Illuminate\Http\Request;
use App\Models\hr\InterviewExam;
use App\Models\hr\Publication;
use App\Models\pds\personal;
use App\Models\User;
use App\Models\users\application;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RangkingController extends Controller
{
    private $personal;
    private $application;
    private $interviewExam;
    private $user;
    private $publication;

    public function __construct(personal $personal, application $application, InterviewExam $interviewExam, User $user, Publication $publication)
    {
        $this->personal = $personal;
        $this->interviewExam = $interviewExam;
        $this->application = $application;
        $this->user = $user;
        $this->publication = $publication;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $all_applicants = $this->application->Application($request)->get();

        $ranking = $this->ranking($all_applicants);
        // with paginate
        // $ranking = $this->paginateArray($this->app_ranking($all_applicants));
        $publication = $this->publication->where('status', '1')->get();
        // dd($ranking);
        return view('hr.applicant.rangking')
        ->with('publication', $publication)
        ->with('ranking', $ranking);
    }

    public function getRanking()
    {
        $all_applicants = $this->application
        ->leftJoin('users', 'users.id', '=', 'applications.user_id')
        ->select('applications.id', 'applications.user_id', 'applications.pub_id', 'applications.created_at', DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as name"), 'others.Q40a', 'others.Q40b', 'others.Q40c', 'personals.sex')
        ->where('applications.status', '!=', '2')
        ->leftJoin('personals', 'personals.user_id', 'users.id')
        ->leftJoin('others', 'others.user_id', 'users.id')
        // ->with('user', 'user.pdsPersonal')
        // ->with('user', 'user.pdsOther')
        // ->with('publication')
        ->get();

        $ranking = $this->ranking($all_applicants);
        return response()->json($ranking, Response::HTTP_OK);
    }

    public function getAccepted()
    {
        $all_applicants = $this->application->where('applications.status', '0')->join('users', 'users.id', '=', 'applications.user_id')
        ->select('applications.id', 'applications.user_id', 'applications.pub_id', 'applications.created_at', DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as name"))
        ->with('user', 'user.pdsPersonal')->with('publication')->get();

        return response()->json($all_applicants, Response::HTTP_OK);
    }
    public function paginateArray($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    private function ranking($applicants)
    {
        // // $total_lnd = 0;
        // $percent = 0;
        // $rank = [];
        // $ctr = 0;
        // foreach ($applicants as $app) {
        //     if ($app->publication->status == 1) {
        //         $over_all = 0;
        //         for ($i = 0; $i < count($app->InterviewExamRaters); $i++) {
        //             $sum = 0;
        //             if($app->AdditionalPointsRaters && count($app->AdditionalPointsRaters) > $i) {
        //                 if($app->AdditionalPointsRaters[$i]->experience) {
        //                     $sum += round($app->AdditionalPointsRaters[$i]->experience * .15, 2);
        //                 }
        //                 if($app->AdditionalPointsRaters[$i]->education) {
        //                     $sum += $app->AdditionalPointsRaters[$i]->education * .15;
        //                 }
        //                 if($app->AdditionalPointsRaters[$i]->eligibility) {
        //                     $sum += round($app->AdditionalPointsRaters[$i]->eligibility * .10, 2);
        //                 }
        //             }
        //             if($app->InterviewExamRaters && count($app->InterviewExamRaters) > $i) {
        //                 if($app->InterviewExamRaters[$i]->written_exam) {
        //                     $sum += round($app->InterviewExamRaters[$i]->written_exam * .1, 2);
        //                 }
        //                 if($app->InterviewExamRaters[$i]->oral_exam) {
        //                     $sum += round($app->InterviewExamRaters[$i]->oral_exam * .1, 2);
        //                 }
        //                 if($app->InterviewExamRaters[$i]->background) {
        //                     $sum += round($app->InterviewExamRaters[$i]->background * .1, 2);
        //                 }
        //                 if($app->InterviewExamRaters[$i]->performance) {
        //                     $sum += round($app->InterviewExamRaters[$i]->performance * .1, 2);
        //                 }
        //                 if($app->InterviewExamRaters[$i]->pspt) {
        //                     $sum += round($app->InterviewExamRaters[$i]->pspt * .1, 2);
        //                 }
        //                 if($app->InterviewExamRaters[$i]->potential) {
        //                     $sum += round($app->InterviewExamRaters[$i]->potential * .1, 2);
        //                 }
        //             }
        //             $over_all += round($sum, 2);
        //         }
        //         if($over_all > 0) {
        //             $over_all = round($over_all / count($app->InterviewExamRaters), 2);
        //         }
        //         // $percent = $over_all;
        //         $total = ['total' => $over_all];
        //         $app = $app->toArray();
        //         $rank[$ctr] = array_merge($app, $total);
        //         $ctr++;

        //         $percent = 0;
        //     }
        // }
        // return collect($rank)->sortByDesc('total');


        // Assuming $applicants is the array of applicants
        $rank = [];
        $ctr = 0;

        foreach ($applicants as $app) {

            // Check if $app->publication exists and has status property
            if (isset($app->publication) && $app->publication->status == 1) {
                $over_all = 0;

                // Check if $app->InterviewExamRaters is not empty
                
                if (!empty($app->AdditionalPointsRaters)) {
                    for ($i = 0; $i < count($app->AdditionalPointsRaters); $i++) {
                        $sum = 0;

                        // Check if $app->AdditionalPointsRaters is not empty and has the expected structure
                        if (!empty($app->AdditionalPointsRaters) && count($app->AdditionalPointsRaters) > $i) {
                            if($app->AdditionalPointsRaters[$i]->experience) {
                                $sum += round($app->AdditionalPointsRaters[$i]->experience * .15, 2);
                            }
                            if($app->AdditionalPointsRaters[$i]->education) {
                                $sum += $app->AdditionalPointsRaters[$i]->education * .15;
                            }
                            if($app->AdditionalPointsRaters[$i]->eligibility) {
                                $sum += round($app->AdditionalPointsRaters[$i]->eligibility * .10, 2);
                            }
                        }

                        // Check if $app->InterviewExamRaters is not empty and has the expected structure
                        if (!empty($app->InterviewExamRaters) && count($app->InterviewExamRaters) > $i) {
                            if($app->InterviewExamRaters[$i]->written_exam) {
                                $sum += round($app->InterviewExamRaters[$i]->written_exam * .1, 2);
                            }
                            if($app->InterviewExamRaters[$i]->oral_exam) {
                                $sum += round($app->InterviewExamRaters[$i]->oral_exam * .1, 2);
                            }
                            if($app->InterviewExamRaters[$i]->background) {
                                $sum += round($app->InterviewExamRaters[$i]->background * .1, 2);
                            }
                            if($app->InterviewExamRaters[$i]->performance) {
                                $sum += round($app->InterviewExamRaters[$i]->performance * .1, 2);
                            }
                            if($app->InterviewExamRaters[$i]->pspt) {
                                $sum += round($app->InterviewExamRaters[$i]->pspt * .1, 2);
                            }
                            if($app->InterviewExamRaters[$i]->potential) {
                                $sum += round($app->InterviewExamRaters[$i]->potential * .1, 2);
                            }
                        }

                        $over_all += round($sum, 2);
                    }

                    if ($over_all > 0) {
                        $over_all = round($over_all / count($app->InterviewExamRaters), 2);
                    }

                    $total = ['total' => $over_all];
                    $appArray = $app->toArray();
                    $rank[$ctr] = array_merge($appArray, $total);
                    $ctr++;

                    $percent = 0;
                }
            }
        }

        // Assuming you want to sort the resulting collection by 'total'
        return collect($rank)->sortByDesc('total');

    }
    private function app_ranking($applicants)
    {
        // $total_lnd = 0;
        $percent = 0;
        $total_WE = 0;
        $total_educ = 0;
        $eligibility = false;
        $rank = [];
        $ctr = 0;
        foreach ($applicants as $app) {
            if ($app->publication->status == 1) {
                // foreach ($app->user->pdsLearningDevelopment as $lnd) {
                //     $total_lnd += $lnd->LDnumhour;
                // }

                // work experience
                if ($app->publication->experience) {
                    $experience = preg_replace('/[^0-9]/', '', $app->publication->experience);
                    if (!$experience == 0) {
                        $xp = $experience * 365;
                        foreach ($app->user->pdsWorkExperience as $WE) {
                            $toDate = Carbon::parse($WE->WEidto);
                            $fromDate = Carbon::parse($WE->WEidfrom);

                            $total_WE +=  $toDate->diffInDays($fromDate);
                        }

                        $total_WE = round((($total_WE / $xp) * 10), 2);

                        if ($total_WE > 0 && $total_WE <= 10) {
                            $total_WE = $total_WE;
                        } elseif ($total_WE > 10) {
                            $total_WE = 10;
                        } elseif ($total_WE < 0) {
                            $total_WE = 0;
                        }
                    }
                }
                //  education
                if ($app->publication->education) {
                    $education = preg_replace('/[^0-9]/', '', $app->publication->education);
                    if (!$education == null) {
                        $educ_xp = $education * 365;
                        foreach ($app->user->pdsEducational as $educ) {
                            if ($educ->EDlevel == 'College') {
                                $toDate = Carbon::parse($educ->EDpoaFROM);
                                $fromDate = Carbon::parse($educ->EDpoaTO);

                                $total_educ +=  $toDate->diffInDays($fromDate);

                                $total_educ = round((($total_educ / $educ_xp) * 10), 2);
                            }
                        }
                        if ($total_educ <= 10 && $total_educ > 0) {
                            $percent += $total_educ;
                        }
                    } else {
                        $percent += 15;
                    }
                }
                // eligibility
                if (!$app->eligibility) {
                    $percent += 15;
                } else {
                    if ($app->user->pdsCivilService) {
                        $percent += 15;
                    }
                }
                // training

                // if ($app->publication->trainig) {
                //     $trainig = preg_replace('/[^0-9]/', '', $app->publication->trainig);
                //     if (!$trainig == 0) {
                //         foreach ($app->user->pdsLearningDevelopment as $lnd) {
                //             $total_trainig =  $lnd->LDnumhour;
                //             $total_trainig = round((($total_trainig/$trainig)*10), 2);

                //             if ($total_trainig > 0 && $total_trainig <= 10) {
                //                 $percent +=$total_trainig;
                //             }
                //         }
                //     } else {
                //         $percent += 10;
                //     }
                // }

                if ($app->InterviewExam) {
                    if ($app->InterviewExam->written_exam) {
                        $percent += $app->InterviewExam->written_exam;
                    }
                    if ($app->InterviewExam->oral_exam) {
                        $percent += $app->InterviewExam->oral_exam;
                    }
                    if ($app->InterviewExam->background) {
                        $percent += $app->InterviewExam->background;
                    }
                    if ($app->InterviewExam->performance) {
                        $percent += $app->InterviewExam->performance;
                    }
                    if ($app->InterviewExam->pspt) {
                        $percent += $app->InterviewExam->pspt;
                    }
                    if ($app->InterviewExam->potential) {
                        $percent += $app->InterviewExam->potential;
                    }
                }

                $percent += $total_WE;
                $rank[$ctr] = [
                    'user' => $app->user,
                    'app' => $app,
                    'total' => $percent,
                ];
                $ctr++;

                $percent = 0;
                $total_WE = 0;
                $education_college = false;
                $eligibility = false;
            }
        }
        return collect($rank)->sortByDesc('total')->toArray();
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
        //
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
        $all_applicants = $this->application
        ->leftJoin('users', 'users.id', '=', 'applications.user_id')
        ->select('applications.id', 'applications.user_id', 'applications.pub_id', 'applications.created_at', DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as name", 'publication.title as position'))
        ->where('applications.status', '!=', '2')
        ->with('publication')
        ->where('applications.pub_id', $id)->get();
        $hrmpsb = hrmpsb::all();
        $publication = $this->publication->findOrFail($id);
        
        $ranking = $this->ranking($all_applicants);
        return view('print.rangking_applicant')
        ->with('ranking', $ranking)
        ->with('hrmpsb', $hrmpsb)
        ->with('publication', $publication);
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
