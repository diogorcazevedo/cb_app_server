<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperadoraCartoes extends Model
{
    protected $table = "operadora_cartoes";

    protected $fillable = [
        'id','name','main'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
