<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingItem extends Model
{
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OutgoingItemDetail::class);
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }
}
