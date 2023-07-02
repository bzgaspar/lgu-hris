<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplicationPoints extends Model
{
    use HasFactory;


    public function leaveApplication()
    {
        return $this->belongsTo(leaveApplication::class, 'leave_app_id');
    }
}
