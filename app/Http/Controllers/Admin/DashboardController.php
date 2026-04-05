<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Program;
use App\Models\Progress;
use App\Models\Role;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $adminRoleId = Role::query()->where('slug', 'admin')->value('id');

        $clientQuery = User::query()->when($adminRoleId, fn ($q) => $q->where('role_id', '!=', $adminRoleId));

        $membersCount = (clone $clientQuery)->count();

        $videoCount = Video::query()->count();

        $progressCount = Progress::query()->count();

        $revenueTotal = (float) Order::query()->sum('total');
        $revenueDisplay = $revenueTotal > 0
            ? number_format($revenueTotal, 0, ',', ' ').' DH'
            : '0 DH';

        $recentUsers = User::query()
            ->with('role')
            ->when($adminRoleId, fn ($q) => $q->where('role_id', '!=', $adminRoleId))
            ->latest()
            ->take(5)
            ->get();

        $donutSegments = $this->programDistribution();

        $now = now();

        $newClientsThisMonth = (clone $clientQuery)
            ->where('created_at', '>=', $now->copy()->startOfMonth())
            ->count();

        $newClientsLastMonth = (clone $clientQuery)
            ->whereBetween('created_at', [
                $now->copy()->subMonth()->startOfMonth(),
                $now->copy()->subMonth()->endOfMonth(),
            ])
            ->count();

        $newVideosThisMonth = Video::query()
            ->where('created_at', '>=', $now->copy()->startOfMonth())
            ->count();

        $newVideosLastMonth = Video::query()
            ->whereBetween('created_at', [
                $now->copy()->subMonth()->startOfMonth(),
                $now->copy()->subMonth()->endOfMonth(),
            ])
            ->count();

        $newProgressThisMonth = Progress::query()
            ->where('created_at', '>=', $now->copy()->startOfMonth())
            ->count();

        $newProgressLastMonth = Progress::query()
            ->whereBetween('created_at', [
                $now->copy()->subMonth()->startOfMonth(),
                $now->copy()->subMonth()->endOfMonth(),
            ])
            ->count();

        $revenueThisMonth = (float) Order::query()
            ->where('created_at', '>=', $now->copy()->startOfMonth())
            ->sum('total');

        $revenueLastMonth = (float) Order::query()
            ->whereBetween('created_at', [
                $now->copy()->subMonth()->startOfMonth(),
                $now->copy()->subMonth()->endOfMonth(),
            ])
            ->sum('total');

        $trends = [
            'members' => $this->percentChange($newClientsThisMonth, $newClientsLastMonth),
            'videos' => $this->percentChange($newVideosThisMonth, $newVideosLastMonth),
            'progress' => $this->percentChange($newProgressThisMonth, $newProgressLastMonth),
            'revenue' => $this->percentChange((int) round($revenueThisMonth), (int) round($revenueLastMonth)),
        ];

        $engagementChart = $this->monthlyEngagementSeries($adminRoleId);

        $chartConfig = [
            'engagement' => $engagementChart,
            'programs' => $this->programChartPayload($donutSegments),
        ];

        return view('admin.dashboard', compact(
            'membersCount',
            'videoCount',
            'progressCount',
            'revenueDisplay',
            'recentUsers',
            'donutSegments',
            'trends',
            'chartConfig',
        ));
    }

    private function percentChange(int|float $current, int|float $previous): ?float
    {
        $current = (float) $current;
        $previous = (float) $previous;

        if ($previous <= 0.0) {
            return $current > 0 ? 100.0 : null;
        }

        return round((($current - $previous) / $previous) * 100, 1);
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
