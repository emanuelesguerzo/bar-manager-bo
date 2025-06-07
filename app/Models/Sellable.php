<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sellable extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'unit')
            ->withTimestamps();
    }
}
