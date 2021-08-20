<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Services;


class UsersController extends Controller
{
    protected $user_service;

    public function __construct(Services $mobile_user_service)
    {
        $this->user_service = $mobile_user_service;
    }

    public function createUser(Request $request)
    {
        $data = $request->all();
        return $this->user_service->validate($data);
    }

    public function getUserByName($name)
    {
        return $this->user_service->getUserByName($name);
    }

    public function getUserByEmail($email)
    {
        return $this->user_service->getUserByEmail($email);
    }

    public function getUserByPhone($phone)
    {
        return $this->user_service->getUserByPhone($phone);
    }

    public function getAllUsers()
    {
        return $this->user_service->getAllUsers();
    }

    public function deleteUserByName($name)
    {
        return $this->user_service->deleteUserByName($name);
    }

    public function deleteUserByPhone($phone)
    {
        return $this->user_service->deleteUserByPhone($phone);
    }

    public function deleteUserByEmail($email)
    {
        return $this->user_service->deleteUserByEmail($email);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return $this->user_service->updateUser($id, $data);
    }
}
