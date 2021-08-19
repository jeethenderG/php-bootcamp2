<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UserService extends ServiceProvider
{

    public function Validate(Request $request){
        $data_validate = $request->all();

        $validator = Validator::make($data_validate, [
            'name' => 'required|string|regex:/^[a-zA-Z]+$/u|max:25',
            'email' => 'required|email|unique:users',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
        ]);
        return $validator;
    }

    public function boot()
    {
        //
    }
}
