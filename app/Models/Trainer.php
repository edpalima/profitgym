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
        'description',
        'phone',
        'email',
        'image',
        'is_active',
        'years_of_experience',
    ];

    public function workoutGuides()
    {
        return $this->hasMany(WorkoutGuide::class);
    }

    public function schedules()
    {
        return $this->hasMany(TrainerSchedule::class);
    }

    public function ratings()
    {
        return $this->hasMany(TrainerRating::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->ratings()->count();
    }

    public function getFormattedDescriptionAttribute()
    {
        $text = $this->description;

        $sentences = preg_split('/([.!?]+\s*)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        $formatted = '';

        foreach ($sentences as $index => $sentence) {
            $formatted .= ($index % 2 === 0)
                ? ucfirst(trim($sentence))
                : $sentence;
        }

        return $formatted;
    }
}