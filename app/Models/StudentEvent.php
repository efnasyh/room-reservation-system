<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentEvent extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'student_name',
        'matric_no',
        'email',
        'phone',
        'faculty',
        'payment_method',
        'payment_status',
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
