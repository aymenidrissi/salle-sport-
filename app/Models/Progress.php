<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Progress extends Model
{
    protected $table = 'progresses';

    protected $fillable = [
        'user_id',
        'program_id',
        'notes',
        'metrics',
        'recorded_at',
    ];

    protected function casts(): array
    {
        return [
            'metrics' => 'array',
            'recorded_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
