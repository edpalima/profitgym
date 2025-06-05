<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'user_id',
        'rating',
        'feedback',
        'recommend'
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}