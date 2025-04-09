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
        'video_url',
        'trainer_id',
        'is_active',
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}
