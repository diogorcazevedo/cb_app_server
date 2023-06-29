<?php

namespace App\Repositories\Api;

use App\Models\Collection;



class CollectionRepository
{


    public function store_data(){

        $collections = Collection::whereHas('images' , function($q) {
            $q->where('image_type_id',3 );
        })->whereHas('products' , function($q) {
            $q->where('sale',1 )->whereHas('images',function($q){
                $q->where('image_type_id',50 );
            })->has('stock');
        });

        return $collections->with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }])->with(['products' => function($q) {
            $q->where('sale',1 )->with(['images'=>function($q){
                $q->where('image_type_id',50 );
            }])->orderBy('category_id','asc')->with('stock');
        }])
            ->where('principal',1)->orderBy('line_up','asc')
            ->get();

    }



    public function highlights_data()
    {

        return Collection::with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }]) ->where('principal',1)
            ->orderBy('line_up','desc')
            ->get();

    }

    public function collections_data()
    {

        $collections = Collection::with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }])->whereHas('images')->where('principal',1)
            ->orderBy('line_up','asc')
            ->get();

        return $collections;

    }

    public function collections_home()
    {

        $collections = Collection::with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }])->whereHas('images')->where('principal',1)
            ->orderBy('line_up','asc')
            ->get();

        return $collections;

    }

    public function collections_group($group)
    {

        $collections = Collection::with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }])->whereHas('images')
            ->where($group,1)
            ->whereHas('products' , function($q) {
                $q->where('sale',1 )->whereHas('images',function($q){
                    $q->where('image_type_id',50 );
                })->has('stock');
            });

        return $collections->with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }])->with(['products' => function($q) {
            $q->where('sale',1 )->with(['images'=>function($q){
                $q->where('image_type_id',50 );
            }])->with('stock');
        }])->where($group,1)->orderBy('line_up','asc')->get();



    }


//APAGAR==== MODIFICAR === INÍCIO
    public function collections_green()
    {

        $collections = Collection::with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }])->whereHas('images')
            ->where('green',1)
            //->orderBy('line_up','asc')
            ->whereHas('products' , function($q) {
                $q->where('sale',1 )->whereHas('images',function($q){
                    $q->where('image_type_id',50 );
                })->has('stock');
            });

        return $collections->with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }])->with(['products' => function($q) {
            $q->where('sale',1 )->with(['images'=>function($q){
                $q->where('image_type_id',50 );
            }])->with('stock');
        }])->where('green',1)->orderBy('line_up','asc')->get();





    }
    public function collections_bee()
    {

        $collections = Collection::with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }])->whereHas('images')
            ->where('bee',1)
            //->orderBy('line_up','asc')
            ->whereHas('products' , function($q) {
                $q->where('sale',1 )->whereHas('images',function($q){
                    $q->where('image_type_id',50 );
                })->has('stock');
            });

        return $collections->with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }])->with(['products' => function($q) {
            $q->where('sale',1 )->with(['images'=>function($q){
                $q->where('image_type_id',50 );
            }])->with('stock');
        }])->where('bee',1)->orderBy('line_up','asc')->get();



    }
    public function collections_gems()
    {

        $collections = Collection::with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }])->whereHas('images')
            ->where('gems',1)
            //->orderBy('line_up','asc')
            ->whereHas('products' , function($q) {
                $q->where('sale',1 )->whereHas('images',function($q){
                    $q->where('image_type_id',50 );
                })->has('stock');
            });

        return $collections->with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }])->with(['products' => function($q) {
            $q->where('sale',1 )->with(['images'=>function($q){
                $q->where('image_type_id',50 );
            }])->with('stock');
        }])->where('gems',1)->orderBy('line_up','asc')->get();



    }
    public function collections_diamonds()
    {

        $collections = Collection::with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }])->whereHas('images')
            ->where('diamonds',1)
            //->orderBy('line_up','asc')
            ->whereHas('products' , function($q) {
                $q->where('sale',1 )->whereHas('images',function($q){
                    $q->where('image_type_id',50 );
                })->has('stock');
            });

        return $collections->with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }])->with(['products' => function($q) {
            $q->where('sale',1 )->with(['images'=>function($q){
                $q->where('image_type_id',50 );
            }])->with('stock');
        }])->where('diamonds',1)->orderBy('line_up','asc')->get();


    }
//FIM



    public function dear_data()
    {

        return Collection::with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }]) ->where('dear',1)
            ->orderBy('line_up','asc')
            ->get();

    }

    public function exclusive_data()
    {

        return Collection::with(['images' => function($q) {
            $q->where('image_type_id',3 );
        }])->whereHas('images')
            //->where('exclusive',1)
            ->orderBy('line_up','asc')
            ->get();

    }


    public function collection_products($collection)
    {
        $products = $collection->products()->whereHas('images', function($q){
            $q->where('image_type_id',50 );
        })->has('stock');


        $products =  $products->where('publish',1)->orderByDesc('sale')->with('stock')->with(['images' => function($q) {
            $q->where('image_type_id',50 );
        }])->orderBy('category_id','asc')->orderBy('line_up','asc')->get();

        return $products;
    }

}
