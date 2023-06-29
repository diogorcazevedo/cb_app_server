<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionImages extends Model
{

    protected $table="collection_images";

    protected $fillable = [
        'type','image_type_id','extension','collection_id','path'
    ];

    public function imageType()
    {
        return $this->belongsTo(ImageType::class);
    }


    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}
