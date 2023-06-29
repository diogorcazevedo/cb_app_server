<?php
/**
 * Created by PhpStorm.
 * User: diogoazevedo
 * Date: 23/11/15
 * Time: 22:30
 */

namespace App\Http\Services\Api;

use App\Models\Order;
use App\Models\OrderData;
use Illuminate\Support\Facades\Http;
use Rede\Environment;
use Rede\eRede;
use Rede\Store;
use Rede\ThreeDSecure;
use Rede\Transaction;
use Rede\Url;

class CheckoutServiceRede
{


    public function __construct()
    {

    }


    public function submit($order,$data,$order_data)
    {
        $expiry = explode('/',$data['expiry']);
        $data['ano'] = '20'.$expiry[1];
        $data['mes'] = $expiry[0];

        $token = "071db1dae2514da09c2111809383a004";
        //$token = "b520d21712b04742ada1f24f37ca25dd";
        $pv = "87035480";
        //$pv = "88635279";
        $n = str_replace('.', '', $data['number']);
        $number = str_replace(' ', '', $n);
        $number = str_replace('_', '', $number);

        // Configuração da loja em modo produção
        $store = new Store($pv, $token, Environment::production());

        // Transação que será autorizada
        $transaction = (new Transaction($order->total, 'pedido' . time()))->creditCard(
            $number,
            $data['cvv'],
            $data['mes'],
            $data['ano'],
            $data['name']
        );


        // Configuração de parcelamento
        $transaction->setInstallments($data['parcelas']);


        try {
            $transaction = (new eRede($store))->create($transaction);

            if ($transaction->getReturnCode() == '00') {
                $order_data->return_code_number = $transaction->getReturnCode();
                $order_data->status_message     = 'Transação aprovada';
                $order_data->error_message      = $transaction->getReturnMessage();
                $order_data->status             = 2;
                $order_data->save();

            }else{
                $order_data->return_code_number = $transaction->getReturnCode();
                $order_data->status_message     = 'Não aprovado pelo emissor';
                $order_data->error_message      = $transaction->getReturnMessage();
                $order_data->status             = 0;
                $order_data->save();

            }
        } catch (\Rede\Exception\RedeException $e) {
            $order_data->return_code_number = $e->getCode();
            $order_data->status_message     = 'Erro na tentativa (catch message)';
            $order_data->error_message      = $e->getMessage();
            $order_data->status             = 0;
            $order_data->save();
        }


        $order_data                 = OrderData::find($order_data->id);
        $order->status              = $order_data->status;
        $order->parcelamento        = $data['parcelas'];
        $order->save();

        return $order_data;

    }

}
