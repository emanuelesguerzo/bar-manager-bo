<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public function getRouteKeyName() {
        return 'slug';
    }
    
    public function products() {
        return $this->hasMany(Product::class);
    }

}
