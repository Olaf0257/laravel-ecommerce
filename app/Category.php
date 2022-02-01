<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function getNameAttribute($value)
    {
    	return ucfirst($value);
    }

    public function getSlugAttribute($value)
    {
    	return lcfirst($value);
    }
}
