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
       $legacyItem = CebuLegacy::with(['vehicleRoutes'])->where('id',$id)
       ->where('ispublished', 1)
       ->first(); 
        return Inertia::render('Tour/View', [
            'legacyItem' => $legacyItem,
            'imageUrl' => $legacyItem->imageUrl// Get image URL if legacy item exists
        ]);
    }

  
}
