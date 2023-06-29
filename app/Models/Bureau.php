<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bureau extends Model
{

    protected $fillable = [
        'id','name','alias', 'legal_entity_id','main'
    ];


}
