<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NutritionTip extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
    ];
}
