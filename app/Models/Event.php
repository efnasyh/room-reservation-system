<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'applicant_name',
        'matric_no',
        'position',
        'phone_no',
        'club_name',
        'advisor_name',
        'email',
        'program_name',
        'location',
        'date',
        'allocation_requested',
        'participants',
        'paperwork',
        'status',
        'fee',
    ];

    public function comments()
{
    return $this->hasMany(Comment::class);
}

public function registrations()
{
    return $this->hasMany(Registration::class);
}

public function studentRegistrations()
{
    return $this->hasMany(StudentEvent::class);
}

public function feedbacks()
{
    return $this->hasMany(Feedback::class); // Feedback model
}

}

