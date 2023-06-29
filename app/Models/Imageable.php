<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imageable extends Model
{

    protected $table = 'imageables';

    protected $fillable = [
        'type'
    ];


}
