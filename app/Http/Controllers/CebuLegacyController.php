<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\CebuLegacy;
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
        $legacyItem = CebuLegacy::with(['vehicleRoutes'])->findOrFail($id);

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

        if ($request->input('mode') === 'edit') {
            $legacyItem = CebuLegacy::findOrFail($request->input('id'));
            $legacyItem->title = $request->input('title');
            $legacyItem->description = $request->input('description');
            $legacyItem->coordinates = $request->input('coordinates');
            $legacyItem->ispublished = $request->input('ispublished') == 'true' ? 1 : 0; // Default to false if not provided

            if (isset($imagePath)) {
                $legacyItem->imagepath = $imagePath; // Update image path if a new image is uploaded
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


    public function uploadImages(Request $request)
    {
         $request->validate([
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // Validate each image (5MB limit)
        'cebu_legacy_id' => 'required|exists:cebu_legacy,id', // Ensure the related Cebu Legacy ID exists
        'title' => 'required|string|max:255', // Title for the tour site
    ]);

    $uploadedPaths = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imageName = time() . '-' . $image->getClientOriginalName();
            $path = $image->storeAs('public/images', $imageName); // Store in storage/app/public/images
            $uploadedPaths[] = Storage::url($path); // Generate a public URL for the image

            // Save the image path and other details into the tour_site table
            DB::table('tour_site')->insert([
                'cebu_legacy_id' => $request->input('cebu_legacy_id'),
                'imagepath' => $path,
                'title' => $request->input('title'),
                'ispublished' => $request->input('ispublished', 0), // Default to 0 if not provided
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

        return response()->json(['message' => 'Images uploaded successfully!', 'paths' => $uploadedPaths]);
    }
}
