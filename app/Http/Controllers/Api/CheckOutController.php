<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CheckoutRequest;
use App\Http\Requests\Api\OrderRequest;
use App\Http\Services\Api\CheckoutResponseService;
use App\Http\Services\Api\CheckoutServiceCielo;
use App\Http\Services\Api\CheckoutServicePagarMe;
use App\Http\Services\Api\CheckoutServiceRede;
use App\Http\Services\UserService;
use App\Models\City;
use App\Models\Order;
use App\Models\State;
use App\Repositories\Api\OrderDataRepository;
use App\Repositories\Api\OrderRepository;



class CheckOutController extends Controller
{

    private OrderRepository $orderRepository;
    private OrderDataRepository $orderDataRepository;
    private CheckoutResponseService $checkoutResponseService;
    private CheckoutServicePagarMe $checkoutServicePagarMe;
    private CheckoutServiceRede $checkoutServiceRede;
    private CheckoutServiceCielo $checkoutServiceCielo;

    public function __construct(OrderRepository         $orderRepository,
                                OrderDataRepository     $orderDataRepository,
                                CheckoutResponseService $checkoutResponseService,
                                CheckoutServicePagarMe  $checkoutServicePagarMe,
                                CheckoutServiceRede     $checkoutServiceRede,
                                CheckoutServiceCielo    $checkoutServiceCielo
                                )
    {

        $this->orderRepository = $orderRepository;
        $this->orderDataRepository = $orderDataRepository;
        $this->checkoutResponseService = $checkoutResponseService;
        $this->checkoutServicePagarMe = $checkoutServicePagarMe;
        $this->checkoutServiceRede = $checkoutServiceRede;
        $this->checkoutServiceCielo = $checkoutServiceCielo;
    }

    public function order(OrderRequest $request, OrderRepository $orderRepository, UserService $userService)
    {
        $data = $request->all();
        $state = State::where('uf',$data['state'] )->first();
        $data['state_id'] = $state->id;
        
        $city_count = City::where('name',$data['city'])->where('state_id',$state->id )->count();

        if ($city_count > 0 ){
            $city               = City::where('name',$data['city'])->where('state_id',$state->id)->first();
            $data['city_id']    = $city->id;
        }else{
            $data['city_id']     = '9962';
        }


        $data['cel']         = limpa_cel($data['cel']);
        $user                = $userService->check($data);
        $order               = $orderRepository->checkout_store($user,$data['cart']);

        return response()->json(["order_id"=>$order->id]);

    }

    public function submit(CheckOutRequest $request,$id){

        $order      = Order::find($id);
        $data       = $request->all();
        $order_data = $this->orderDataRepository->store($order,$data);
        $order      = $this->orderRepository->update($order);

        switch ($data['operadora']) {
            case 1:
                $order_data = $this->checkoutServiceRede->submit($order,$data,$order_data);
                $this->checkoutResponseService->reload($order,$order_data);
                break;
            case 2:
                $order_data = $this->checkoutServicePagarMe->submit($order,$data,$order_data);
                $this->checkoutResponseService->reload($order,$order_data);
                break;
            case 3:
                $order_data = $this->checkoutServiceCielo->submit($order,$data,$order_data);
                $this->checkoutResponseService->reload($order,$order_data);
                break;
        }

        return response()->json($order_data);

    }

}
