<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'instructor',
        'rating',
        'reviews',
        'lectures_count',
        'duration',
        'skill_level',
        'language',
        'fee',           // regular price
        'offer_price',   // discounted price
        'offer_expires_at',// date or datetime
        
    ];

    protected $dates = ['offer_expires_at'];


    public function lectures()
{
    return $this->hasMany(Lecture::class);
}

}


