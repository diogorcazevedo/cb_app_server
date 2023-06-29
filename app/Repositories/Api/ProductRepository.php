<?php

namespace App\Repositories\Api;

use App\Models\Collection;
use App\Models\Order;
use App\Models\OperadoraCartoes;
use App\Models\Product;


class ProductRepository
{

    public function store_product_images($product)
    {
/*
        if ($product->images->where('image_type_id',503)->count()>0){
            $images = $product->images()->whereIn('image_type_id',['503','502'])->get();
        }else{
            $images = $product->images()->whereIn('image_type_id',['50','502'])->get();
        }
*/
        return $product->images()->whereIn('image_type_id',['50','502'])->get();

    }

    public function store_product_features($product)
    {

                if ($product->images->where('image_type_id',806)->count()>0){
                    return  $product->images()->where('image_type_id',806)->get();
                }else{
                    return NULL;
                }




    }

}
