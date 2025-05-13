<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'duration_unit',
        'duration_value',
        'price',
        'walk_in_only',
        'is_active',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_memberships');
    }
}
