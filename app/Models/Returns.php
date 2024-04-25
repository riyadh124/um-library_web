<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrow_id',
        'returned_at',
        'fine_amount',
    ];

    public function borrow()
    {
        return $this->belongsTo(Borrow::class);
    }
}