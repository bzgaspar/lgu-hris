<?php

namespace App\Http\Controllers;

use App\Models\admin\Department;
use App\Models\admin\EmployeePlantilla;
use App\Models\hr\hrmpsb;
use App\Models\hr\LeaveCredit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\hr\Publication;
use App\Models\hr\ServiceRecord;
use App\Models\hr\YearlyIPCR;
use App\Models\LeaveApplication;
use App\Models\pds\civilservice;
use App\Models\reference\earned;
use App\Models\reference\hours;
use App\Models\reference\minutes;
use App\Models\users\application;
use App\Models\users\Ipcr;
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
        ->orderByDesc('leaveCreditlatest.elc_period_from')
        ->where('users.role', '!=', '1')
        ->where('users.id', '!=', '1')
        ->where('users.id', '!=', '2')
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
            $current_year = Carbon::createFromFormat('m/d/Y', $item->from)->format('Y');
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
        $old_year = "2022";
        $year = [];
        $all_ipcr = Ipcr::latest()->get();
        foreach($all_ipcr as $item) {
            $current_year = Carbon::createFromFormat('m/d/Y', $item->from)->format('Y');
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
            ->select('users.first_name', 'personals.salutation_before', 'personals.salutation_after', 'personals.ext_name', 'personals.middle_name', 'users.last_name', 'employee_plantillas.EPposition as position')
            ->where('users.id', $id)->first();

        if($users->salutation_before  && $users->salutation_after) {
            $full_name =
            $users->salutation_before .
            $users->first_name . ' ' .
            substr($users->middle_name, 0, 1) . '. ' .
            $users->last_name . ' ' .
            $users->ext_name .
            $users->salutation_after;
        } elseif($users->salutation_before) {
            $full_name =
            $users->salutation_before .
            $users->first_name . ' ' .
            substr($users->middle_name, 0, 1) . '. ' .
            $users->last_name . ' ' .
            $users->ext_name;
        } elseif($users->salutation_after) {
            $full_name =
            $users->first_name . ' ' .
            substr($users->middle_name, 0, 1) . '. ' .
            $users->last_name . ' ' .
            $users->ext_name .
            $users->salutation_after;
        } else {
            $full_name =
            $users->first_name . ' ' .
            substr($users->middle_name, 0, 1) . '. ' .
            $users->last_name . ' ' .
            $users->ext_name;
        }

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
            $user_dep = $user->empPlantilla->department->id;

            $dep_head = User::leftJoin('personals', 'users.id', '=', 'personals.user_id')
            ->join('employee_plantillas', 'employee_plantillas.user_id', 'users.id')
            ->join('signatures', 'signatures.user_id', 'users.id')
            ->select('users.first_name', 'personals.salutation_before', 'personals.salutation_after', 'personals.middle_name', 'users.last_name', 'signatures.signature as signature')
            ->where('employee_plantillas.dep_id', $user_dep)
            ->where('users.role', 3)->orWhere('users.role', 7)->first();


            if($dep_head) {

                if($dep_head->salutation_before  && $dep_head->salutation_after) {
                    $full_name =
                    $dep_head->salutation_before .
                    $dep_head->first_name . ' ' .
                    substr($dep_head->middle_name, 0, 1) . '. ' .
                    $dep_head->last_name . ' ' .
                    $dep_head->ext_name .
                    $dep_head->salutation_after;
                } elseif($dep_head->salutation_before) {
                    $full_name =
                    $dep_head->salutation_before .
                    $dep_head->first_name . ' ' .
                    substr($dep_head->middle_name, 0, 1) . '. ' .
                    $dep_head->last_name. ' ' .
                    $dep_head->ext_name;
                } elseif($dep_head->salutation_after) {
                    $full_name =
                    $dep_head->first_name . ' ' .
                    substr($dep_head->middle_name, 0, 1) . '. ' .
                    $dep_head->last_name. ' ' .
                    $dep_head->ext_name .
                    $dep_head->salutation_after;
                } else {
                    $full_name =
                    $dep_head->first_name . ' ' .
                    substr($dep_head->middle_name, 0, 1) . '. ' .
                    $dep_head->last_name. ' ' .
                    $dep_head->ext_name;
                }

                $details = [
                    'full_name' => $full_name,
                    'signature' => $dep_head->signature,
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
            $user_dep = $user->empPlantilla->department->id;

            $dep_head = User::leftJoin('personals', 'users.id', '=', 'personals.user_id')
            ->join('employee_plantillas', 'employee_plantillas.user_id', 'users.id')
            ->join('signatures', 'signatures.user_id', 'users.id')
            ->select('users.first_name', 'personals.salutation_before', 'personals.salutation_after', 'personals.middle_name', 'users.last_name', 'signatures.signature as signature')
            ->where('employee_plantillas.dep_id', $user_dep)
            ->where('users.role', 3)->orWhere('users.role', 7)->first();


            if($dep_head) {
                if($dep_head->salutation_before  && $dep_head->salutation_after) {
                    $full_name =
                    $dep_head->salutation_before .
                    $dep_head->first_name . ' ' .
                    substr($dep_head->middle_name, 0, 1) . '. ' .
                    $dep_head->last_name. ' ' .
                    $dep_head->ext_name .
                    $dep_head->salutation_after;
                } elseif($dep_head->salutation_before) {
                    $full_name =
                    $dep_head->salutation_before .
                    $dep_head->first_name . ' ' .
                    substr($dep_head->middle_name, 0, 1) . '. ' .
                    $dep_head->last_name. ' ' .
                    $dep_head->ext_name;
                } elseif($dep_head->salutation_after) {
                    $full_name =
                    $dep_head->first_name . ' ' .
                    substr($dep_head->middle_name, 0, 1) . '. ' .
                    $dep_head->last_name . ' ' .
                    $dep_head->ext_name.
                    $dep_head->salutation_after;
                } else {
                    $full_name =
                    $dep_head->first_name . ' ' .
                    substr($dep_head->middle_name, 0, 1) . '. ' .
                    $dep_head->last_name. ' ' .
                    $dep_head->ext_name;
                }


                $details = [
                    'full_name' => $full_name,
                    'signature' => $dep_head->signature,
                ];
                return $details;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
