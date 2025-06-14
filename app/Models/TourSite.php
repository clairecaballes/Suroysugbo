<?php

namespace App\Models;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class TourSite extends Model
{
    protected $table = 'tour_sites'; // Specify the table name if different from the model name
    protected $fillable = [
        'imagepath',
        'title',
        'is_published',
    ];


    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function cebuLegacy()
    {
        return $this->belongsTo(CebuLegacy::class, 'cebu_legacy_id');
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
