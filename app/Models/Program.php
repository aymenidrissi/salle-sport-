<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Program extends Model
{
    /**
     * Les URLs utilisent le slug (ex. /client/programmes/programme-debutant-homme).
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

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

    /** Titre court pour les grilles type boutique (cartes). */
    public function listingTitle(): string
    {
        return match ($this->slug) {
            'debutant-femme' => 'Débutant femme',
            'programme-amincissement-et-developpement-musculaire-femme' => 'Amincissement femme',
            'programme-debutant-homme' => 'Débutant homme',
            'programme-hypertrophie-homme' => 'Développement musculaire homme',
            'programme-nutrition-sportive' => 'Programme nutrition sportive',
            default => $this->title,
        };
    }

    /** Texte bandeau sur l’image (majuscules). */
    public function overlayBannerText(): string
    {
        return match ($this->slug) {
            'debutant-femme' => 'PROGRAMME FEMME DÉBUTANTE',
            'programme-amincissement-et-developpement-musculaire-femme' => 'PROGRAMME AMINCISSEMENT ET RENFORCEMENT MUSCULAIRE',
            'programme-debutant-homme' => 'PROGRAMME HOMME DÉBUTANT',
            'programme-hypertrophie-homme' => 'PROGRAMME HOMME HYPERTROPHIE',
            'programme-nutrition-sportive' => 'PROGRAMME NUTRITION SPORTIVE',
            default => Str::upper($this->title),
        };
    }

    /** Niveau affiché sous le titre (Débutant / Confirmé). */
    public function levelLabel(): string
    {
        $s = (string) $this->slug;

        if (str_contains($s, 'nutrition')) {
            return '—';
        }

        if ($s === 'debutant-femme' || str_contains($s, 'debutant-homme')) {
            return 'Débutant';
        }

        if (str_contains($s, 'hypertrophie') || str_contains($s, 'amincissement')) {
            return 'Confirmé';
        }

        return '—';
    }
}
