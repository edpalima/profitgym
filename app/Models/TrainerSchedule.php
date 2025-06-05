<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'day',
        'start_time',
        'end_time',
        'class_type',
        'availability'
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}