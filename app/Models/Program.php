<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'video_url',
        'price',
        'image',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_visible' => 'boolean',
        ];
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('order_id', 'pdf_link')
            ->withTimestamps();
    }

    /**
     * URL affichable pour la vignette / hero (fichier dans storage ou lien http(s)).
     */
    public function publicImageUrl(): ?string
    {
        $raw = $this->image;
        if ($raw === null || $raw === '') {
            return null;
        }

        $img = trim((string) $raw);
        if ($img === '') {
            return null;
        }

        if (Str::startsWith($img, ['http://', 'https://'])) {
            return $img;
        }

        if (Str::startsWith($img, '//')) {
            return 'https:'.$img;
        }

        return asset('storage/'.$img);
    }

    /**
     * Lien http(s) brut stocké dans `image` (pour affichage bouton PDF / ressource).
     */
    public function externalHttpImageField(): ?string
    {
        $raw = trim((string) ($this->image ?? ''));
        if ($raw === '' || ! Str::startsWith($raw, ['http://', 'https://'])) {
            return null;
        }

        return $raw;
    }

    /**
     * Le champ image pointe vers un fichier non affichable en <img> (ex. PDF).
     */
    public function imageFieldIsNonDisplayableHttpResource(): bool
    {
        $url = $this->externalHttpImageField();
        if ($url === null) {
            return false;
        }

        return (bool) preg_match('/\.(pdf|docx?|zip)(\?|#|$)/i', $url);
    }

    /**
     * URL pour bannière / vignette : exclut PDF et documents (sinon <img> cassé).
     */
    public function heroOrCardImageUrl(): ?string
    {
        if ($this->imageFieldIsNonDisplayableHttpResource()) {
            return null;
        }

        return $this->publicImageUrl();
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
