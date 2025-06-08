<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sellable extends Model
{
    protected $hidden = [
        "pivot", 
        "category_id",
        "created_at", 
        "updated_at"
    ];

    public function getRouteKeyName()
    {
        return "slug";
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot("quantity", "unit")
            ->withTimestamps();
    }

    public function orders() {
        return $this->belongsToMany(Order::class)
            ->withPivot("quantity")
            ->withTimestamps();
    }
}
