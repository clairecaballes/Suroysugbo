<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\CebuLegacy;
use App\Models\TourSite;
use App\Models\VehicleRoute; // Assuming you have a VehicleRoute model for routes
use Illuminate\Support\Facades\Storage;
class CebuLegacyController extends Controller
{
    public function index()
    {
        return Inertia::render('CebuLegacy/Index', [
            'legacyItems' => CebuLegacy::all(), // Fetch legacy items from the database
        ]);
    }

    public function edit($id)
    {
        $legacyItem = CebuLegacy::with(['vehicleRoutes', 'tourSites'])->findOrFail($id);
        // Map tourSites to include the imageUrl
        $legacyItem->tourSites = $legacyItem->tourSites->map(function ($tourSite) {
            return [
                'id' => $tourSite->id,
                'title' => $tourSite->title,
                'ispublished' => $tourSite->ispublished,
                'coordinates' => $tourSite->coordinates,
                'imageUrl' => $tourSite->imageUrl, // Use the accessor for the image URL
            ];
        });
        return Inertia::render('CebuLegacy/Edit', [
            'mode' => 'edit',
            'legacyItem' => $legacyItem, // Pass the legacy item to the edit view
        ]);
    }

    public function create()
    {
        return Inertia::render('CebuLegacy/Edit', [
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        //store data to data into database and store image to public folder

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $legacyItem = new CebuLegacy();
        $imagePath = null; // Initialize image path
        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $imagePath = Storage::disk('images')->putFileAs('images/', $image, $imageName); // Store the image in S3
            $legacyItem->imagepath = Storage::disk('images')->url($imagePath);

            if ($imagePath) { // Check if the upload was successful
                $legacyItem->imagepath = Storage::disk('images')->url($imagePath);
            } else {
                $legacyItem->imagepath = null; // Or a default value
                // Log the error, handle it appropriately
                \Log::error('S3 upload failed for image: ' . $imageName);
            }
        }

        $soundPath = null;
        if ($request->file('audio')) {
            $bgSound = $request->file('audio');
            $bgSoundName = time() . '.' . $bgSound->getClientOriginalExtension();
            $soundPath = Storage::disk('images')->putFileAs('sound/', $bgSound, $bgSoundName); // Store the image in S3
            $legacyItem->bgSoundPath = Storage::disk('images')->url($soundPath);

            if ($soundPath) { // Check if the upload was successful
                $legacyItem->bgSoundPath = Storage::disk('images')->url($soundPath);
            } else {
                $legacyItem->bgSoundPath = null;
                \Log::error('S3 upload failed for image: ' . $imageName);
            }
        }

        if ($request->input('mode') === 'edit') {
            $legacyItem = CebuLegacy::findOrFail($request->input('id'));
            $legacyItem->title = $request->input('title');
            $legacyItem->description = $request->input('description');
            $legacyItem->coordinates = $request->input('coordinates');
            $legacyItem->ispublished = $request->input('ispublished') == 'true' ? 1 : 0; // Default to false if not provided

            if (isset($imagePath)) {
                $legacyItem->imagepath = $imagePath; // Update image path if a new image is uploaded
            }
            if (isset($soundPath)) {
                $legacyItem->bgSoundPath = $soundPath; // Update sound path if a new sound is uploaded
            }
            $legacyItem->save();
            $legacyId = $legacyItem->id;
        } else {

            $legacyItem->title = $request->input('title');
            $legacyItem->description = $request->input('description');
            $legacyItem->coordinates = $request->input('coordinates');
            $legacyItem->ispublished = $request->input('ispublished') == 'true' ? 1 : 0; // Default to false if not provided
            if (isset($imagePath)) {
                $legacyItem->imagepath = $imagePath; // Update image path if a new image is uploaded
            }
            if (isset($soundPath)) {
                $legacyItem->bgSoundPath = $soundPath; // Update sound path if a new sound is uploaded
            }
            $legacyItem->save();
            $legacyId = $legacyItem->id;
        }

        $routes = json_decode($request->input('routes', []));
        if (is_array($routes)) {
            foreach ($routes as $route) {
                VehicleRoute::updateOrCreate(
                    ['id' => $route->id ?? null], // Use the route ID if it exists, otherwise create a new one
                    [
                        'route_name' => $route->route_name,
                        'cebu_legacy_id' => $legacyId,
                        'vehicle_code' => $route->vehicle_code,
                        'price' => $route->price,
                        'from' => $route->from,
                        'to' => $route->to,
                        'description' => $route->description,

                    ]
                );
            }
        }

        return redirect()->route('cebu-legacy')->with('success', 'Cebu legacy item saved successfully!');
    }

    public function showPublished()
    {
        $legacyItems = CebuLegacy::with(['vehicleRoutes'])->where('ispublished', 1)->get(); // Fetch only published legacy items

        return response()->json($legacyItems->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'imageUrl' => $item->imageUrl, // Assuming you have an accessor for image URL
                'coordinates' => $item->coordinates,
                'vehicleRoutes' => $item->vehicleRoutes, // Include vehicle routes
                'bgSoundUrl' => $item->soundUrl, // Assuming you have an accessor for sound URL
            ];
        }));
    }

    public function destroy($id)
    {
        VehicleRoute::where('id', $id)->delete(); // Delete associated vehicle routes
    }

    public function delete($id)
    {
        VehicleRoute::where('cebu_legacy_id', $id)->delete(); // Delete associated vehicle routes
        CebuLegacy::findOrFail($id)->delete(); // Delete the legacy item
    }


    public function storeTourSite(Request $request)
    {
        $request->validate([
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:10120', // Validate each image (5MB limit)
            'cebu_legacy_id' => 'required|exists:cebu_legacy,id', // Ensure the related Cebu Legacy ID exists
        ]);

        $path = ''; // Initialize path variable
        if ($request->file('image')) {
            $image = $request->file('image'); // Get the uploaded image file
            $imageName = time() . '-' . $image->getClientOriginalName();
            $path = Storage::disk('images')->putFileAs('images/', $image, $imageName);
        }

        // If no new image is uploaded, use the existing image path
        if (empty($path) && $request->input('id')) {
            $existingTourSite = TourSite::find($request->input('id'));
            if ($existingTourSite) {
                $path = $existingTourSite->imagepath;
            }
        }

        // Save the image path and other details into the tour_site table
        TourSite::updateOrCreate(['id' => $request->input('id') ?? null], [
            'cebu_legacy_id' => $request->input('cebu_legacy_id'),
            'imagepath' => $path,
            'title' => $request->input('title'),
            'coordinates' => $request->input('coordinates', null), // Default to null if not provided
            'ispublished' => intval($request->input('ispublished', 0)), // Default to 0 if not provided
        ]);



        $getSites = TourSite::where('cebu_legacy_id', $request->input('cebu_legacy_id'))->get()
            ->map(function ($tourSite) {
                return [
                    'id' => $tourSite->id,
                    'title' => $tourSite->title,
                    'ispublished' => $tourSite->ispublished,
                    'coordinates' => $tourSite->coordinates,
                    'imageUrl' => $tourSite->imageUrl, // Use the accessor for the image URL
                ];
            });

        return response()->json(['message' => 'Images uploaded successfully!', 'tourSites' => $getSites]);
    }

    public function deleteImage($id)
    {
        $tourSite = TourSite::findOrFail($id);
        $imagePath = $tourSite->imagepath;

        // Delete the image from S3
        if (Storage::disk('images')->exists($imagePath)) {
            Storage::disk('images')->delete($imagePath);
        }

        // Delete the record from the database
        $tourSite->delete();

        return response()->json(['message' => 'Image deleted successfully!']);
    }
}
