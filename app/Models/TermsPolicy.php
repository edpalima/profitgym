<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content'
    ];

    /**
     * Check if this is the latest terms
     */
    public function isLatest()
    {
        return $this->id === self::latest()->first()?->id;
    }
}