<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $programs = Program::query()
            ->with('videos')
            ->latest()
            ->take(4)
            ->get();

        $homeVideoIds = $this->homeYoutubeEmbedIds();

        return view('client.home', compact('programs', 'homeVideoIds'));
    }

    /**
     * 3 vidéos YouTube affichées sur l’accueil (section « Exercices sportifs en vidéo »).
     *
     * @return array<int, string>
     */
    protected function homeYoutubeEmbedIds(): array
    {
        return [
            '-hSma-BRzoo',
            '5ODTt006LS4',
            'kQqxfCmLZz0',
        ];
    }

    public function about(): View
    {
        return view('client.about');
    }

    public function contact(): View
    {
        return view('client.contact');
    }
}
