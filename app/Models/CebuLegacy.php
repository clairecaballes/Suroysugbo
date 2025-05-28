<?php

namespace App\Models;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class CebuLegacy extends Model
{
    protected $table = 'cebu_legacy'; // Specify the table name if different
    protected $primaryKey = 'id'; // Specify the primary key if different
    public $timestamps = true; // Enable timestamps if your table has created_at and updated_at columns
    protected $fillable = [
        'imagepath',
        'title',
        'description',
        'map_lat',
        'map_lng',
        'ispublished',
    ];

    public function vehicleRoutes()
    {
        return $this->hasMany(VehicleRoute::class, 'cebu_legacy_id', 'id');
    }
   public function getImageUrlAttribute()
    {
        if ($this->imagepath) {
            $filePath = 'images/' . $this->imagepath; // Define the path in the public/storage/images directory
            $publicPath = public_path('storage/' . $filePath);

            // Check if the image already exists in the public directory
            if (!file_exists($publicPath)) {
                // Get the image from S3
                try {
                    $s3Image = Storage::disk('images')->get($this->imagepath);

                    // Ensure the directory exists
                    $directory = dirname($publicPath);
                    if (!is_dir($directory)) {
                        mkdir($directory, 0755, true);
                    }

                    // Store the image in the public directory
                    file_put_contents($publicPath, $s3Image);
                } catch (\Exception $e) {
                    // Handle the exception (e.g., log the error)
                    \Log::error('Error downloading image from S3: ' . $e->getMessage());
                    return null; // Or a default image URL or error placeholder
                }
            }

            return asset('storage/' . $filePath);
        }
        return null; // Or a default image URL
    }
}
