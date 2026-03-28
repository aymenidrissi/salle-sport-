<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'weight',
        'height',
        'city',
        'photo',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'weight' => 'float',
            'height' => 'float',
        ];
    }

    /**
     * IMC (kg/m²) — taille en cm en base.
     */
    public function bmi(): ?float
    {
        if ($this->weight === null || $this->height === null || $this->height <= 0) {
            return null;
        }

        $m = $this->height / 100;

        return round($this->weight / ($m * $m), 1);
    }

    public function bmiCategory(): ?string
    {
        $bmi = $this->bmi();
        if ($bmi === null) {
            return null;
        }

        if ($bmi < 18.5) {
            return 'maigre';
        }
        if ($bmi < 25) {
            return 'normal';
        }
        if ($bmi < 30) {
            return 'surpoids';
        }

        return 'obésité';
    }

    /** Libellé français pour l’affichage (IMC). */
    public function bmiCategoryLabel(): ?string
    {
        return match ($this->bmiCategory()) {
            'maigre' => 'Maigre',
            'normal' => 'Normal',
            'surpoids' => 'Surpoids',
            'obésité' => 'Obésité',
            default => null,
        };
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(Progress::class);
    }

    public function isAdmin(): bool
    {
        return $this->role?->slug === 'admin';
    }
}
