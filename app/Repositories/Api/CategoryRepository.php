<?php

namespace App\Repositories\Api;

use App\Models\Collection;
use App\Models\Order;
use App\Models\OperadoraCartoes;
use App\Models\Product;
use App\Models\SubCategories;


class CategoryRepository
{

    public function category_products($category)
    {

        $products = $category->products()->where('sale',1 )->whereHas('images', function($q){
            $q->where('image_type_id',50);
        })->has('stock');


        return $products->with('stock')->with(['images' => function($q) {
            $q->where('image_type_id',50);
        }])->get();

    }

    public function subcategory_products($subcategory)
    {
        $subcategory = SubCategories::find($subcategory);

        $products = $subcategory->products()
            //->where('sale',1 )
            ->with('stock')
            ->with(['images' => function($q) {
                $q->where('image_type_id',50);
            }])->has('stock')->orderBy('line_up','desc')->get();




        return $products;
    }

}
