<?php

namespace App\Http\Services\Api;


use App\Models\Product;


class CartService
{

//'id'      =>$product->id,
//'qtd'     =>$qtd,
//'price'   =>$price,
//'aro1'    =>$aro1,
//'aro2'    =>$aro2,
//'name'    =>$name,
//'urlImg'  =>$urlImg,

    public function getTotal($cart)
    {
        $total = 0;
        foreach($cart as $items){
            $total+=$items['price'];
        }
        return $total;
    }


}
