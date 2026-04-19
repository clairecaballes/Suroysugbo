<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Throwable;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $props = [
                'totalLegacyItems' => \App\Models\CebuLegacy::count(),
                'totalMessages' => \App\Models\Message::count(),
                'totalReviews' => \App\Models\Review::count(),
            ];
        } catch (Throwable $e) {
            report($e);

            $props = [
                'totalLegacyItems' => 0,
                'totalMessages' => 0,
                'totalReviews' => 0,
            ];
        }

        return inertia('Dashboard', $props);
    }
}
