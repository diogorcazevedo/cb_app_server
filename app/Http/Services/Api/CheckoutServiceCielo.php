<?php
/**
 * Created by PhpStorm.
 * User: diogoazevedo
 * Date: 23/11/15
 * Time: 22:30
 */

namespace App\Http\Services\Api;


use App\Models\OrderData;
use Illuminate\Support\Facades\Http;

class CheckoutServiceCielo
{

    public function __construct()
    {

    }


    public function submit($order,$data,$order_data)
    {
        $total = str_replace('.', '', $order->total);
        $n = str_replace('.', '', $data['number']);
        $number = str_replace(' ', '', $n);

        $expiry = explode('/',$data['expiry']);
        $data['expiry'] = $expiry[0].'/'.'20'.$expiry[1];

        if ($data['bandeira']== "mastercard"){
            $data['bandeira']='Master';
        }

        $response = Http::withHeaders([

            'MerchantId'  => 'eeb1f48e-6ab8-492b-8228-e229c9b8e70e',
            'MerchantKey' => '5BmnBM2qI9R5bR8j0rg8LjzHjUk5F82oatXSjIZb',
            'Accept' => 'application/json',
            //'User-Agent'=> 'CieloEcommerce/3.0 PHP SDK',
            // 'RequestId'=>   uniqid()

        ])->post('https://api.cieloecommerce.cielo.com.br/1/sales',[
            "MerchantOrderId"   =>$order->id,
            "Customer"          =>[
                "Name"          => $data['name']
            ],
            "Payment"           =>[
                "Type"              =>"CreditCard",
                "Capture"           =>true,
                "Amount"            =>(int)$total,
                "Installments"      =>$data['parcelas'],
                "SoftDescriptor"    =>"carlabuaiz",
                "CreditCard"        =>[
                    "CardNumber"        =>$number,
                    "Holder"            =>$data['name'],
                    "ExpirationDate"    =>$data['expiry'],
                    "SecurityCode"      =>$data['cvv'],
                    "Brand"             =>$data['bandeira']
                ],

            ],
        ]);


        $retorno = $response->json();

        if ($retorno['Payment']['Status'] == 2){

            $order_data->return_code_number = $retorno['Payment']['ReturnCode'];
            $order_data->status_message     = 'Aprovada';
            $order_data->error_message      = $retorno['Payment']['ReturnMessage'];
            $order_data->message            = 'Aprovada';
            $order_data->status             = 2;
            $order_data->save();

        }else{

            $order_data->return_code_number = $retorno['Payment']['ReturnCode'];
            $order_data->status_message     = 'NAO Aprovada';
            $order_data->error_message      = $retorno['Payment']['ReturnMessage'];
            $order_data->message            = 'NAO Aprovada';
            $order_data->status             = 0;
            $order_data->save();
        }

        $order_data = OrderData::find($order_data->id);
        $order->status              = $order_data->status;
        $order->parcelamento        = $data['parcelas'];
        $order->save();

        return $order_data;



    }

}
