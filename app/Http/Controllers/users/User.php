<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
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
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
        if (Auth::user()->id ==1) {
            return redirect()->route('admin.user.index');
        } else {
            return view('users.PDS.index')->with('user', $user)->with('progress', $progress);
        }
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
        $progress = ($progress / 55)*100;
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

    public function backUp()
    {
        Artisan::call('backup:run --disable-notifications');
        $path = storage_path('app\myBackup\*');
        $latest_ctime = 0;
        $latest_filename = '';
        $files = glob($path);
        foreach ($files as $file) {
            if (is_file($file) && filectime($file) > $latest_ctime) {
                $latest_ctime = filectime($file);
                $latest_filename = $file;
            }
        }
        return response()->download($latest_filename);
    }
    public function backUpClean()
    {
        Artisan::call('backup:clean');
        dd(Artisan::output());
    }
}
