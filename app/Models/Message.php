<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages'; // Specify the table name if different
    protected $primaryKey = 'id'; // Specify the primary key if different
    public $timestamps = true; // Enable timestamps if your table has created_at and updated_at columns
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
    ];

  
}
