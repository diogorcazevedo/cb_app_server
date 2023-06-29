<?php

namespace App\Repositories\Api;

use App\Http\Services\Api\CartService;
use App\Models\Order;
use App\Models\OperadoraCartoes;
use App\Models\Product;
use App\Repositories\Api\OrderItemsRepository;


class OrderRepository
{
    private OrderItemsRepository $orderItemsRepository;
    private CartService $cartService;

    public function __construct(OrderItemsRepository $orderItemsRepository, CartService $cartService)
    {
        $this->orderItemsRepository = $orderItemsRepository;
        $this->cartService = $cartService;
    }

    public function checkout_store($user,$cart)
    {
        $total = $this->cartService->getTotal($cart);
        $operadora_cartoes = OperadoraCartoes::where('main',1)->first();
        $order = $this->store($user,$total,$operadora_cartoes->id);

        foreach ($cart as $k => $item){
            $product = Product::find($item['id']);
            $this->orderItemsRepository->store($order,$product,$item['hoop']);
        }

        return $order;
    }

    public function store($user,$total=null,$operadora_cartoes=null){

        $order = Order::create([
            'user_id'               => $user->id,
            'operadora_cartoes'     => $operadora_cartoes,
            'vendedor'              => (!auth()->check())? 1: auth()->user()->id,
            'operador'              => (!auth()->check())? 1: auth()->user()->id,
            'total'                 => $total,
            'origem'                => 1,
            'entregue'              => 0,
            'tipo_entrega'          => 1,
            'ponto'                 => 2,
            'centro'                => 2,
            'data'                  => date("Y-m-d"),
            'mes'                   => date("m"),
            'ano'                   => date("Y"),
            'notafiscal'            => 0,
            'status'                => 0,
        ]);

        return $order;
    }

    public function update($order){

        $order->mes                 =   date("m");
        $order->ano                 =   date("Y");
        $order->data                =   date('Y-m-d');
        $order->pagamento           =   1;
        $order->save();

        return Order::find($order->id);
    }


}
