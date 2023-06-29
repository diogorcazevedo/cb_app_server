<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Gem extends Model
{
    protected $table="gems";

    protected $fillable = [
        'name',
        'type',

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
        return $this->belongsToMany(Product::class,'product_gem');
    }

}
