<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        return view('client.profile');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'age' => ['nullable', 'integer', 'min:0', 'max:120'],
            'weight' => ['nullable', 'numeric', 'min:20', 'max:300'],
            'height' => ['nullable', 'numeric', 'min:100', 'max:250'],
            'city' => ['nullable', 'string', 'max:120'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $user = $request->user();

        $user->age = $validated['age'] ?? null;
        $user->weight = array_key_exists('weight', $validated) && $validated['weight'] !== null
            ? (float) $validated['weight']
            : null;
        $user->height = array_key_exists('height', $validated) && $validated['height'] !== null
            ? (float) $validated['height']
            : null;
        $user->city = filled($validated['city'] ?? null)
            ? trim($validated['city'])
            : null;

        if ($request->hasFile('photo')) {
            $user->photo = $request->file('photo')->store('profile-photos', 'public');
        }

        $user->save();

        return redirect()
            ->route('client.profile')
            ->with('status', 'Profil mis à jour.');
    }
}
