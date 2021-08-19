<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Services\Services;


class UsersController extends Controller
{
    public function CreateUser(Request $request)
    {
        $user_service = new Services();
        $valid = $user_service->Validate($request);
        if ($valid->fails()) {
            Log::error('Validation Error');
            return response(['error' => $valid->errors(), 'Validation Error'],400);
        }

        $valid_phone = $user_service->ValidateUserByPhone($request);
        if ($valid_phone != 0) {
            Log::error('phone number already exist');
            return response()->json([
                'message' => 'this user with phone number  already exist'
            ],400);
        }

        $valid_name = $user_service->ValidateUserByName($request);
        if ($valid_name != 0) {
            Log::error('user name already exist');
            return response()->json([
                'message' => 'this user with name already exist'
            ],400);
        }

        $valid_email = $user_service->ValidateUserByEmail($request);
        if ($valid_email != 0) {
            Log::error('user email already exist');
            return response()->json([
                'message' => 'this user with email  already exist'
            ],400);
        }


        $data = $user_service->CreateUser($request);
        Log::info("User as been created with given data");
        return response()->json([
            'id' => $data['id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ], 200);

    }


    public function SearchUser(Request $request)
    {
        $user_service = new Services();
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');

        if ($name != null) {
            $users = $user_service->GetUserByName($name);
            if (count($users) == 0) {
                Log::error('no user found by name -Search');
                return response()->json([
                    'message' => "No user found with this name-$name"
                ],400);
            }
            Log::info("User has been succesfully fetched ");
            return response()->json([
                'id' => $users[0]->id,
                'name' => $users[0]->name,
                'email' => $users[0]->email,
                'phone' => $users[0]->phone,

            ],200);
        }
        if ($email != null) {
            $users = $user_service->GetUserByEmail($email);
            if (count($users) == 0) {
                Log::error('no user found by email -Search');
                return response()->json([
                    'message' => "No user found with this email-$email"
                ],400);
            }
            Log::info("User has been succesfully fetched ");
            return response()->json([
                'id' => $users[0]->id,
                'name' => $users[0]->name,
                'email' => $users[0]->email,
                'phone' => $users[0]->phone,
            ],200);
        }

        $users = $user_service->GetUserByPhone($phone);
        if (count($users) == 0) {
            Log::error('no user found by give phone number -Search');
            return response()->json([
                'message' => "No user found with this phone-$phone"
            ],400);
        }
        Log::info("User has been succesfully fetched ");
        return response()->json([
            'id' => $users[0]->id,
            'name' => $users[0]->name,
            'email' => $users[0]->email,
            'phone' => $users[0]->phone,
        ],200);
    }

    /*
    public function getuserbyname($name)
    {
        $users = DB::table('customers')->where('name', $name )->get();
        if (count($users) == 0 )
        {
            return response()->json([
                'message' => "No user found with this name-$name"
            ]);
        }
        return response()->json([
            "users by name" => $users,
        ]);
    }

    public function getuserbyemail($email)
    {
        $users = DB::table('customers')->where('email', $email )->get();
        if (count($users) == 0 )
        {
            return response()->json([
                'message' => "No user found with this name-$email"
            ]);
        }
        return response()->json([
            "users with give email" => $users,
        ]);
    }

    public function getuserbyphone($phone)
    {
        $users = DB::table('customers')->where('phone', $phone)->get();
        if (count($users) == 0 )
        {
            return response()->json([
                'message' => "No user found with this phone-$phone"
            ]);
        }
        return response()->json([
            "id" => $users[0]->id,
            "phone" => $users[0]->phone,
            "email" => $users[0]->email,
            "name" => $users[0]->name,
        ]);
    }
    */


    public function GetAllUsers()
    {
        $user_service = new Services();
        $users = $user_service->GetAllUsers();
        Log::info("Users have been succesfully fetched ");
        return response()->json([
            'All users' => $users
        ],400);
    }

    public function DeleteUser(Request $request)
    {
        $user_service = new Services();
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');

        if ($name != null) {
            $user = $user_service->GetUserByName($name);
            if (count($user) == 0) {
                Log::error('no user found by name -Delete');
                return response()->json([
                    'message' => "User with name-$name does not exists"
                ],400);
            }
            $user_service->DeleteUserByName($name);
            Log::info("User has been succesfully deleted ");
            return response()->json([
                'message' => "user with name-$name deleted"
            ],200);
        }
        if ($email != null) {
            $user = $user_service->GetUserByEmail($email);
            if (count($user) == 0) {
                Log::error('no user found by email -Delete');
                return response()->json([
                    'message' => "User with email-$email does not exists"
                ],400);
            }
            $user_service->DeleteUserByEmail($email);
            Log::info("User has been succesfully deleted ");
            return response()->json([
                'message' => "user with email-$email deleted"
            ],200);
        }
        $user = $user_service->GetUserByPhone($phone);
        if (count($user) == 0) {
            Log::error('no user found by phone -Delete');
            return response()->json([
                'message' => "User with phone-$phone does not exists"
            ],400);
        }
        $user_service->DeleteUserByPhone($phone);
        Log::info("User has been succesfully deleted ");
        return response()->json([
            'message' => "user with phone-$phone deleted"
        ],200);

    }

    /*
    public function deleteuserbyname($name)
    {
        $count = DB::table('customers')
            ->where('name' , $name)
            ->count();
        if ($count == 0)
        {
            return response()->json([
                'message' => "User with name-$name does not exists"
            ]);
        }
        DB::table('customers')
            ->where('name' , $name)
            ->delete();

        return response()->json([
            'message' => "user with name-$name deleted"
        ]);
    }

    public function deleteuserbyphone($phone)
    {
        $count = DB::table('member')
            ->where('phone' , $phone)
            ->count();
        if ($count == 0)
        {
            return response()->json([
                'message' => "User with phone-$phone does not exists"
            ]);
        }
        DB::table('member')
            ->where('phone' , $phone)
            ->delete();

        return response()->json([
            'message' => "user with phone-$phone deleted"
        ]);
    }

    public function deleteuserbyemail($email)
    {
        $count = DB::table('member')
            ->where('email' , $email)
            ->count();
        if ($count == 0)
        {
            return response()->json([
                'message' => "User with email-$email does not exists"
            ]);
        }
        DB::table('member')
            ->where('email' , $email)
            ->delete();

        return response()->json([
            'message' => "user with email-$email deleted"
        ]);
    }
   */

    public function Update(Request $request, $id)
    {
        $user_service = new Services();

        $data = $request->all();
        $count = $user_service->GetUserByID($id);
        if ($count == 0) {
            Log::error("no user exists - Update");
            return response()->json([
                "message" => "user with $id does not exists",
            ],400);
        }
        $user_service->UpdateUser($id, $data);
        Log::info("user have been updated");
        return response()->json([
            "message" => "user with $id updated",
        ]);
    }

}
