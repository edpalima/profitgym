<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'specialization',
        'bio',
        'phone',
        'email',
    ];

    public function workoutGuides()
    {
        return $this->hasMany(WorkoutGuide::class);
    }
}
