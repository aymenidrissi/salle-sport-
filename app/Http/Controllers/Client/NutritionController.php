<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\NutritionTip;
use Illuminate\View\View;

class NutritionController extends Controller
{
    public function index(): View
    {
        return view('client.nutrition.index', [
            'tips' => NutritionTip::query()->paginate(12),
        ]);
    }
}
