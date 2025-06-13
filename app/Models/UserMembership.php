<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'membership_id',
        'status',
        'upgrade',
        'is_active',
        'payment_id',
        'start_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function payments()
    {
        return $this->morphMany(\App\Models\Payment::class, 'typeable', 'type', 'type_id');
    }

    public function scopeActiveForDate($query, $date)
    {
        return $query->where('is_active', true)
            ->where('status', 'APPROVED')
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date);
    }
}
