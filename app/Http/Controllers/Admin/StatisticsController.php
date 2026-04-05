<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NutritionTip;
use App\Models\NutritionTipRequest;
use App\Models\Order;
use App\Models\Program;
use App\Models\Progress;
use App\Models\Role;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StatisticsController extends Controller
{
    public function index(): View
    {
        $adminRoleId = Role::query()->where('slug', 'admin')->value('id');

        $clientQuery = User::query()->when($adminRoleId, fn ($q) => $q->where('role_id', '!=', $adminRoleId));

        $membersCount = (clone $clientQuery)->count();
        $adminsCount = $adminRoleId
            ? User::query()->where('role_id', $adminRoleId)->count()
            : 0;

        $programsCount = Program::query()->count();
        $visibleProgramsCount = Program::query()->where('is_visible', true)->count();
        $videoCount = Video::query()->count();
        $progressCount = Progress::query()->count();
        $nutritionTipsCount = NutritionTip::query()->count();
        $pendingNutritionRequests = NutritionTipRequest::query()->where('status', 'pending')->count();

        $ordersTotal = Order::query()->count();
        $revenueSum = (float) Order::query()->sum('total');
        $revenueFormatted = $revenueSum > 0
            ? number_format($revenueSum, 0, ',', ' ').' DH'
            : '0 DH';

        $pendingOrders = Order::query()->where('status', 'pending')->count();
        $approvedOrders = Order::query()->where('status', 'approved')->count();

        $donutSegments = $this->programDistribution();
        $engagementChart = $this->monthlyEngagementSeries($adminRoleId);
        $revenueSeries = $this->monthlyRevenueSeries();
        $ordersByStatus = $this->ordersByStatusPayload();
        $topPrograms = $this->topProgramsBySubscriptions();

        $chartConfig = [
            'engagement' => $engagementChart,
            'programs' => $this->programChartPayload($donutSegments),
            'revenue' => $revenueSeries,
            'ordersByStatus' => $ordersByStatus,
            'topPrograms' => $topPrograms,
        ];

        $kpis = [
            ['key' => 'members', 'label' => 'Membres', 'value' => $membersCount, 'hint' => 'Comptes clients', 'tone' => 'sky'],
            ['key' => 'revenue', 'label' => 'CA total', 'value' => $revenueFormatted, 'hint' => 'Toutes commandes', 'tone' => 'amber'],
            ['key' => 'orders', 'label' => 'Commandes', 'value' => $ordersTotal, 'hint' => $pendingOrders.' en attente', 'tone' => 'violet'],
            ['key' => 'videos', 'label' => 'Vidéos', 'value' => $videoCount, 'hint' => 'Bibliothèque', 'tone' => 'brand'],
            ['key' => 'programs', 'label' => 'Programmes', 'value' => $programsCount, 'hint' => $visibleProgramsCount.' visibles', 'tone' => 'emerald'],
            ['key' => 'progress', 'label' => 'Progressions', 'value' => $progressCount, 'hint' => 'Suivis enregistrés', 'tone' => 'rose'],
        ];

        return view('admin.statistics', compact(
            'adminsCount',
            'nutritionTipsCount',
            'pendingNutritionRequests',
            'ordersTotal',
            'approvedOrders',
            'donutSegments',
            'chartConfig',
            'kpis',
        ));
    }

    /**
     * @return array{labels: string[], members: int[], videos: int[]}
     */
    private function monthlyEngagementSeries(?int $adminRoleId): array
    {
        $start = now()->subMonths(11)->startOfMonth();

        $labels = [];
        $members = [];
        $videos = [];

        for ($i = 0; $i < 12; $i++) {
            $month = $start->copy()->addMonths($i);

            $labels[] = Str::ucfirst($month->locale('fr')->isoFormat('MMM'));

            $members[] = User::query()
                ->when($adminRoleId, fn ($q) => $q->where('role_id', '!=', $adminRoleId))
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $videos[] = Video::query()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        return compact('labels', 'members', 'videos');
    }

    /**
     * @return array{labels: string[], amounts: float[]}
     */
    private function monthlyRevenueSeries(): array
    {
        $start = now()->subMonths(11)->startOfMonth();
        $labels = [];
        $amounts = [];

        for ($i = 0; $i < 12; $i++) {
            $month = $start->copy()->addMonths($i);
            $labels[] = Str::ucfirst($month->locale('fr')->isoFormat('MMM'));
            $amounts[] = round((float) Order::query()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total'), 2);
        }

        return compact('labels', 'amounts');
    }

    /**
     * @return array{labels: string[], values: int[], colors: string[]}
     */
    private function ordersByStatusPayload(): array
    {
        $rows = Order::query()
            ->selectRaw('status, count(*) as c')
            ->groupBy('status')
            ->get();

        if ($rows->isEmpty()) {
            return ['labels' => [], 'values' => [], 'colors' => []];
        }

        $labels = [];
        $values = [];
        $colors = [];

        foreach ($rows as $row) {
            $status = (string) $row->status;
            $labels[] = match ($status) {
                'pending' => 'En attente',
                'approved' => 'Validées',
                'completed' => 'Complétées',
                default => $status,
            };
            $values[] = (int) $row->c;
            $colors[] = match ($status) {
                'pending' => '#eab308',
                'approved' => '#22c55e',
                'completed' => '#3b82f6',
                default => '#71717a',
            };
        }

        return compact('labels', 'values', 'colors');
    }

    /**
     * @return array{labels: string[], values: int[]}
     */
    private function topProgramsBySubscriptions(): array
    {
        $rows = DB::table('program_user')
            ->select('program_id', DB::raw('count(*) as subscribers'))
            ->groupBy('program_id')
            ->orderByDesc('subscribers')
            ->limit(10)
            ->get();

        if ($rows->isEmpty()) {
            return ['labels' => [], 'values' => []];
        }

        $ids = $rows->pluck('program_id')->all();
        $titles = Program::query()->whereIn('id', $ids)->pluck('title', 'id');

        $labels = [];
        $values = [];

        foreach ($rows as $row) {
            $title = $titles[$row->program_id] ?? ('#'.$row->program_id);
            $labels[] = Str::limit($title, 36);
            $values[] = (int) $row->subscribers;
        }

        return compact('labels', 'values');
    }

    /**
     * @param  array<int, array{label: string, pct: int, color: string, value: int}>  $segments
     * @return array{labels: string[], values: int[], colors: string[]}
     */
    private function programChartPayload(array $segments): array
    {
        $labels = [];
        $values = [];
        $colors = [];

        foreach ($segments as $seg) {
            if (($seg['value'] ?? 0) <= 0 && ($seg['pct'] ?? 0) <= 0) {
                continue;
            }
            $labels[] = $seg['label'];
            $values[] = max(1, (int) ($seg['value'] ?? 1));
            $colors[] = $seg['color'];
        }

        if ($labels === []) {
            return ['labels' => [], 'values' => [], 'colors' => []];
        }

        return compact('labels', 'values', 'colors');
    }

    /**
     * @return array<int, array{label: string, pct: int, color: string, value: int}>
     */
    private function programDistribution(): array
    {
        $programs = Program::query()->withCount('videos')->get();

        $cats = [
            'Musculation' => 0,
            'Cardio' => 0,
            'Yoga' => 0,
            'Nutrition' => 0,
        ];

        foreach ($programs as $p) {
            $slug = (string) $p->slug;
            $weight = max(1, (int) $p->videos_count);

            if (str_contains($slug, 'nutrition')) {
                $cats['Nutrition'] += $weight;
            } elseif (str_contains($slug, 'amincissement') || str_contains($slug, 'debutant-femme')) {
                $cats['Cardio'] += $weight;
            } elseif (str_contains($slug, 'yoga')) {
                $cats['Yoga'] += $weight;
            } else {
                $cats['Musculation'] += $weight;
            }
        }

        $total = array_sum($cats);
        if ($total === 0) {
            return [
                ['label' => 'Musculation', 'pct' => 40, 'color' => '#e53e3e', 'value' => 40],
                ['label' => 'Cardio', 'pct' => 30, 'color' => '#3b82f6', 'value' => 30],
                ['label' => 'Yoga', 'pct' => 15, 'color' => '#22c55e', 'value' => 15],
                ['label' => 'Nutrition', 'pct' => 15, 'color' => '#eab308', 'value' => 15],
            ];
        }

        $colors = [
            'Musculation' => '#e53e3e',
            'Cardio' => '#3b82f6',
            'Yoga' => '#22c55e',
            'Nutrition' => '#eab308',
        ];

        $out = [];
        foreach ($cats as $label => $val) {
            $out[] = [
                'label' => $label,
                'pct' => (int) round($val / $total * 100),
                'color' => $colors[$label],
                'value' => (int) $val,
            ];
        }

        $sum = array_sum(array_column($out, 'pct'));
        if ($sum !== 100 && count($out) > 0) {
            $out[0]['pct'] += 100 - $sum;
        }

        return $out;
    }
}
