<?php

namespace App\Models\users;

use App\Models\ipcr_mfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ipcr_forms_detail extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'form_id',
        'ques1',
        'ques2',
        'ans1',
        'ans2',
        'ans3',
        'rate1',
        'rate2',
        'rate3',
        'rate4',
        'remarks',
    ];

    public function ipcr_mfo()
    {
        return $this->belongsTo(ipcr_mfo::class, 'ques1');
    }
    public function ipcr_Questions()
    {
        return $this->belongsTo(ipcr_Questions::class, 'ques2');
    }
}
