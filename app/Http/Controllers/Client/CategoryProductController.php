<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    public function show(Request $request, string $category): View
    {
        $category = strtolower(trim($category));
        if (!in_array($category, ['debutant', 'confirme'], true)) {
            abort(404);
        }

        $categoryLabel = $category === 'debutant' ? 'Débutant' : 'Confirmé';
        $programs = $this->categoryPrograms($category)->orderBy('id')->get();

        $prices = $programs->pluck('price')->filter(fn ($p) => $p !== null)->map(fn ($p) => (float) $p)->values();
        $defaultMin = $prices->isEmpty() ? 0.0 : (float) $prices->min();
        $defaultMax = $prices->isEmpty() ? 0.0 : (float) $prices->max();

        $minPrice = max(0, (float) $request->query('min_price', $defaultMin));
        $maxPrice = max($minPrice, (float) $request->query('max_price', $defaultMax));

        $filtered = $programs->filter(function (Program $program) use ($minPrice, $maxPrice) {
            $p = (float) ($program->price ?? 0);
            return $p >= $minPrice && $p <= $maxPrice;
        })->values();

        $bestSellers = Program::query()->orderBy('id')->take(4)->get();

        $counts = [
            'debutant' => $this->categoryPrograms('debutant')->count(),
            'confirme' => $this->categoryPrograms('confirme')->count(),
            'femme' => Program::query()->where(function ($q) {
                $q->where('slug', 'like', '%femme%');
            })->count(),
            'homme' => Program::query()->where(function ($q) {
                $q->where('slug', 'like', '%homme%');
            })->count(),
        ];

        return view('client.category-products.show', compact(
            'category',
            'categoryLabel',
            'filtered',
            'bestSellers',
            'counts',
            'minPrice',
            'maxPrice',
            'defaultMin',
            'defaultMax'
        ));
    }

    private function categoryPrograms(string $category)
    {
        if ($category === 'debutant') {
            return Program::query()->where(function ($q) {
                $q->where('slug', 'like', '%debutant%')
                    ->orWhere('title', 'like', '%débutant%')
                    ->orWhere('title', 'like', '%debutant%');
            });
        }

        return Program::query()->where(function ($q) {
            $q->where('slug', 'like', '%amincissement%')
                ->orWhere('slug', 'like', '%hypertrophie%')
                ->orWhere('title', 'like', '%confirmé%')
                ->orWhere('title', 'like', '%confirme%');
        });
    }
}

