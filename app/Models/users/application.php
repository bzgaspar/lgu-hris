<?php

namespace App\Models\users;

use App\Models\hr\AdditionalPoints;
use App\Models\hr\InterviewExam;
use App\Models\hr\Publication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class application extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function publication()
    {
        return $this->belongsTo(Publication::class, 'pub_id');
    }
    // public function publication()
    // {
    //     return $this->belongsTo(Publication::class, 'pub_id');
    // }
    public function InterviewExam()
    {
        return $this->hasMany(InterviewExam::class, 'app_id');
    }
    public function InterviewExamRaters()
    {
        return $this->hasMany(InterviewExam::class, 'app_id')->where('rater_id', '!=', 'null');
    }
    public function AdditionalPoints()
    {
        return $this->hasMany(AdditionalPoints::class, 'app_id');
    }
    public function AdditionalPointsRaters()
    {
        return $this->hasMany(AdditionalPoints::class, 'app_id')->where('rater_id', '!=', 'null');
    }

    public function scopeApplication($query, $request)
    {
        $query = $query->where('status', '1');
        if ($request->pub_id && $request->search) {
            return $query
            ->where('pub_id', $request->pub_id)
            ->select('applications.id', 'applications.user_id', 'applications.pub_id', 'applications.tor', 'applications.eligibility', 'applications.status', )
            ->leftJoin('users', 'users.id', 'applications.user_id')
            ->where('first_name', 'like', '%'.$request->search.'%')
            ->orWhere('last_name', 'like', '%'.$request->search.'%');
        } elseif ($request->sex && $request->pub_id) {
            return $query
            ->select('applications.id', 'applications.user_id', 'applications.pub_id', 'applications.tor', 'applications.eligibility', 'applications.status', )
            ->leftJoin('users', 'users.id', 'applications.user_id')
            ->leftJoin('personals', 'personals.user_id', '=', 'users.id')
            ->where('personals.sex', $request->sex)
            ->where('pub_id', $request->pub_id);
        } elseif ($request->pub_id) {
            return $query
            ->where('pub_id', $request->pub_id);
        } elseif ($request->search) {
            return $query
            ->select('applications.id', 'applications.user_id', 'applications.pub_id', 'applications.tor', 'applications.eligibility', 'applications.status', )
            ->leftJoin('users', 'users.id', 'applications.user_id')
            ->where('first_name', 'like', '%'.$request->search.'%')
            ->orWhere('last_name', 'like', '%'.$request->search.'%');
        } else {
            return $query;
        }
    }
}
