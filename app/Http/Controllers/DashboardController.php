<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $props=[
            'totalLegacyItems' => \App\Models\CebuLegacy::count(),
            'totalMessages' => \App\Models\Message::count(),
            'totalReviews' => \App\Models\Review::count(),
        ];

        return inertia('Dashboard', $props);
    }
}
