<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NutritionTip;
use App\Models\NutritionTipRequest;
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
        $pendingRequests = NutritionTipRequest::query()
            ->with(['user', 'program'])
            ->where('status', 'pending')
            ->latest()
            ->take(50)
            ->get();

        $selectedRequestId = request()->integer('request_id') ?: null;
        $selectedRequest = $selectedRequestId
            ? $pendingRequests->firstWhere('id', $selectedRequestId)
            : null;

        return view('admin.nutrition-tips.create', compact('pendingRequests', 'selectedRequest'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        $requestId = $request->integer('request_id') ?: null;
        $tip = null;

        if ($requestId) {
            $req = NutritionTipRequest::query()->with('user')->findOrFail($requestId);
            if ($req->status !== 'pending') {
                return redirect()->route('admin.nutrition-tips.create')->with('error', 'Cette demande a déjà été traitée.');
            }

            $data['is_special'] = true;
            $data['user_id'] = $req->user_id;
            $data['request_id'] = $req->id;

            $tip = NutritionTip::query()->create($data);
            $req->update(['status' => 'fulfilled']);
        } else {
            $data['is_special'] = false;
            $tip = NutritionTip::query()->create($data);
        }

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
        $data = $this->validatedData($request);
        $nutritionTip->update($data);

        return redirect()->route('admin.nutrition-tips.index');
    }

    public function destroy(NutritionTip $nutritionTip): RedirectResponse
    {
        $nutritionTip->delete();

        return redirect()->route('admin.nutrition-tips.index');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'string', 'max:2048'],
            'request_id' => ['nullable', 'integer', 'exists:nutrition_tip_requests,id'],
        ]);
    }
}
