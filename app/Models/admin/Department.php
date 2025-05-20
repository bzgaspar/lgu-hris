<?php

namespace App\Models\admin;

use App\Models\hr\Separated;
use App\Models\hr\ServiceRecord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

public function separations()
{
    return $this->hasMany(Separated::class);
}
    public function plantilla()
    {
        return $this->hasMany(EmployeePlantilla::class, 'dep_id');
    }

    public function service()
    {
        return $this->hasMany(ServiceRecord::class, 'dep_id');
    }
    public function yearlyIPCR()
    {
        return $this->hasMany(yearlyIPCR::class, 'dep_id');
    }
}
