<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }
}
