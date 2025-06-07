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

    //SIR NI-COMMENT OUT KO LANG PO, HINDI PO KASE MA SEARCH YUNG NAME SA PAYMENT NITRY KO LANG PO. 
    //public function getCustomerNameAttribute()
    //{
        //return $this->typeable && method_exists($this->typeable, 'user')
           // ? $this->typeable->user->name
            //: null;
    //}

    public function getCustomerNameAttribute()
    {
        if ($this->typeable && method_exists($this->typeable, 'user')) {
            $user = $this->typeable->user;
            return trim("{$user->first_name} {$user->last_name}");
        }
        return null;
    }


}
