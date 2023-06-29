<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SubCategories extends Model
{
    protected $table="sub_categories";

    protected $fillable = [
        'name',
        'slug',
        'line_up',

    ];



    public function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => $value,
        );
    }

    
    public function products()
    {
        return $this->belongsToMany(Product::class,'product_sub_category');
    }

}
