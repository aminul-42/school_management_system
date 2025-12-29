<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'type',
        'youtube_link',
        'live_scheduled_at',
        'order',
    ];

    // 🔹 Needed for reverse relationship (lecture → course)
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
