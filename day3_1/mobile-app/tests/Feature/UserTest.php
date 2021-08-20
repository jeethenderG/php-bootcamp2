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

    public function test_validation_phone_fail()
    {

        $data = [
            'name' => 'jeethendernaik',
            'email' => 'hello@gmail.com',
            'phone' => 999998888,
        ];


        $response = $this->json('POST', 'api/users/create', $data);
        $response->assertStatus(400)
            ->assertJson(['Validation Error']);

    }

    public function test_validation_email_fail()
    {

        $data = [
            'name' => 'jeethendernaik',
            'email' => 'hi',
            'phone' => 9999988888,
        ];


        $response = $this->json('POST', 'api/users/create', $data);
        $response->assertStatus(400)
            ->assertJson(['Validation Error']);

    }

    public function test_validation_name_fail()
    {

        $data = [
            'name' => '1455s',
            'email' => 'hello@gmail.com',
            'phone' => 9999988888,
        ];


        $response = $this->json('POST', 'api/users/create', $data);
        $response->assertStatus(400)
            ->assertJson(['Validation Error']);

    }


    public function test_create_user_success()
    {
        $data = [
            'name'=> 'jeeth',
            'email'=> 'mymail@gmail.com',
            'phone'=> 9848222111,
        ];

        $response = $this->json('POST', 'api/users/create',$data);
        $response->assertStatus(200)
            ->assertJson(['id'=>1,'name' => 'jeeth','email'=>'mymail@gmail.com','phone'=>9848222111,]);

    }

    public function test_create_user_fail()
    {
        $data = [
            'name'=> 'jeethender',
            'email'=> 'hee@gmail.com',
            'phone'=> 1234567890,
        ];

        $response = $this->json('POST', 'api/users/create',$data);
        $response->assertStatus(400)
            ->assertJson(['message'=>'this user with phone number  already exist']);

    }


    public function test_delete_user_by_name_fail()
    {

        $response = $this->json('DELETE', 'api/delete/name/jeethendernaik');
        $response->assertStatus(400)
            ->assertJson(['message' => "No user found with this name-jeethendernaik"]);

    }

    public function test_deleteUser_by_phone_fail()
    {

        $response = $this->json('DELETE', 'api/delete/phone/9987654321');
        $response->assertStatus(400)
            ->assertJson(['message' => "No user found with this phone-9987654321"]);

    }

    public function test_deleteUser_by_email_fail()
    {

        $response = $this->json('DELETE', 'api/delete/email/whoknows@gmail.com');
        $response->assertStatus(400)
            ->assertJson(['message' => "No user found with this email-whoknows@gmail.com"]);

    }


    public function test_delete_user_by_name_success()
    {

        $response = $this->json('DELETE', 'api/users/delete/name/dele');
        $response->assertStatus(200)
            ->assertJson(['message' => "user with name-dele deleted"]);

    }

    public function test_delete_user_by_phone_success()
    {

        $response = $this->json('DELETE', 'api/users/delete/phone/1234567899');
        $response->assertStatus(200)
            ->assertJson(['message' => "user with phone-1234567899 deleted"]);

    }
    public function test_delete_user_by_email_success()
    {

        $response = $this->json('DELETE', 'api/users/delete/email/dele@gmail.com');
        $response->assertStatus(200)
            ->assertJson(['message' => "user with email-dele@gmail.com deleted"]);

    }

    public function test_searchUser_byName()
    {
        $res = [
            'id' => 3,
            'name' => 'jeethender',
            'email' => 'hg@gmail.com',
            'phone' => 1234567893
        ];


        $response = $this->json('GET', 'api/search/name/jeethender');
        $response->assertStatus(200)
            ->assertJson([[$res]]);

    }

    public function test_searchUser_byEmail()
    {

        $res = [
            'id' => 1,
            'name' => 'ugender',
            'email' => 'h@gmail.com',
            'phone' => 1234567891
        ];
        $response = $this->json('GET', 'api/search/email/h@gmail.com');
        $response->assertStatus(200)
            ->assertJson($res);

    }


    public function test_searchUser_byPhone()
    {

        $res = [
            'id' => 1,
            'name' => 'ugender',
            'email' => 'h@gmail.com',
            'phone' => 1234567891
        ];

        $response = $this->json('GET', 'api/search/phone/1234567891');
        $response->assertStatus(200)
            ->assertJson($res);

    }


    public function test_searchUser_not_exists_byPhone()
    {

        $response = $this->json('GET', 'api/search/phone/9928882239');
        $response->assertStatus(400)
            ->assertJson(['message' => "No user found with this phone-9928882239"]);

    }

    public function test_searchUser_not_exists_byEmail()
    {

        $response = $this->json('GET', 'api/search/email/hhh@gmail.com');
        $response->assertStatus(400)
            ->assertJson(['message' => "No user found with this email-hhh@gmail.com"]);

    }

    public function test_searchUser_not_exists_byName()
    {

        $response = $this->json('GET', 'api/search/name/jeethenderr');
        $response->assertStatus(400)
            ->assertJson(['message' => "No user found with this name-jeethenderr"]);

    }

}
