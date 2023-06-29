<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;


class Collection extends Model
{


    protected $fillable = [
        'name',
        'description',
        'slug',
        'line_up',
        'publish',
        'destaque',

    ];

    public function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => strtoupper($value),
        );
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function products()
    {
        return $this->hasMany(Product::class);

    }


    public function joints()
    {
        return $this->hasMany(CollectionJoint::class,'collection_id','id');

    }

    public function images()
    {
        return $this->hasMany(CollectionImages::class);

    }

}
