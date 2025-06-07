<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function sellables()
    {
        return $this->belongsToMany(Sellable::class)
            ->withPivot('quantity', 'unit')
            ->withTimestamps();
    }
}
