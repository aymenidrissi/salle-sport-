<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NutritionTip;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NutritionTipController extends Controller
{
    public function index(): View
    {
        return view('admin.nutrition-tips.index', [
            'tips' => NutritionTip::query()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.nutrition-tips.create');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('admin.nutrition-tips.index');
    }

    public function show(NutritionTip $nutritionTip): View
    {
        return view('admin.nutrition-tips.show', compact('nutritionTip'));
    }

    public function edit(NutritionTip $nutritionTip): View
    {
        return view('admin.nutrition-tips.edit', compact('nutritionTip'));
    }

    public function update(Request $request, NutritionTip $nutritionTip): RedirectResponse
    {
        return redirect()->route('admin.nutrition-tips.index');
    }

    public function destroy(NutritionTip $nutritionTip): RedirectResponse
    {
        return redirect()->route('admin.nutrition-tips.index');
    }
}
