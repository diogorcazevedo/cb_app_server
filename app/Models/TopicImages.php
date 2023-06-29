<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicImages extends Model
{

    protected $table="topic_images";
    protected $fillable = [
        'type','image_type_id','extension','topic_id','path','system'
    ];


    public function imageType()
    {
        return $this->belongsTo(ImageType::class,'image_type_id','id');
    }


    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
