<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    public function sellables() {
        return $this->hasMany(Sellable::class);
    }

}
