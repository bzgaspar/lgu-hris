<?php

namespace App\Http\Controllers;

use App\Models\admin\Department;
use App\Models\admin\EmployeePlantilla;
use App\Models\hr\hrmpsb;
use App\Models\hr\InterviewExam;
use App\Models\hr\LeaveCredit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\hr\Publication;
use App\Models\hr\ServiceRecord;
use App\Models\hr\YearlyIPCR;
use App\Models\LeaveApplication;
use App\Models\pds\civilservice;
use App\Models\pds\personal;
use App\Models\reference\earned;
use App\Models\reference\hours;
use App\Models\reference\minutes;
use App\Models\users\application;
use App\Models\users\Ipcr;
use App\Models\users\others;
use App\Models\users\Signature;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private $publication;
    private $user;
    private $civilservice;

    public function __construct(Publication $publication, User $user, civilservice $civilservice)
    {
        $this->publication = $publication;
        $this->user = $user;
        $this->civilservice = $civilservice;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $publication = $this->publication->where('status', '1')->paginate(12);
        return view('publication')->with('publication', $publication);
    }

    public function getUserPds()
    {
        $user_pds = $this->user
        ->where('id', Auth::user()->id)
        ->with('pdsPersonal')
        ->with('pdsCivilService')
        ->get();
        $data = [
            'user_pds' =>  $user_pds,
        ];

        return response()->json($data, Response::HTTP_OK);
    }
    public function getUser()
    {
        $user = User::findOrFail(Auth::user()->id);

        return response()->json($user, Response::HTTP_OK);
    }
    public function getAllUser()
    {
        $user = $this->user
        ->select('users.id', 'users.email', 'users.role', DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as name"))
        ->with('empPlantilla', 'empPlantilla.department', 'empPlantilla.designation')
        ->with('pdsPersonal')
        ->latest()
        ->get();
        return response()->json($user, Response::HTTP_OK);
    }
    public function getHrmpsbUser()
    {
        $user = hrmpsb::leftJoin('users', 'users.id', 'hrmpsbs.user_id')
        ->select('hrmpsbs.id as id', 'hrmpsbs.position as position', 'users.role', DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as name"))
        ->get();
        return response()->json($user, Response::HTTP_OK);
    }
    public function getLeave()
    {
        $user = $this->user
        ->select('users.id', 'users.email', 'users.role', DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as name"))
        ->with('empPlantilla', 'empPlantilla.department')
        ->with('pdsPersonal')
        ->with('leaveCreditlatest')
        ->where('users.role', '!=', '1')
        ->where('users.id', '!=', '1')
        ->where('users.id', '!=', '2')
        ->latest()
        ->get();
        return response()->json($user, Response::HTTP_OK);
    }
    public function getUserLeave($user_id)
    {
        $leave = LeaveCredit::where('user_id', $user_id)->orderByDesc('elc_period_from')->first();
        return response()->json($leave, Response::HTTP_OK);
    }
    public function getLeaveCredit($user_id)
    {
        $leave = LeaveCredit::where('user_id', $user_id)->orderByDesc('elc_period_from')->get();
        return response()->json($leave, Response::HTTP_OK);
    }
    public function getLeaveApp()
    {
        $leave_app = LeaveApplication::leftJoin('users', 'users.id', '=', 'leave_applications.user_id')
        ->select('leave_applications.id', 'leave_applications.user_id', 'leave_applications.type', 'leave_applications.created_at', 'leave_applications.date_from', 'leave_applications.status', 'leave_applications.date_to', DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as name"))
        ->with('users', 'users.empPlantilla.department', 'users.pdsPersonal')
        ->latest()
        ->get();
        return response()->json($leave_app, Response::HTTP_OK);
    }
    public function getServiceRecord()
    {
        $service_record = User::select('users.id', 'users.email', 'users.role', DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as name"))
        ->with('empPlantilla', 'empPlantilla.designation', 'empPlantilla.department')
        ->with('pdsPersonal')
        ->where('users.role', '!=', '1')
        ->where('users.id', '!=', '1')
        ->where('users.id', '!=', '2')
        ->get();
        return response()->json($service_record, Response::HTTP_OK);
    }

    public function getPlantilla()
    {
        $emp_plantilla = EmployeePlantilla::leftJoin('users', 'users.id', '=', 'employee_plantillas.user_id')->leftJoin('personals', 'users.id', '=', 'personals.user_id')
        ->select(
            'employee_plantillas.id',
            'employee_plantillas.EPdesignation',
            'employee_plantillas.status',
            'employee_plantillas.dep_id',
            'employee_plantillas.EPno',
            'employee_plantillas.EPposition',
            'employee_plantillas.user_id',
            DB::raw("CONCAT(`personals`.`first_name`,' ',`personals`.`middle_name`,' ',`personals`.`last_name`) as name")
        )
        ->with('department')
        ->with('designation')
        ->with('user', 'user.pdsPersonal')
        ->orderBy('employee_plantillas.EPno')
        ->get();



        return response()->json($emp_plantilla, Response::HTTP_OK);
    }

    public function getDepartment()
    {
        $department = Department::orderBy('dep_id')->get();
        return response()->json($department, Response::HTTP_OK);
    }
    public function getDepartmentIPCR($year)
    {
        $department = Department::select('id', 'name')->orderBy('dep_id')->get();
        $deps = [];
        foreach($department as $item) {
            if(!YearlyIPCR::where('year', $year)->where('dep_id', $item->id)->exists()) {
                array_push($deps, $item);
            }
        }
        return response()->json($department, Response::HTTP_OK);
    }
    public function getPublication()
    {
        $publication = Publication::where('status', '1')->orderBy('title')->get();
        return response()->json($publication, Response::HTTP_OK);
    }
    public function getAverage($dep_id)
    {

        $average = 0;
        if($dep_id ==15) {
            $ratings = Ipcr::join('users', 'users.id', 'ipcrs.user_id')
            ->join('employee_plantillas', 'users.id', 'employee_plantillas.user_id')
            ->join('departments', 'departments.id', 'employee_plantillas.dep_id')
            ->select('departments.id', 'ipcrs.from', 'ipcrs.to', 'ipcrs.rating')
            ->where('departments.id', $dep_id)
            ->where('users.role', 7)
            ->get();
        } elseif($dep_id == 1) {
            $ratings = Ipcr::join('users', 'users.id', 'ipcrs.user_id')
            ->join('employee_plantillas', 'users.id', 'employee_plantillas.user_id')
            ->join('departments', 'departments.id', 'employee_plantillas.dep_id')
            ->select('departments.id', 'ipcrs.from', 'ipcrs.to', 'ipcrs.rating')
            ->where('departments.id', $dep_id)
            ->where('users.role', 5)
            ->get();
        } else {
            $ratings = Ipcr::join('users', 'users.id', 'ipcrs.user_id')
            ->join('employee_plantillas', 'users.id', 'employee_plantillas.user_id')
            ->join('departments', 'departments.id', 'employee_plantillas.dep_id')
            ->select('departments.id', 'ipcrs.from', 'ipcrs.to', 'ipcrs.rating')
            ->where('departments.id', $dep_id)
            ->where('users.role', '3')
            ->get();
        }
        foreach($ratings as $rating) {
            $average += $rating->rating;
        }
        return response()->json(round($average/2, 2), Response::HTTP_OK);
    }
    public function getYearlyRating()
    {

        $ratings = YearlyIPCR::leftJoin('departments', 'departments.id', 'yearly_i_p_c_r_s.dep_id')
        ->select('departments.name as dep_name', 'yearly_i_p_c_r_s.year as year', 'yearly_i_p_c_r_s.total as rating', 'yearly_i_p_c_r_s.id as id')
        ->orderByDesc('yearly_i_p_c_r_s.total')
        ->get();
        return response()->json($ratings, Response::HTTP_OK);
    }
    public function getYearlyTopRating()
    {

        $ratings = YearlyIPCR::join('departments', 'departments.id', 'yearly_i_p_c_r_s.dep_id')
        ->select('departments.name as dep_name', 'yearly_i_p_c_r_s.year as year', 'yearly_i_p_c_r_s.total as rating')
        ->get();
        return response()->json($ratings, Response::HTTP_OK);
    }

    public function getApplicants()
    {
        $publication = application::LeftJoin('users', 'users.id', '=', 'applications.user_id')
        ->select('applications.id', 'applications.user_id', 'applications.pub_id', 'applications.created_at', DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as name"))
        ->with('user', 'user.pdsPersonal')
        ->with('publication')
        ->orderBy('created_at')->get();
        return response()->json($publication, Response::HTTP_OK);
    }

    public function getEmployee()
    {
        $all_ipcr = Ipcr::leftJoin('users', 'users.id', '=', 'ipcrs.user_id')
        ->select('ipcrs.id', 'ipcrs.user_id', 'ipcrs.from', 'ipcrs.to', 'ipcrs.rating', 'ipcrs.equivalent', DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as name"))
        ->with('user', 'user.pdsPersonal', 'user.empPlantilla.department')
        ->orderByDesc('rating')
        ->get();

        return response()->json($all_ipcr, Response::HTTP_OK);
    }
    public function getDepartmentHead()
    {
        $all_ipcr = Ipcr::leftJoin('users', 'users.id', '=', 'ipcrs.user_id')
        ->select('users.id', 'ipcrs.id', 'ipcrs.user_id', 'ipcrs.from', 'ipcrs.to', 'ipcrs.rating', 'ipcrs.equivalent', DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as name"))
        ->whereHas('User', function ($query) {
            $query->DepartmentHead();
        })
        ->orWhere('users.role', 7)
        ->with('user', 'user.pdsPersonal', 'user.empPlantilla.department')
        ->orderByDesc('rating')
        ->get();

        return response()->json($all_ipcr, Response::HTTP_OK);
    }
    public function getTop5()
    {
        $all_ipcr = Ipcr::join('users', 'users.id', '=', 'ipcrs.user_id')
        ->join('employee_plantillas', 'employee_plantillas.user_id', 'users.id')
        ->join('departments', 'employee_plantillas.dep_id', 'departments.id')
        ->select('users.id', 'ipcrs.id', 'ipcrs.user_id', 'ipcrs.from', 'ipcrs.to', 'ipcrs.rating', 'ipcrs.equivalent', 'departments.name')
        ->whereHas('User', function ($query) {
            $query->DepartmentHead();
        })
        ->with('user', 'user.pdsPersonal', 'user.empPlantilla')
        ->orderByDesc('rating')
        ->get();

        return response()->json($all_ipcr, Response::HTTP_OK);
    }
    public function getYearsIPCR()
    {
        $old_year = "2022";
        $year = [];
        $all_ipcr = Ipcr::latest()->get();
        foreach($all_ipcr as $item) {
            $current_year = date('Y', strtotime($item->from));
            if(!in_array($current_year, $year)) {
                if(!YearlyIPCR::where('year', $current_year)->exists()) {
                    array_push($year, $current_year);
                }
            }
        }
        return response()->json($year, Response::HTTP_OK);
    }
    public function getYearsIPCR2()
    {
        $year = [];
        $all_ipcr = Ipcr::latest()->get();
        foreach($all_ipcr as $item) {
            $current_year = date('Y', strtotime($item->from));
            if(!in_array($current_year, $year)) {
                array_push($year, $current_year);
            }
        }
        return response()->json($year, Response::HTTP_OK);
    }

    public function getPreviousLeave($user_id, $leave_card_id)
    {
        $prev_leave = LeaveCredit::where('user_id', $user_id)->where('id', '<', $leave_card_id)->orderByDesc('elc_period_from')->first();

        return response()->json($prev_leave, Response::HTTP_OK);
    }


    public function getHour()
    {

        $hours = hours::get();

        return response()->json($hours, Response::HTTP_OK);
    }
    public function getEarn()
    {

        $earned = earned::get();

        return response()->json($earned, Response::HTTP_OK);
    }
    public function getMinute()
    {

        $minutes = minutes::get();

        return response()->json($minutes, Response::HTTP_OK);
    }

    public function setStorage()
    {
        Artisan::call('storage:link');
        dd(Artisan::output());
    }
    public function getLoyalty()
    {
        $loyalty = User::leftJoin('employee_plantillas', 'users.id', '=', 'employee_plantillas.user_id')
        ->leftJoin('departments', 'departments.id', '=', 'employee_plantillas.dep_id')
        ->leftJoin('loyalty_records', 'users.id', '=', 'loyalty_records.user_id')
        ->leftJoin('personals', 'users.id', '=', 'personals.user_id')
        ->select('users.id', DB::raw("CONCAT(`users`.`first_name`,' ',' ',`users`.`last_name`) as emp_name"), 'departments.name', 'departments.name', 'departments.name', 'employee_plantillas.EPposition', 'loyalty_records.year_difference', 'loyalty_records.next_loyalty')
        ->where('users.role', '!=', '1')
        ->where('users.id', '!=', '1')
        ->where('users.id', '!=', '2')
        ->get();

        return response()->json($loyalty, Response::HTTP_OK);
    }
    public static function getTBL($id, $leave)
    {
        $monthly = ServiceRecord::where('user_id', $id)->orderByDesc('from')->first();
        if($monthly) {
            $tbl = $monthly->salary * $leave * 0.0481927;
            return number_format($tbl, 2, ".", ",");
        } else {
            return 0;
        }
    }
    public static function getHighest_salary($id)
    {
        $monthly = ServiceRecord::where('user_id', $id)->orderByDesc('from')->first();
        if($monthly) {
            return $monthly->salary;
        } else {
            return 0;
        }
    }
    public static function getFullName($id)
    {
        $users = User::LeftJoin('personals', 'users.id', '=', 'personals.user_id')
            ->leftJoin('employee_plantillas', 'employee_plantillas.user_id', '=', 'users.id')
            ->select('personals.first_name', 'personals.salutation_before', 'personals.salutation_after', 'personals.ext_name', 'personals.middle_name', 'personals.last_name', 'employee_plantillas.EPposition as position')
            ->where('users.id', $id)->first();
        $full_name =
        $users->first_name . ' ' .
        substr($users->middle_name, 0, 1) . '. ' .
        $users->last_name;
        $salutation_before = '';
        $ext_name = '';
        $salutation_after = '';

        if($users->salutation_before && strtolower($users->salutation_before) != 'n/a') {
            $salutation_before = $users->salutation_before;
        }
        if($users->salutation_after && strtolower($users->salutation_after) != 'n/a') {
            $salutation_after = $users->salutation_after;
        }
        if(strtolower($users->ext_name) != 'n/a') {
            $full_name = $full_name .' ' .$users->ext_name;
        }

        $full_name =$salutation_before . ' ' . $full_name .' ' .$ext_name . ', '.  $salutation_after;

        return [
            'full_name' => $full_name,
            'position' => $users->position,
        ];
    }
    public static function getHRHeadSignature()
    {
        $user = User::leftjoin('signatures', 'signatures.user_id', 'users.id')
        ->select('signatures.signature')
        ->where('users.role', 7)->first();

        if($user) {
            return $user->signature;
        } else {
            return null;
        }
    }
    public static function getDepartmentHeadLeave($id)
    {
        $user = User::findOrFail($id);
        if($user) {
            $user_designation = $user->empPlantilla->designation->id;
            $user_dep = $user->empPlantilla->dep_id;


            if($user_dep != 15) {
                $dep_head = EmployeePlantilla::leftJoin('users', 'employee_plantillas.user_id', 'users.id')
                ->leftJoin('personals', 'users.id', '=', 'personals.user_id')
                ->select('users.id as id', 'personals.first_name', 'personals.salutation_before', 'personals.salutation_after', 'personals.middle_name', 'personals.last_name')
            ->where('employee_plantillas.dep_id', $user_dep)->where('users.role', 3)->first();
            } elseif($user_dep == 1) {
                $dep_head = EmployeePlantilla::leftJoin('users', 'employee_plantillas.user_id', 'users.id')
                ->leftJoin('personals', 'users.id', '=', 'personals.user_id')
                ->select('users.id as id', 'personals.first_name', 'personals.salutation_before', 'personals.salutation_after', 'personals.middle_name', 'personals.last_name')
            ->where('employee_plantillas.dep_id', $user_dep)->where('users.role', 5)->first();
            } else {
                $dep_head = EmployeePlantilla::leftJoin('users', 'employee_plantillas.user_id', 'users.id')
                ->leftJoin('personals', 'users.id', '=', 'personals.user_id')
                ->select('users.id as id', 'personals.first_name', 'personals.salutation_before', 'personals.salutation_after', 'personals.middle_name', 'personals.last_name')
            ->where('employee_plantillas.dep_id', $user_dep)->where('users.role', 7)->first();
            }
            if(!$dep_head) {
                $dep_head = EmployeePlantilla::leftJoin('users', 'employee_plantillas.user_id', 'users.id')
                ->leftJoin('personals', 'users.id', '=', 'personals.user_id')
                ->select('users.id as id', 'personals.first_name', 'personals.salutation_before', 'personals.salutation_after', 'personals.middle_name', 'personals.last_name')
                ->where('employee_plantillas.dep_id', $user_designation)->where('users.role', 7)->first();
            }

            if($dep_head) {
                $signature = Signature::where('user_id', $dep_head->id)->first();
                $full_name =
                $dep_head->first_name . ' ' .
                substr($dep_head->middle_name, 0, 1) . '. ' .
                $dep_head->last_name;

                $salutation_before = '';
                $ext_name = '';
                $salutation_after = '';

                if($dep_head->salutation_before && strtolower($dep_head->salutation_before) != 'n/a') {
                    $salutation_before = $dep_head->salutation_before;
                }
                if($dep_head->salutation_after && strtolower($dep_head->salutation_after) != 'n/a') {
                    $salutation_after = $dep_head->salutation_after;
                }
                if(strtolower($dep_head->ext_name) != 'n/a') {
                    $full_name = $full_name .' ' .$dep_head->ext_name;
                }

                $full_name =$salutation_before . ' ' . $full_name .' ' .$ext_name . ', '.  $salutation_after;



                if($signature) {
                    $sig = $signature->signature;
                } else {
                    $sig = null;
                }
                $details = [
                    'full_name' => $full_name,
                    'signature' => $sig,
                ];
                return $details;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
    public static function getHRHead()
    {

        $hr_head = User::where('role', 7)->first();
        $user = User::findOrFail($hr_head->id);
        if($user) {

            $dep_head = User::leftJoin('personals', 'users.id', '=', 'personals.user_id')
            ->select('users.id as id', 'personals.first_name', 'personals.salutation_before', 'personals.salutation_after', 'personals.middle_name', 'personals.last_name')
            ->Where('users.role', 7)->first();

            if($dep_head) {


                $signature = Signature::where('user_id', $dep_head->id)->first();
                $full_name =
                $dep_head->first_name . ' ' .
                substr($dep_head->middle_name, 0, 1) . '. ' .
                $dep_head->last_name;

                $salutation_before = '';
                $ext_name = '';
                $salutation_after = '';

                if($dep_head->salutation_before && strtolower($dep_head->salutation_before) != 'n/a') {
                    $salutation_before = $dep_head->salutation_before;
                }
                if($dep_head->salutation_after && strtolower($dep_head->salutation_after) != 'n/a') {
                    $salutation_after = $dep_head->salutation_after;
                }
                if(strtolower($dep_head->ext_name) != 'n/a') {
                    $full_name = $full_name .' ' .$dep_head->ext_name;
                }

                $full_name =$salutation_before . ' ' . $full_name .' ' .$ext_name . ', '.  $salutation_after;

                if($signature) {
                    $sig = $signature->signature;
                } else {
                    $sig = null;
                }

                $details = [
                    'full_name' => $full_name,
                    'signature' => $sig,
                ];
                return $details;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }


    public function getChartEMP()
    {


        $permanent = EmployeePlantilla::where('status', 1)->count();
        $terminos = EmployeePlantilla::where('status', 2)->count();
        $cos = EmployeePlantilla::where('status', 3)->count();
        $appointed = EmployeePlantilla::where('status', 4)->count();
        $elective = EmployeePlantilla::where('status', 5)->count();
        $total = $permanent + $cos +$terminos+$appointed+$elective;

        $Indigenous = others::join('employee_plantillas', 'employee_plantillas.user_id', 'others.user_id')->where('Q40a1', '!=', null)->count();
        $PWD = others::join('employee_plantillas', 'employee_plantillas.user_id', 'others.user_id')->where('Q40b1', '!=', null)->count();
        $Single_Parent = others::join('employee_plantillas', 'employee_plantillas.user_id', 'others.user_id')->where('Q40c1', '!=', null)->count();

        $male = personal::join('employee_plantillas', 'employee_plantillas.user_id', 'personals.user_id')->where('sex', 'Male')->count();
        $female = Personal::join('employee_plantillas', 'employee_plantillas.user_id', 'personals.user_id')->where('sex', '!=', 'Male')->count();

        $religion = others::join('employee_plantillas', 'employee_plantillas.user_id', 'others.user_id')->select('others.IDc1', DB::raw('COUNT(*) as count'))
        ->groupBy('others.IDc1')
        ->get();

        $rel_count = array_reduce($religion->toArray(), function ($carry, $item) {
            $index = $item['IDc1'];
            $carry[$index] = $item['count'];
            return $carry;
        }, []);

        $data[0] = $rel_count;
        $data[1] = [
            'Permanent' => $permanent,
            'Coterminous' => $terminos,
            'Casual' => $cos,
            'Appointed' => $appointed,
            'Elective' => $elective,
        ];
        $data[2]= [

            'Indigenous' => $Indigenous,
            'PWD' => $PWD,
            'Single Parent' => $Single_Parent,
            'N/A' => $total- ($Indigenous+$PWD+$Single_Parent),
        ];
        $data[3]= [

            'Male' => $male,
            'Female' => $female,
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    public function fetchRatings()
    {
        $all_rating = application::join('interview_exams', 'interview_exams.app_id', 'applications.id')
        ->leftJoin('users as rater', 'rater.id', 'interview_exams.rater_id')
        ->join('users', 'users.id', 'interview_exams.user_id')
        ->select(
            'interview_exams.id',
            'interview_exams.written_exam',
            'interview_exams.oral_exam',
            'interview_exams.background',
            'interview_exams.performance',
            'interview_exams.pspt',
            'interview_exams.potential',
            DB::raw("CONCAT(`users`.`first_name`,' ',' ',`users`.`last_name`) as app_name"),
            DB::raw("CONCAT(`rater`.`first_name`,' ',' ',`rater`.`last_name`) as rater_name")
        )
        ->groupBy('interview_exams.id')
        ->get();
        return response()->json($all_rating, Response::HTTP_OK);
    }
    public function fetchRatingsAdd()
    {
        $all_rating = application::join('additional_points', 'additional_points.app_id', 'applications.id')
        ->leftJoin('users as rater', 'rater.id', 'additional_points.rater_id')
        ->join('users', 'users.id', 'additional_points.user_id')
        ->select(
            'additional_points.id',
            'additional_points.education',
            'additional_points.eligibility',
            'additional_points.experience',
            DB::raw("CONCAT(`users`.`first_name`,' ',' ',`users`.`last_name`) as app_name"),
            DB::raw("CONCAT(`rater`.`first_name`,' ',' ',`rater`.`last_name`) as rater_name")
        )
        ->groupBy('additional_points.id')
        ->get();
        return response()->json($all_rating, Response::HTTP_OK);
    }
}
