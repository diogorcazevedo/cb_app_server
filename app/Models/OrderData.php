<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderData extends Model
{


    protected $table ="order_data";
    protected $fillable =[
        'order_id',
        'user_id',
        'bandeira',
        'name',
        'number',
        'cvv',
        'expiry',
        'parcelas',
        'checked',
        'cod_retorno',
        'status',
        'operadora',
        'total',
        'message'
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
