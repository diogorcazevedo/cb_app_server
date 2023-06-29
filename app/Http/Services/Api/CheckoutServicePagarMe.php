<?php
/**
 * Created by PhpStorm.
 * User: diogoazevedo
 * Date: 23/11/15
 * Time: 22:30
 */

namespace App\Http\Services\Api;


use App\Models\OrderData;
use App\Models\User;
use  PagarMe\Client;
use PagarMe\Exceptions\PagarMeException;

class CheckoutServicePagarMe
{




    public function submit($order,$data,$order_data)
    {


        $user = User::find($order->user->id);

        $total = str_replace('.', '', $order->total);
        $n = str_replace('.', '', $data['number']);
        $number = str_replace(' ', '', $n);
        $number = str_replace('_', '', $number);
        $data['expiry'] = explode('/',$data['expiry']);
        $data['bandeira'] = $data['bandeira']=='master'?'mastercard':$data['bandeira'];
        $pagarme = new Client('ak_live_wgaWD1c0C1Gof8GBemnxEcAyRK8UF9');


        $n0 = removerAcento($data['name']);
        $name = str_replace('.', '', $n0);

        try {
           $transaction = $pagarme->transactions()->create([
               // 'amount' => 2500,
                'amount'                => (int)$total,
                'installments'          => $data['parcelas'],
                'payment_method'        => 'credit_card',
                'card_holder_name'      => $name,
                'card_cvv'              => $data['cvv'],
                'card_number'           => $number,
                'card_expiration_date'  => $data['expiry'][0].$data['expiry'][1],
                'customer' => [
                    'external_id' => "#$user->id",
                    'name' => $name,
                    'email' => $user->email,
                    'phone_numbers' => [ '+55'.$user->cel ],
                    'type' => 'individual',
                    'country' => 'br',
                    'documents' => [
                        [
                            'type' => 'cpf',
                            'number' =>limpaCPF_CNPJ($user->cpf)
                        ]
                    ],
                ],
                'billing' => [
                    'name' => $name,
                    'address' => [
                        'country' => 'br',
                        'street' => $user->address != NULL ? $user->address:'Aleixo Netto',
                        'street_number' => $user->number != NULL ? $user->number: '1226',
                        "city"=> $user->city != NULL ? $user->city->name: 'Vitória',
                        "state"=> $user->state != NULL ? $user->state->uf: 'ES',
                        'neighborhood' => $user->neighborhood != NULL ? $user->neighborhood: 'Praia do Canto',
                        'zipcode' => $user->zipcode != NULL ? $user->zipcode: '29055340',
                    ]
                ],
                'items' => [
                    [
                        "unit_price"        =>(int)$total,
                        "quantity"          =>1,
                        "title"             =>'product',
                        "id"                =>'1',
                        "tangible"          =>true,
                    ]
                ]
            ]);

            $order_data->return_code_number = $transaction->acquirer_response_code;
            $order_data->status_message     = 'não aprovado pelo emissor';
            $order_data->error_message      = $transaction->acquirer_response_message;
            $order_data->status             = ($transaction->status == 'paid')?2:0;
            $order_data->save();


        } catch (PagarMeException $e) {

            $order_data->return_code_number = $e->getCode();
            $order_data->message            = $e->getType();
            $order_data->error_message      = $e->getMessage();
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
