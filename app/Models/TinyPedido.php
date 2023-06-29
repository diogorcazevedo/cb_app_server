<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TinyPedido extends Model
{

    protected $table ="tiny_pedido";
    protected $fillable =[
        'order_id',
        'user_id',
        'numero',

    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
