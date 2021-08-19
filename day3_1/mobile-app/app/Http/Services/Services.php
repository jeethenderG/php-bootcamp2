<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Services{
    public function Validate(Request $request){
        $data_validate = $request->all();
        $validator = Validator::make($data_validate, [
            'name' => 'required|string|regex:/^[a-zA-Z]+$/u|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
        ]);
        return $validator;
    }

    public function ValidateUserByPhone(Request $request){
        $phone = $request->input('phone');
        $count = DB::table('customers')->where('phone',$phone)->count();

        return $count;

    }

    public function ValidateUserByName(Request $request){
        $name = $request->input('name');
        $count = DB::table('customers')->where('name',$name)->count();

        return $count;

    }

    public function ValidateUserByEmail(Request $request){
        $email = $request->input('email');
        $count = DB::table('customers')->where('email',$email)->count();

        return $count;

    }
    public function CreateUser(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');

        $data=array('name'=>$name,"phone"=>$phone,'email'=>$email);
        $id = DB::table('customers')->insertGetId($data);

        $data['id']=$id;
        return $data;
    }

    public function GetAllUsers(){
        $users = DB::table('customers')
            ->get();
        return $users;
    }

    public function GetUserByPhone($phone){
        $users = DB::table('customers')->where('phone', $phone)->get();
        return $users;
    }

    public function GetUserByEmail($email){
        $users = DB::table('customers')->where('email', $email)->get();
        return $users;
    }

    public function GetUserByName($name){
        $users = DB::table('customers')->where('name', $name)->get();
        return $users;
    }

    public function DeleteUserByName($name){
        DB::table('customers')
            ->where('name' , $name)
            ->delete();
    }
    public function DeleteUserByEmail($email){
        DB::table('customers')
            ->where('email' , $email)
            ->delete();
    }
    public function DeleteUserByPhone($phone){
        DB::table('customers')
            ->where('phone' , $phone)
            ->delete();
    }

    public function GetUserByID($id){
        $count = DB::table('customers')->where('id',$id)->count();
        return $count;
    }

    public function UpdateUser($id,$data){
        DB::table('customers')
            ->where('id',$id)
            ->update($data);
    }

}
