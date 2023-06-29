<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClipImages extends Model
{

    protected $table="clip_images";

    protected $fillable = [
        'type','image_type_id','extension','collection_id','path'
    ];

    public function imageType()
    {
        return $this->belongsTo(ImageType::class);
    }


    public function clip()
    {
        return $this->belongsTo(Clip::class);
    }
}
