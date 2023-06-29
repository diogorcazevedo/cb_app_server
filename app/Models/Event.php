<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'slug',
        'line_up',
        'publish',

    ];

    public function getNameAttribute($value)
    {
        return mb_strtoupper($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = mb_strtoupper($value);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }

}
