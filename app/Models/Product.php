<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $hidden = [
        "pivot",
        "created_at", 
        "updated_at", 
        "price",
        "units_in_stock", 
        "stock_ml", 
        "stock_g", 
        "unit_size_ml", 
        "unit_size_g", 
        "supplier_id",
        "id"
    ];

    public function getRouteKeyName()
    {
        return "slug";
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function sellables()
    {
        return $this->belongsToMany(Sellable::class)
            ->withPivot("quantity", "unit")
            ->withTimestamps();
    }
}
