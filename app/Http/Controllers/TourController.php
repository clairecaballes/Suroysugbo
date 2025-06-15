<?php

namespace App\Http\Controllers;

use App\Models\CebuLegacy;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TourController extends Controller
{
    public function index()
    {


        return Inertia::render('Tour/Index', [
            'tours' => [], // Replace with actual data retrieval logic
        ]);


    }

    public function view($id)
    {
       $legacyItem = CebuLegacy::with(['vehicleRoutes','tourSites'])->where('id',$id)
       ->where('ispublished', 1)
       ->first(); 

        if ($legacyItem) {
        // Map tourSites to include the imageUrl
        $legacyItem->tourSites = $legacyItem->tourSites->map(function ($tourSite) {
            return [
                'id' => $tourSite->id,
                'title' => $tourSite->title,
                'ispublished' => $tourSite->ispublished,
                'imageUrl' => $tourSite->imageUrl, // Use the accessor for the image URL
            ];
        });
    }

        return Inertia::render('Tour/View', [
            'legacyItem' => $legacyItem,
            'imageUrl' => $legacyItem->imageUrl// Get image URL if legacy item exists
        ]);
    }

  
}
