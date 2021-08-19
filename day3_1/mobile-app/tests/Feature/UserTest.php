<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /*
    public function test_createuser_success()
    {
        $data = [
            'name'=> 'jeethendernaik',
            'email'=> 'hello@gmail.com',
            'phone'=> 9999988888,
        ];

        $response = $this->json('POST', 'api/users/create',$data);
        $response->assertStatus(200)
            ->assertJson(['id'=>5,'name' => 'jeethendernaik','email'=>'hello@gmail.com','phone'=>9999988888,]);

    }

    public function test_createuser_fail()
    {
        $data = [
            'name'=> 'jeethender',
            'email'=> 'hello@gmail.com',
            'phone'=> 9999988888,
        ];

        $response = $this->json('POST', 'api/users/create',$data);
        $response->assertStatus(200)
            ->assertJson(['message'=>'this user with phone number  already exist']);

    }
    */

    /*
    public function test_deleteuser_fail()
    {
        $data = [
            'name'=> 'jeethendernaik',
            'email'=> 'hello@gmail.com',
            'phone'=> 9999988888,
        ];

        $response = $this->json('DELETE', 'api/users/delete',$data);
        $response->assertStatus(400)
            ->assertJson(['message' => "User with name-jeethendernaik does not exists"]);

    }
    */
    /*
    public function test_deleteuser_success()
    {
        $data = [
            'name'=> 'deleted',
            'email'=> 'hello@gmail.com',
            'phone'=> 9999988888,
        ];

        $response = $this->json('DELETE', 'api/users/delete',$data);
        $response->assertStatus(200)
            ->assertJson(['message' => "user with name-deleted deleted"]);

    }
    */
    public function test_searchUser_byName()
    {
        $data = [
            'name'=> 'jeethender',
            'email'=> '',
            'phone'=> 0,
        ];

        $res=[
            'id'=>3,
            'name' => 'jeethender',
            'email'=>'h@gmail.com',
            'phone'=>1234567892
        ];


       $response = $this->json('GET', 'api/users/search',$data);
       $response->assertStatus(200)
                ->assertJson([[$res]]);

    }

    public function test_searchUser_byEmail()
    {
        $data = [
            'name'=> '',
            'email'=> 'h@gmail.com',
            'phone'=> 0,
        ];

       $res=[
            'id'=>1,
            'name' => 'ugender',
            'email'=>'h@gmail.com',
            'phone'=>1234567891
        ];
        $response = $this->json('GET', 'api/users/search',$data);
        $response->assertStatus(200)
            ->assertJson($res);

    }


    public function test_searchUser_byPhone()
    {
        $data = [
            'name'=> '',
            'email'=> '',
            'phone'=> 1234567891,
        ];

        $res=[
            'id'=>1,
            'name' => 'ugender',
            'email'=>'h@gmail.com',
            'phone'=>1234567891
        ];

        $response = $this->json('GET', 'api/users/search',$data);
        $response->assertStatus(200)
            ->assertJson($res);

    }

   /*
    public function test_SearchUser_not_exists_byPhone()
    {
        $data = [
            'name'=> '',
            'email'=> '',
            'phone'=> 99288822319,
        ];

        $response = $this->json('GET', 'api/users/search',$data);
        $response->assertStatus(400)
            ->assertJson(['message' => "No user found with this phone-9928882239"]);

    }

    public function test_SearchUser_not_exists_byEmail()
    {
        $data = [
            'name'=> '',
            'email'=> 'hhh@gmail.com',
            'phone'=> 9928882239,
        ];

        $response = $this->json('GET', 'api/users/search',$data);
        $response->assertStatus(400)
            ->assertJson(['message' => "No user found with this email-hhh@gmail.com"]);

    }

    public function test_SearchUser_not_exists_byName()
    {
        $data = [
            'name'=> 'jeethenderr',
            'email'=> '',
            'phone'=> 0,
        ];

        $response = $this->json('GET', 'api/users/search',$data);
        $response->assertStatus(400)
            ->assertJson(['message' => "No user found with this name-jeethenderr"]);

    }
    */
}
