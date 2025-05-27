<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleRoute extends Model
{
    protected $table = 'vehicle_route'; // Specify the table name if different
    protected $primaryKey = 'id'; // Specify the primary key if different
    public $timestamps = false; // Enable timestamps if your table has created_at and updated_at columns
    protected $fillable = [
        'route_name',
        'cebu_legacy_id',
        'vehicle_code',
        'price',
        'route_name',
        'from',
        'to',
        'description',
    ];
}
