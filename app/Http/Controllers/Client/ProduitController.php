<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\View\View;

class ProduitController extends Controller
{
    public function show(Program $program): View
    {
        $program->load('videos');

        if ($program->slug === 'debutant-femme') {
            $slugs = [
                'programme-amincissement-et-developpement-musculaire-femme',
                'programme-nutrition-sportive',
            ];
            $related = Program::query()
                ->whereIn('slug', $slugs)
                ->with('videos')
                ->get()
                ->sortBy(fn (Program $p) => array_search($p->slug, $slugs, true))
                ->values();
        } else {
            $related = Program::query()
                ->where('id', '!=', $program->id)
                ->with('videos')
                ->orderBy('id')
                ->take(2)
                ->get();
        }

        return view('client.produit.show', compact('program', 'related'));
    }
}
