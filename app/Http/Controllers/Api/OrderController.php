<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Services\FacebookApiConversoesService;
use App\Models\Order;


class OrderController extends Controller
{
    private FacebookApiConversoesService $apiConversoesService;

    public function __construct(FacebookApiConversoesService $apiConversoesService)
    {
        $this->apiConversoesService = $apiConversoesService;
    }

    public function show($id){

        $order = Order::find($id);
        //$this->apiConversoesService->PageView(auth()->check(),url()->current());

        return response()->json($order);
    }

}
