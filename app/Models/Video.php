<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    protected $fillable = [
        'program_id',
        'title',
        'url',
        'description',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
