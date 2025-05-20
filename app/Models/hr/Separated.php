<?php

namespace App\Models\hr;

use App\Models\admin\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Separated extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'position',
        'department_id',
        'date_separated',
        'remarks',
    ];
public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
