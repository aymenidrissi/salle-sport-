<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\NutritionTipRequest;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NutritionTipRequestController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'program_id' => ['required', 'integer', 'exists:programs,id'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $program = Program::query()->findOrFail($data['program_id']);

        // Limiter aux demandes pour le programme nutrition sportive.
        if ($program->slug !== 'programme-nutrition-sportive') {
            return back()->with('error', 'Cette demande est disponible uniquement pour le programme nutrition sportive.');
        }

        $hasApprovedSubscription = auth()->user()
            ->subscribedPrograms()
            ->where('programs.id', $program->id)
            ->exists();

        if (! $hasApprovedSubscription) {
            return back()->with('error', 'Vous devez d’abord avoir un abonnement nutrition validé par l’admin.');
        }

        NutritionTipRequest::query()->create([
            'user_id' => (int) auth()->id(),
            'program_id' => (int) $program->id,
            'message' => ($data['message'] ?? null) !== '' ? $data['message'] : null,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Demande envoyée. Un coach nutrition vous répondra via un conseil spécial.');
    }
}
