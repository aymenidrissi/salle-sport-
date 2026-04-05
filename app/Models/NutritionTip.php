<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NutritionTip extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'user_id',
        'request_id',
        'is_special',
    ];

    protected function casts(): array
    {
        return [
            'is_special' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function request(): BelongsTo
    {
        return $this->belongsTo(NutritionTipRequest::class, 'request_id');
    }
}
