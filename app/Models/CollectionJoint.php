<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;


class CollectionJoint extends Model
{


    protected $table = "collection_joint";
    protected $fillable = [
        'collection_id',
        'joint_id',

    ];


    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function joint()
    {
        return $this->belongsTo(Collection::class,'joint_id', 'id');
    }


}
