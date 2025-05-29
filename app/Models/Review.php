<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';

    protected $fillable = [
        'name',
        'message',
        'email',
        'rating',
        'isRead',
    ];

    public function scopeUnread($query)
    {
        return $query->where('isRead', 0);
    }

    public function scopeRead($query)
    {
        return $query->where('isRead', 1);
    }
}
