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
use App\Models\LeaveApplication;
use App\Models\pds\civilservice;
use App\Models\reference\earned;
use App\Models\reference\hours;
use App\Models\reference\minutes;
use App\Models\users\application;
use App\Models\users\Ipcr;
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
        ->select('hrmpsbs.id', 'users.role', DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as name"))
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
        ->get();
        return response()->json($user, Response::HTTP_OK);
    }
    public function getUserLeave($user_id)
    {
        $leave = LeaveCredit::where('user_id', $user_id)->orderByDesc('elc_period_to')->first();
        return response()->json($leave, Response::HTTP_OK);
    }
    public function getLeaveCredit($user_id)
    {
        $leave = LeaveCredit::where('user_id', $user_id)->orderByDesc('elc_period_to')->get();
        return response()->json($leave, Response::HTTP_OK);
    }
    public function getLeaveApp()
    {
        $leave_app = LeaveApplication::leftJoin('users', 'users.id', '=', 'leave_applications.user_id')
        ->select('leave_applications.id', 'leave_applications.user_id', 'leave_applications.type', 'leave_applications.created_at', 'leave_applications.date_from', 'leave_applications.status', 'leave_applications.date_to', DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as name"))
        ->with('users', 'users.empPlantilla.department', 'users.pdsPersonal')
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
    public function getPublication()
    {
        $publication = Publication::where('status', '1')->orderBy('title')->get();
        return response()->json($publication, Response::HTTP_OK);
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
        ->with('user', 'user.pdsPersonal', 'user.empPlantilla')
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
        ->with('user', 'user.pdsPersonal', 'user.empPlantilla')
        ->orderByDesc('rating')
        ->get();

        return response()->json($all_ipcr, Response::HTTP_OK);
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
            ->select('users.first_name', 'personals.middle_name', 'users.last_name', 'employee_plantillas.EPposition as position')
            ->where('users.id', $id)->get();
        $full_name = $users[0]->first_name . ' ' . substr($users[0]->middle_name, 0, 1) . '. ' . $users[0]->last_name;

        return [
            'full_name' => $full_name,
            'position' => $users[0]->position,
        ];

    }
}
