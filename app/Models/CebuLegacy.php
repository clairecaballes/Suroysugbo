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
            return Storage::disk('s3')->url($this->imagepath);
        }
        return null; // Or a default image URL
    }
}
