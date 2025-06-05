<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'featured_photo',
        'trainer_id',
        'video_url',
        'video_path', // Add this new field
        'is_active',
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}