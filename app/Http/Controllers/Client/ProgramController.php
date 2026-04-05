<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\NutritionTip;
use App\Models\Program;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(): View
    {
        return view('client.programs.index', [
            'programs' => Program::query()
                ->where('is_visible', true)
                ->with('videos')
                ->paginate(12),
        ]);
    }

    public function show(Program $program): View
    {
        abort_if(! $program->is_visible, 404);

        // Charger les vidéos pour l'affichage côté Blade.
        $program->load('videos');

        $nutritionTips = collect();
        $canRequestSpecialTip = false;
        $assignedProgramPdfLink = null;

        if (auth()->check()) {
            $assignedProgram = auth()->user()
                ->subscribedPrograms()
                ->where('programs.id', $program->id)
                ->first();

            $assignedProgramPdfLink = $assignedProgram?->pivot?->pdf_link;
        }

        if ($program->slug === 'programme-nutrition-sportive') {
            $canRequestSpecialTip = auth()->check()
                ? auth()->user()->subscribedPrograms()->where('programs.id', $program->id)->exists()
                : false;

            $tipsQuery = NutritionTip::query()->latest();

            // Publics
            $tipsQuery->where(function ($q) {
                $q->whereNull('user_id')->orWhere('is_special', false);
            });

            // Conseils spéciaux pour le client connecté
            if (auth()->check()) {
                $tipsQuery->orWhere('user_id', auth()->id());
            }

            $nutritionTips = $tipsQuery->get();
        }

        return view('client.programs.show', compact(
            'program',
            'nutritionTips',
            'canRequestSpecialTip',
            'assignedProgramPdfLink',
        ));
    }
}
