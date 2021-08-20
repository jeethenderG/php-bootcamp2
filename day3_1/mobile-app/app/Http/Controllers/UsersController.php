<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Services\Services;


class UsersController extends Controller
{
    protected $user_service;

    public function __construct(Services $mobile_user_service)
    {
        $this->user_service = $mobile_user_service;
    }

    public function CreateUser(Request $request)
    {
        $valid = $this->user_service->Validate($request);
        if ($valid->fails()) {
            Log::error('Validation Error');
            return response(['error' => $valid->errors(), 'Validation Error'], 400);
        }

        $valid_phone = $this->user_service->ValidateUserByPhone($request);
        if ($valid_phone != 0) {
            Log::error('phone number already exist ');
            return response()->json([
                'message' => 'this user with phone number  already exist'
            ], 400);
        }

        $valid_email = $this->user_service->ValidateUserByEmail($request);
        if ($valid_email != 0) {
            Log::error('user email already exist');
            return response()->json([
                'message' => 'this user with email  already exist'
            ], 400);
        }

        $data = $this->user_service->CreateUser($request);
        Log::info("User as been created with given data");
        return response()->json([
            'id' => $data['id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ], 200);

    }

    public function GetUserByName($name)
    {

        $validator = $this->user_service->ValidateName($name);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }
        $users = $this->user_service->GetUserByName($name);
        if (count($users) == 0) {
            Log::error('no user found by name -Search');
            return response()->json([
                'message' => "No user found with this name-$name"
            ], 400);
        }
        Log::info("User has been succesfully fetched ");
        return response()->json([
            $users,
        ], 200);
    }

    public function GetUserByEmail($email)
    {
        $validator = $this->user_service->ValidateEmail($email);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }

        $users = $this->user_service->GetUserByEmail($email);
        if (count($users) == 0) {
            Log::error('no user found by email -Search');
            return response()->json([
                'message' => "No user found with this email-$email"
            ], 400);
        }
        Log::info("User has been succesfully fetched ");
        return response()->json([
            'id' => $users[0]->id,
            'name' => $users[0]->name,
            'email' => $users[0]->email,
            'phone' => $users[0]->phone,
        ], 200);
    }

    public function GetUserByPhone($phone)
    {

        $validator = $this->user_service->ValidatePhone($phone);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }

        $users = $this->user_service->GetUserByPhone($phone);
        if (count($users) == 0) {
            Log::error('no user found by give phone number -Search');
            return response()->json([
                'message' => "No user found with this phone-$phone"
            ], 400);
        }
        Log::info("User has been succesfully fetched ");
        return response()->json([
            'id' => $users[0]->id,
            'name' => $users[0]->name,
            'email' => $users[0]->email,
            'phone' => $users[0]->phone,
        ], 200);
    }


    public function GetAllUsers()
    {

        $users = $this->user_service->GetAllUsers();
        Log::info("Users have been succesfully fetched ");
        return response()->json([
            'All users' => $users
        ], 400);
    }


    public function DeleteUserByName($name)
    {

        $validator = $this->user_service->ValidateName($name);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }

        $user = $this->user_service->GetUserByName($name);
        if (count($user) == 0) {
            Log::error('no user found by name -Delete');
            return response()->json([
                'message' => "User with name-$name does not exists"
            ], 400);
        }
        $this->user_service->DeleteUserByName($name);
        Log::info("User has been succesfully deleted ");
        return response()->json([
            'message' => "user with name-$name deleted"
        ], 200);

    }

    public function DeleteUserByPhone($phone)
    {

        $validator = $this->user_service->ValidatePhone($phone);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }

        $user = $this->user_service->GetUserByPhone($phone);
        if (count($user) == 0) {
            Log::error('no user found by phone -Delete');
            return response()->json([
                'message' => "User with phone-$phone does not exists"
            ], 400);
        }

        $this->user_service->DeleteUserByPhone($phone);
        Log::info("User has been succesfully deleted ");
        return response()->json([
            'message' => "user with phone-$phone deleted"
        ], 200);
    }

    public function DeleteUserByEmail($email)
    {

        $validator = $this->user_service->ValidateEmail($email);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }

        $user = $this->user_service->GetUserByEmail($email);
        if (count($user) == 0) {
            Log::error('no user found by email -Delete');
            return response()->json([
                'message' => "User with email-$email does not exists"
            ], 400);
        }
        $this->user_service->DeleteUserByEmail($email);
        Log::info("User has been succesfully deleted ");
        return response()->json([
            'message' => "user with email-$email deleted"
        ], 200);

    }


    public function Update(Request $request, $id)
    {


        $data = $request->all();
        $count = $this->user_service->GetUserByID($id);
        if ($count == 0) {
            Log::error("no user exists - Update");
            return response()->json([
                "message" => "user with $id does not exists",
            ], 400);
        }

        $this->user_service->UpdateUser($id, $data);
        Log::info("user have been updated");
        return response()->json([
            "message" => "user with $id updated",
        ]);
    }
}
