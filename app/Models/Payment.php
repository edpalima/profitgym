<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'type',
        'type_id',
        'amount',
        'payment_method',
        'status',
        'payment_date',
        'image',
        'reference_no',
    ];

    public function typeable()
    {
        return $this->morphTo('typeable', 'type', 'type_id');
    }

    public function getCustomerNameAttribute()
    {
        return $this->typeable && method_exists($this->typeable, 'user')
            ? $this->typeable->user->name
            : null;
    }
}
