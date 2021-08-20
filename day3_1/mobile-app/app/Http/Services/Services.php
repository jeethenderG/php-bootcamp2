<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Services
{
    // Log is used to check the flow (u can find logs in storage/logs/laravel.log
    public function validate($data)
    {
        //validates the name ,email and phone of user
        $validator = Validator::make($data, [
            'name' => 'required|string|regex:/^[a-zA-Z]+$/u|max:255',
            'email' => 'required|email|regex:/^.+@.+$/|unique:users',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|size:10',
        ]);
        if ($validator->fails()) {
            Log::error('Validation Error');
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }

        //Validate whether Phone number already exists or not
        try {
            $this->validateUserByPhone($data['phone']);
        } catch (ModelNotFoundException $exception) {
            Log::error('phone number already exist ');
            return response(['message' => $exception->getMessage()], 400);
        }

        //Validate whether email already exists or not
        try {
            $this->validateUserByEmail($data['email']);
        } catch (ModelNotFoundException $exception) {
            Log::error('user email already exist');
            return response(['message' => $exception->getMessage()], 400);
        }

        //create a user .Stores in database
        $data = $this->createUser($data);
        Log::info("User as been created with given data");

        return response()->json([
            'id' => $data['id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ], 200);

    }

    public function validatePhone($phone)
    {
        //Validator of phone(checks size =10)
        $validator = Validator::make(['data' => $phone], [
            'data' => 'regex:/^([0-9\s\-\+\(\)]*)$/|size:10'
        ]);
        return $validator;
    }

    public function validateName($name)
    {
        //Validator for name
        $validator = Validator::make(['data' => $name], [
            'data' => 'required|string'
        ]);
        return $validator;
    }

    public function validateEmail($email)
    {
        //Validator for email
        $validator = Validator::make(['data' => $email], [
            'data' => 'regex:/^.+@.+$/i'
        ]);
        return $validator;
    }

    public function validateUserByPhone($phone)
    {
        // Checks whether Phone number already exists with another user or not
        $count = DB::table('customers')->where('phone', $phone)->count();
        if ($count != 0) {
            throw new ModelNotFoundException('this user with phone number  already exist');
        }
    }

    public function validateUserByName($name)
    {
        // Checks whether name already exists with another user or not
        $count = DB::table('customers')->where('name', $name)->count();
        return $count;
    }

    public function validateUserByEmail($email)
    {
        // Checks whether email already exists with another user or not
        $count = DB::table('customers')->where('email', $email)->count();
        if ($count != 0) {
            throw new ModelNotFoundException('this user with email  already exist');
        }
    }

    public function createUser($data)
    {
        // Creates a user in database
        $id = DB::table('customers')->insertGetId($data);

        $data['id'] = $id;

        return $data;
    }

    public function getUserByName($name)
    {
        // Fetches the result from database using name a query
        // Validates name
        $validator = $this->validateName($name);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }

        //Checks wheter any user with given name exists or not
        try {
            $users = $this->checkUserByName($name);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => $exception->getMessage()], 400);
        }

        Log::info("User has been succesfully fetched ");

        return response()->json([
            $users,
        ], 200);

    }

    public function getUserByEmail($email)
    {
        // Fetches the result from database using email a query
        // Validates email
        $validator = $this->validateName($email);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }

        //Checks wheter any user with given email exists or not
        try {
            $users = $this->checkUserByEmail($email);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => $exception->getMessage()], 400);
        }

        Log::info("User has been succesfully fetched ");

        return response()->json([
            'id' => $users[0]->id,
            'name' => $users[0]->name,
            'email' => $users[0]->email,
            'phone' => $users[0]->phone,
        ], 200);

    }

    public function getUserByPhone($phone)
    {
        // Fetches the result from database using phone a query
        // Validates phone
        $validator = $this->validateName($phone);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }

        //Checks wheter any user with given phone exists or not
        try {
            $users = $this->checkUserByPhone($phone);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => $exception->getMessage()], 400);
        }

        Log::info("User has been succesfully fetched ");

        return response()->json([
            'id' => $users[0]->id,
            'name' => $users[0]->name,
            'email' => $users[0]->email,
            'phone' => $users[0]->phone,
        ], 200);

    }

    public function getAllUsers()
    {
        //fetches all the users
        $users = DB::table('customers')
            ->get();
        Log::info("Users have been succesfully fetched ");
        return response()->json([
            'All users' => $users
        ], 200);
    }

    public function checkUserByPhone($phone)
    {
        //Checks any User exists with given phone or not
        $users = DB::table('customers')->where('phone', $phone)->get();
        if (count($users) == 0) {
            throw new ModelNotFoundException("No user found with this phone-$phone");
        }
        return $users;
    }

    public function checkUserByEmail($email)
    {
        //Checks any User exists with given email or not
        $users = DB::table('customers')->where('email', $email)->get();
        if (count($users) == 0) {
            throw new ModelNotFoundException("No user found with this email-$email");
        }
        return $users;
    }

    public function checkUserByName($name)
    {
        //Checks any User exists with given name or not
        $users = DB::table('customers')->where('name', $name)->get();
        if (count($users) == 0) {
            throw new ModelNotFoundException("No user found with this name-$name");
        }
        return $users;
    }

    public function deleteUserByName($name)
    {
        //deletes the user by name
        //Validates name
        $validator = $this->validateName($name);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }

        //Checks whether any user exists with given name or not
        try {
            $user = $this->checkUserByName($name);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => $exception->getMessage()], 400);
        }

        //deletes
        DB::table('customers')
            ->where('name', $name)
            ->delete();

        Log::info("User has been succesfully deleted ");

        return response()->json([
            'message' => "user with name-$name deleted"
        ], 200);

    }

    public function deleteUserByEmail($email)
    {
        //deletes the user by email
        //Validates email
        $validator = $this->validateEmail($email);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }

        //Checks whether any user exists with given name or not
        try {
            $user = $this->checkUserByEmail($email);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => $exception->getMessage()], 400);
        }

        //deletes
        DB::table('customers')
            ->where('email', $email)
            ->delete();

        Log::info("User has been succesfully deleted ");

        return response()->json([
            'message' => "user with email-$email deleted"
        ], 200);

    }

    public function deleteUserByPhone($phone)
    {
        //deletes the user by phone
        //Validates phone
        $validator = $this->validatePhone($phone);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }

        //Checks whether any user exists with given name or not
        try {
            $user = $this->checkUserByPhone($phone);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => $exception->getMessage()], 400);
        }

        //deletes
        DB::table('customers')
            ->where('phone', $phone)
            ->delete();

        Log::info("User has been succesfully deleted ");
        return response()->json([
            'message' => "user with phone-$phone deleted"
        ], 200);

    }

    public function getUserByID($id)
    {
        //Fetches the data from data by id
        $count = DB::table('customers')->where('id', $id)->count();
        if ($count == 0) {
            throw new ModelNotFoundException("user with $id does not exists");
        }
        return $count;
    }

    public function updateUser($id, $data)
    {
        //Check user exists with given id
        try {
            $this->getUserByID($id);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => $exception->getMessage()], 400);
        }

        //update
        DB::table('customers')
            ->where('id', $id)
            ->update($data);

        Log::info("user have been updated");
        return response()->json([
            "message" => "user with $id updated",
        ]);
    }

}
