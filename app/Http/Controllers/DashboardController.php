<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index()
    {
        $monthlyStart = Carbon::now()->subMonths(5)->startOfMonth();
        $months = collect(range(0, 5))->map(fn ($offset) => $monthlyStart->copy()->addMonths($offset));

        $monthlyLabels = $months->map(fn ($date) => $date->format('M'))->all();

        $monthlyRequests = \App\Models\Message::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->where('created_at', '>=', $monthlyStart)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(fn ($row) => $row->year . '-' . $row->month)
            ->map(fn ($row) => (int) $row->total);

        $monthlyRequests = $months->map(fn ($date) => $monthlyRequests->get($date->year . '-' . $date->month, 0))->all();

        $props = [
            'totalLegacyItems' => \App\Models\CebuLegacy::count(),
            'totalMessages' => \App\Models\Message::count(),
            'totalReviews' => \App\Models\Review::count(),
            'monthlyLabels' => $monthlyLabels,
            'monthlyRequests' => $monthlyRequests,
        ];

        return inertia('Dashboard', $props);
    }

    public function chartData(): JsonResponse
    {
        $monthlyStart = Carbon::now()->subMonths(5)->startOfMonth();
        $months = collect(range(0, 5))->map(fn ($offset) => $monthlyStart->copy()->addMonths($offset));

        $monthlyLabels = $months->map(fn ($date) => $date->format('M'))->all();

        $monthlyRequests = \App\Models\Message::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->where('created_at', '>=', $monthlyStart)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(fn ($row) => $row->year . '-' . $row->month)
            ->map(fn ($row) => (int) $row->total);

        $monthlyRequests = $months->map(fn ($date) => $monthlyRequests->get($date->year . '-' . $date->month, 0))->all();

        return response()->json([
            'labels' => $monthlyLabels,
            'data' => $monthlyRequests,
        ]);
    }
}
