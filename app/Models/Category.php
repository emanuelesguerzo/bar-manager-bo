<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $hidden = [
        "created_at", 
        "updated_at",
        "id",
    ];

    public function getRouteKeyName() {
        return "slug";
    }
    
    public function sellables() {
        return $this->hasMany(Sellable::class);
    }

}
