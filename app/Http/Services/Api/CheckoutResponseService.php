<?php

namespace App\Http\Services\Api;


use App\Models\User;
use App\Notifications\FailPagamento;
use App\Notifications\SuccessPagamento;


class CheckoutResponseService
{

/*
    private TinyPedidosService $tinyPedidosService;

    public function __construct(TinyPedidosService $tinyPedidosService)
    {

        $this->tinyPedidosService = $tinyPedidosService;
    }
*/


    public function reload($order,$order_data)
    {

        if ($order_data->status == 2){
            $usr  = User::find(9);
            $usr->notify(new SuccessPagamento($order->user,$order_data));
            /*
            $this->tinyPedidosService->incluir($order);
            $this->tinyPedidosService->alterar_status($order);
            $this->tinyPedidosService->lancar_estoque($order);
            $this->tinyPedidosService->gerar_nota($order);
            $this->tinyPedidosService->emitir_nota($order);
            $this->tinyPedidosService->obter_link_nota($order);
            */


        }else{
            $usr  = User::find(9);
            $usr->notify(new FailPagamento($order->user,$order_data));

        }

    }

}
