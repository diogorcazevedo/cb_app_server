<?php

namespace App\Repositories\Api;

use App\Models\OrderItems;


class OrderItemsRepository
{

    public function store($order,$product,$hoop=null,$aro2=null)
    {
        OrderItems::create([
            'order_id'   =>$order->id,
            'product_id' =>$product->id,
            'price'      =>$product->stock->offered_price,
            'qtd'        =>1,
            'aro1'       =>$hoop,
            'aro2'       =>$aro2,
            'img_url'    =>$product->images->first()->id.'.'.$product->images->first()->extension,
        ]);

        return $order;
    }

    public function findByOrder($order)
    {
        return OrderItems::where('order_id',$order->id)
            ->with(['product'=>function($q){
                $q->with('images');
            }])->get();
    }


}
