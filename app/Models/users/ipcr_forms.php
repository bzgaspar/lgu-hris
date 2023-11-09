<?php

namespace App\Models\users;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use App\Models\users\ipcr_forms_detail;

class ipcr_forms extends Model
{
    use HasFactory;

    public function ipcr_forms_details()
    {
        return $this->hasMany(ipcr_forms_detail::class, 'form_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
