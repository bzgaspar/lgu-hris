<?php

namespace App\Models\hr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publication extends Model
{
    use HasFactory;


    public function interviewExamPublication()
    {
        return $this->hasMany(InterviewExam::class, 'pub_id');
    }
    public function AdditionalPoints()
    {
        return $this->hasMany(AdditionalPoints::class, 'pub_id');
    }
}
