<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $fillable = [
        'type','image_type_id','extension'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
    public function collections()
    {
        return $this->morphedByMany(Collection::class, 'imageable');
    }
    public function products()
    {
        return $this->morphedByMany(Product::class, 'imageable');
    }
    public function creations()
    {
        return $this->morphedByMany(Creation::class, 'imageable');
    }
    public function imageType()
    {
        return $this->belongsTo(ImageType::class);
    }



}
