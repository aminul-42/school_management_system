<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // important for login
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    // Table name (optional if follows Laravel convention)
    protected $table = 'students';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
    'name',
    'email',
    'class',
    'phone_number',
    'password',
    'profile_image',
    'father_name',
    'father_phone',
    'mother_name',
    'mother_phone',
    'alt_guardian_name',
    'alt_guardian_phone',
    'blood_group',
    'religion',
    'gender',
    'present_address',
    'permanent_address',
];


    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courses()
{
    // Use 'course_student' as the pivot table name and select the 'payment' status
    return $this->belongsToMany(Course::class)->withPivot('payment')->withTimestamps();
}
}
