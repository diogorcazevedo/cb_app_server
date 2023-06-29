<?php
namespace App\Http\Requests\Api;
use App\Rules\ValidCPF;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class OrderRequest extends FormRequest
{

    public function rules()
    {
        return [
            'cart'          => 'required|array',
            'name'          => 'required|max:255|regex:/^[\pL\s\-]+$/u',
            'cel'           => 'required',
            'zipcode'       => 'required',
            'state'         => 'required',
            'city'          => 'required',
            'email'         => 'required|email|max:255',
            'address'       => 'required',
            'number'        => 'required',
            'neighborhood'  => 'required',
            'cpf'           => ['required',
                'size:14',
                //'unique:users',
                New ValidCPF()],
        ];


    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
//        throw new HttpResponseException(response()->json($validator->errors()));
    }

}
