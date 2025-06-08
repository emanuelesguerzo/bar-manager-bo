<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function sellables()
    {
        return $this->belongsToMany(Sellable::class)
            ->withPivot("quantity")
            ->withTimestamps();
    }

    public function getTotalAttribute()
    {
        return $this->sellables->sum(function ($sellable) {
            return $sellable->price * $sellable->pivot->quantity;
        });
    }
}
