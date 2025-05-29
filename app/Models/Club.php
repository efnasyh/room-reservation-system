<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $table = 'clubs_and_associations';

    protected $fillable = [
        'club_name',
        'description',
        'user_id',
        'event_id',
    ];

    /**
     * Relationship with User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Event.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
