<?php
namespace App\Http\Requests\Api;
use App\Rules\ExpiryCreditCard;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class CheckoutRequest extends FormRequest
{

    public function rules()
    {
        return [
            'bandeira'      => 'required',
            'name'          => 'required',
            'number'        => 'required',
            'expiry'        => ['required',New ExpiryCreditCard()],
            'cvv'           => 'required',
            'parcelas'      => 'required',
            'operadora'     => 'required',
        ];


    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

}
