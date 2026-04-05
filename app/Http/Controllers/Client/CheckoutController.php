<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\NutritionTipRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'billing_first_name' => ['required', 'string', 'max:120'],
            'billing_last_name' => ['required', 'string', 'max:120'],
            'billing_email' => ['required', 'email', 'max:255'],
            'payment_method' => ['required', 'in:card,paypal,bank_transfer'],
            'cart_json' => ['required', 'json'],
            'terms' => ['accepted'],
        ]);

        /** @var array<string, array{title?: string, price?: float|int|string, qty?: int}> $cartItems */
        $cartItems = json_decode($validated['cart_json'], true);
        if (! is_array($cartItems) || $cartItems === []) {
            return back()->withInput()->withErrors(['cart_json' => 'Le panier est vide.']);
        }

        $total = 0.0;
        $lines = [];
        $containsSpecialNutritionRequest = false;
        foreach ($cartItems as $slug => $row) {
            if (! is_string($slug) || $slug === '') {
                continue;
            }
            $row = is_array($row) ? $row : [];
            $title = isset($row['title']) ? (string) $row['title'] : $slug;
            $price = isset($row['price']) ? (float) $row['price'] : 0.0;
            $qty = isset($row['qty']) ? max(1, (int) $row['qty']) : 1;
            $lineTotal = $price * $qty;
            $total += $lineTotal;

            $program = Program::query()->where('slug', $slug)->first();

            $lines[] = [
                'program_id' => $program?->id,
                'program_slug' => $slug,
                'title' => $title,
                'unit_price' => round($price, 2),
                'qty' => $qty,
            ];

            if ($slug === 'demande-conseil-special-nutrition') {
                $containsSpecialNutritionRequest = true;
            }
        }

        if ($lines === []) {
            return back()->withInput()->withErrors(['cart_json' => 'Aucun article valide dans le panier.']);
        }

        $billingName = trim($validated['billing_first_name'].' '.$validated['billing_last_name']);

        DB::transaction(function () use ($validated, $billingName, $total, $lines, $containsSpecialNutritionRequest): void {
            $order = Order::query()->create([
                'user_id' => auth()->id(),
                'billing_email' => $validated['billing_email'],
                'billing_name' => $billingName !== '' ? $billingName : null,
                'payment_method' => $validated['payment_method'],
                'total' => round($total, 2),
                'status' => 'pending',
            ]);

            foreach ($lines as $line) {
                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'program_id' => $line['program_id'],
                    'program_slug' => $line['program_slug'],
                    'title' => $line['title'],
                    'unit_price' => $line['unit_price'],
                    'qty' => $line['qty'],
                ]);
            }

            if ($containsSpecialNutritionRequest && $order->user_id) {
                $nutritionProgram = Program::query()
                    ->where('slug', 'programme-nutrition-sportive')
                    ->first();

                if ($nutritionProgram) {
                    NutritionTipRequest::query()->create([
                        'user_id' => $order->user_id,
                        'program_id' => $nutritionProgram->id,
                        'message' => 'Demande créée depuis le panier (commande #'.$order->id.').',
                        'status' => 'pending',
                    ]);
                }
            }
        });

        return redirect()
            ->route('client.checkout')
            ->with('order_placed', true);
    }
}
