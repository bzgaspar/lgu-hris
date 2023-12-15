<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\admin\Department;
use App\Models\pds\civilservice;
use App\Models\pds\educational;
use App\Models\pds\family;
use App\Models\pds\familyC;
use App\Models\pds\learningdevelopment;
use App\Models\pds\otherinformation;
use App\Models\pds\personal;
use App\Models\pds\voluntarywork;
use App\Models\pds\workexperience;
use App\Models\User as ModelsUser;
use App\Models\users\others;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class User extends Controller
{
    private $user;
    public function __construct(ModelsUser $user)
    {
        $this->user = $user;
    }
    public function index()
    {
        $user = $this->user->findOrFail(Auth::user()->id);
        $progress = $this->pdsProgress();
        if (Auth::user()->id == 1) {
            return redirect()->route('admin.user.index');
        } else {
            return view('users.PDS.index')->with('user', $user)->with('progress', $progress);
        }
    }
    public function covid()
    {
        return view('admin.covid');
    }
    public function ProfileView($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.profileView')->with('user',$user);
    }

    public function pdsProgress()
    {
        $progress = 0;
        if (personal::where('user_id', Auth::user()->id)->exists()) {
            $progress += 1;
        }
        if (family::where('user_id', Auth::user()->id)->exists()) {
            $progress += 2;
        }
        if (familyC::where('user_id', Auth::user()->id)->exists()) {
            $progress += 3;
        }
        if (educational::where('user_id', Auth::user()->id)->exists()) {
            $progress += 4;
        }
        if (civilservice::where('user_id', Auth::user()->id)->exists()) {
            $progress += 5;
        }
        if (workexperience::where('user_id', Auth::user()->id)->exists()) {
            $progress += 6;
        }
        if (voluntarywork::where('user_id', Auth::user()->id)->exists()) {
            $progress += 7;
        }
        if (learningdevelopment::where('user_id', Auth::user()->id)->exists()) {
            $progress += 8;
        }
        if (otherinformation::where('user_id', Auth::user()->id)->exists()) {
            $progress += 9;
        }
        if (others::where('user_id', Auth::user()->id)->exists()) {
            $progress += 10;
        }
        $progress = ($progress / 55) * 100;
        return round($progress, 2);
    }


    public function reset($id)
    {
        $user = $this->user->findOrFail($id);
        $user->password = Hash::make('lgudelfinalbano');
        if ($user->save()) {
            Session::flash('alert', 'success|User password has been reset!');
        } else {
            Session::flash('alert', 'danger|User password has not reset!');
        }
        return redirect()->back();
    }
    public function activate($id)
    {
        if ($this->user->onlyTrashed()->findOrFail($id)->restore()) {
            Session::flash('alert', 'success|User has been Activated!');
        } else {
            Session::flash('alert', 'danger|User has not Activated!');
        }
        return redirect()->back();
    }
    public function unbanned($id)
    {
        $user = $this->user->findOrFail($id);
        $user->status = 1;
        if ($user->save()) {
            Session::flash('alert', 'success|User has been Unbanned!');
        } else {
            Session::flash('alert', 'danger|User has not Unbanned!');
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        if ($this->user->where('id', $id)->forceDelete()) {
            Session::flash('alert', 'success|User has been Delete!');
        } else {
            Session::flash('alert', 'danger|User has not Delete!');
        }
        return redirect()->back();
    }

    public function backUpDB()
    {
        Artisan::call('backup:run --only-db');
        dd(Artisan::output());
        // $path = storage_path('app/HRIS---LGU-Delfin-Albano/*');
        // $latest_ctime = 0;
        // $latest_filename = '';
        // $files = glob($path);
        // foreach ($files as $file) {
        //     if (is_file($file) && filectime($file) > $latest_ctime) {
        //         $latest_ctime = filectime($file);
        //         $latest_filename = $file;
        //     }
        // }
        // return response()->download($latest_filename);
    }
    public function backUp()
    {
        Artisan::call('backup:run');
        dd(Artisan::output());
        // $path = storage_path('app/HRIS---LGU-Delfin-Albano/*');
        // $latest_ctime = 0;
        // $latest_filename = '';
        // $files = glob($path);
        // foreach ($files as $file) {
        //     if (is_file($file) && filectime($file) > $latest_ctime) {
        //         $latest_ctime = filectime($file);
        //         $latest_filename = $file;
        //     }
        // }
        // return response()->download($latest_filename);
    }
    public function backUpClean()
    {
        Artisan::call('backup:clean');
        if (File::deleteDirectory(storage_path('app\HRIS---LGU-Delfin-Albano'))) {
            Session::flash('alert', 'success|Backup Has been Cleared');
            return redirect()->back();
        } else {
            dd(Artisan::output());
            return redirect()->back();
        }
    }
    public function scheduler()
    {
        Artisan::call('schedule:work');
        dd(Artisan::output());

    }
    public function employeesGender($gender)
    {
        $data = ModelsUser::leftJoin('personals', 'personals.user_id', 'users.id')
        ->leftJoin('employee_plantillas', 'employee_plantillas.user_id', 'users.id')
        ->select(DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as name"), 'employee_plantillas.EPposition')
        ->where('sex', 'like', $gender)->get();


        return view('print.EMPbyGender')->with('data', $data)->with('gender', $gender);
    }
    public function ViewByGenderCount()
    {
        $all_department = Department::get();
        $all_users = ModelsUser::join('employee_plantillas', 'employee_plantillas.user_id', 'users.id')
        ->join('departments', 'employee_plantillas.dep_id', 'departments.id')
        ->join('personals', 'personals.user_id', 'users.id')
        ->select('departments.name as dep_name', 'departments.id as dep_id', 'personals.sex')
        ->get();

        return view('print.EMPbyGenderCount')->with('all_users', $all_users)->with('all_department', $all_department);
    }
    public function ViewPwdSpI()
    {
        $all_department = Department::get();
        $all_users = ModelsUser::join('employee_plantillas', 'employee_plantillas.user_id', 'users.id')
        ->join('departments', 'employee_plantillas.dep_id', 'departments.id')
        ->join('others', 'others.user_id', 'users.id')
        ->select('others.Q40b as pwd', 'others.Q40a as indigenous', 'others.Q40c as solo_parent', 'departments.id as dep_id')
        ->get();

        return view('print.EMPbyPWD')->with('all_users', $all_users)->with('all_department', $all_department);
    }
    public function ViewStatus()
    {
        $all_department = Department::get();
        $all_users = ModelsUser::join('employee_plantillas', 'employee_plantillas.user_id', 'users.id')
        ->join('departments', 'employee_plantillas.dep_id', 'departments.id')
        ->select('employee_plantillas.status as status', 'departments.id as dep_id')
        ->get();

        return view('print.EMPbyStatus')->with('all_users', $all_users)->with('all_department', $all_department);
    }
    public function ViewCovidResponse()
    {
        $all_department = Department::get();
        $all_users = ModelsUser::join('employee_plantillas', 'employee_plantillas.user_id', 'users.id')
        ->join('departments', 'employee_plantillas.dep_id', 'departments.id')
        ->join('covids', 'covids.user_id', 'users.id')
        ->select('covids.booster as booster', 'departments.id as dep_id')
        ->get();
        return view('print.EMPbyCovid')->with('all_users', $all_users)->with('all_department', $all_department);
    }
}
