<?php

namespace App\Models\hr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccreditedLearningServiceProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_name',
        'location',
        'services',
    ];
}
