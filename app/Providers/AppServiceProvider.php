<?php

namespace App\Providers;

use App\Models\NutritionTipRequest;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.admin', function ($view): void {
            $adminRoleId = Role::query()->where('slug', 'admin')->value('id');

            $since = now()->subHours(24);

            $recentSignups = User::query()
                ->with('role')
                ->when($adminRoleId, fn ($q) => $q->where('role_id', '!=', $adminRoleId))
                ->latest()
                ->take(8)
                ->get();

            $recentOrders = Order::query()
                ->with(['items', 'user'])
                ->latest()
                ->take(8)
                ->get();

            $recentSignupCount24h = User::query()
                ->when($adminRoleId, fn ($q) => $q->where('role_id', '!=', $adminRoleId))
                ->where('created_at', '>=', $since)
                ->count();

            $recentOrderCount24h = Order::query()
                ->where('created_at', '>=', $since)
                ->count();

            $recentSpecialRequests = NutritionTipRequest::query()
                ->with(['user', 'program'])
                ->where('status', 'pending')
                ->latest()
                ->take(8)
                ->get();

            $recentSpecialRequestCount24h = NutritionTipRequest::query()
                ->where('status', 'pending')
                ->where('created_at', '>=', $since)
                ->count();

            $notificationBadgeCount = min(99, $recentSignupCount24h + $recentOrderCount24h + $recentSpecialRequestCount24h);

            $pendingSubscriptionCount = Order::query()->where('status', 'pending')->count();

            $view->with(compact(
                'recentSignups',
                'recentOrders',
                'recentSpecialRequests',
                'notificationBadgeCount',
                'pendingSubscriptionCount',
            ));
        });
    }
}
