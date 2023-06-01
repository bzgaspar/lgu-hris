<?php

namespace App\Models\hr;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveCredit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'elc_period_from',
        'elc_period_to',
        'elc_particular',
        'elc_vl_earned',
        'elc_vl_balance',
        'elc_sl_earned',
        'elc_sl_balance',
        'elc_remarks',
        'elc_vl_auw_p',
        'elc_vl_auwo_p',
        'elc_sl_auw_p',
        'elc_sl_auwo_p',
    ];


    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
