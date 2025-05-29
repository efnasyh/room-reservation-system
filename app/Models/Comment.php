<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;  // Add this import for the Event model
use App\Models\User;   // Add this import for the User model

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', // Foreign key to associate the comment with an event
        'user_id',  // Foreign key to associate the comment with a user
        'content',  // The actual comment content
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
