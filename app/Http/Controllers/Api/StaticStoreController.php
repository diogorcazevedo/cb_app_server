<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Services\FacebookApiConversoesService;
use App\Models\Topic;
use Inertia\Inertia;


class StaticStoreController extends Controller
{
    private FacebookApiConversoesService $apiConversoesService;


    public function __construct(FacebookApiConversoesService $apiConversoesService)
    {
        $this->apiConversoesService = $apiConversoesService;
    }



    public function high_jewelry( ){

        $topic = Topic::find(29);
        $products = $topic->products()
            ->with('stock')
            ->with(['images' => function($q) {
                $q->where('image_type_id',50);
            }])->has('stock')->orderBy('collection_id','desc')->get();

        $this->apiConversoesService->PageView(auth()->check(),url()->current());


        return Inertia::render('Store/HighJewelry',[
            'topic'=>$topic,
            'products'=>$products,
        ]);
    }

    public function  iconic_designs( ){

        $topic = Topic::find(31);
        $products = $topic->products()
            ->with('stock')
            ->with(['images' => function($q) {
                $q->where('image_type_id',50);
            }])->has('stock')->orderBy('collection_id','desc')->get();

        $this->apiConversoesService->PageView(auth()->check(),url()->current());


        return Inertia::render('Store/IconicDesigns',[
            'topic'=>$topic,
            'products'=>$products,
        ]);
    }


    public function unconventional( ){
        $topic = Topic::find(23);
        $products = $topic->products()
            ->with('stock')
            ->with(['images' => function($q) {
                $q->where('image_type_id',50);
            }])->has('stock')->orderBy('collection_id','desc')->get();

        $this->apiConversoesService->PageView(auth()->check(),url()->current());


        return Inertia::render('Store/Unconventional',[
            'topic'=>$topic,
            'products'=>$products,
        ]);
    }

}
