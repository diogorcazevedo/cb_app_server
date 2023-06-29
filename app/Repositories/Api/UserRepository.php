<?php

namespace App\Repositories\Api;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{


    public function store($data)
    {

        $user = new User();
        $user->name         = $data['name'];
        $user->cpf          = $data['cpf'];
        $user->email        = $data['email'];
        $user->password     = Hash::make('111111');
        $user->cel          = $data['cel'];
        $user->zipcode      = $data['zipcode'];
        $user->address      = $data['address'];
        $user->number       = $data['number'];
        $user->complement   = $data['complement'];
        $user->neighborhood = $data['neighborhood'];
        $user->city_id      = $data['city_id'];
        $user->state_id     = $data['state_id'];
        $user->save();

        return $user;
    }

}
