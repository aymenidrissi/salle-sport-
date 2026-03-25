<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(): View
    {
        return view('client.programs.index', [
            'programs' => Program::query()->with('videos')->paginate(12),
        ]);
    }

    public function show(Program $program): View
    {
        // Charger les vidéos pour l'affichage côté Blade.
        $program->load('videos');

        return view('client.programs.show', compact('program'));
    }
}
