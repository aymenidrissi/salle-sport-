<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NutritionTipRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index(): View
    {
        $pendingOrders = Order::query()
            ->with(['items.program', 'user'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        $recentApproved = Order::query()
            ->with(['items.program', 'user'])
            ->where('status', 'approved')
            ->latest()
            ->take(12)
            ->get();

        $pendingNutritionRequests = NutritionTipRequest::query()
            ->with(['user', 'program'])
            ->where('status', 'pending')
            ->latest()
            ->take(20)
            ->get();

        return view('admin.subscriptions.index', compact(
            'pendingOrders',
            'recentApproved',
            'pendingNutritionRequests',
        ));
    }

    public function approve(Order $order): RedirectResponse
    {
        if (! $order->isPendingApproval()) {
            return redirect()
                ->route('admin.subscriptions.index')
                ->with('error', 'Cette commande ne peut plus être traitée.');
        }

        if ($order->user_id === null) {
            return redirect()
                ->route('admin.subscriptions.index')
                ->with('error', 'Impossible d’accepter : aucun compte client associé à la commande.');
        }

        DB::transaction(function () use ($order): void {
            $user = $order->user;
            foreach ($order->items as $item) {
                if ($item->program_id === null) {
                    continue;
                }
                if (! $user->subscribedPrograms()->where('programs.id', $item->program_id)->exists()) {
                    $user->subscribedPrograms()->attach($item->program_id, [
                        'order_id' => $order->id,
                    ]);
                }
            }
            $order->update(['status' => 'approved']);
        });

        return redirect()
            ->route('admin.subscriptions.index')
            ->with('status', 'Abonnement accepté : les programmes ont été attribués au client.');
    }
}
