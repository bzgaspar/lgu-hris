<?php

namespace App\Models;

use App\Models\hr\surveyAnswerDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyFiles extends Model
{
    use HasFactory;

    public function surveyAnswerDetails()
    {
        return $this->belongsTo(surveyAnswerDetails::class,'answer_details_id');
    }
}
