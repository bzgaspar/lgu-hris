<?php

namespace App\Models\hr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalPoints extends Model
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
    public function application()
    {
        return $this->belongsTo(application::class, 'app_id');
    }
}
