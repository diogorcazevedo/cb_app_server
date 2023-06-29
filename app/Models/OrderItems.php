<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItems extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable =[
        'product_id',
        'user_id',
        'preco_de_venda',
        'collection_id',
        'order_id',
        'price',
        'aro1',
        'aro2',
        'qtd'
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function scopeOfOrderUser($query,$user)
    {
        $query->whereHas('order', function ($query) use($user) {
            $query->where('user_id' , $user)->where('status' , 2);
        });
    }

}
