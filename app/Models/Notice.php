<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'target_type',
        'target_id',
        'is_active',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class, 'target_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'target_id');
    }
}
