<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function insertdata(){
        return view('user_create');
    }
    public function createuser(Request $request)
    {
        //$firstname = request('first_name');
        //$lastname  = request('last_name');
        $firstname = $request->input('first_name');
        $lastname = $request->input('last_name');

        $data=array('first_name'=>$firstname,"last_name"=>$lastname);
        $id = DB::table('member')->insertGetId($data);


        return response()->json([
            'id' => $id ,
            'first_name' => $firstname,
            'last_name'  => $lastname,
        ]);

        //echo '<a href = "/insert">Click Here</a> to go back to insert more data.';
    }

    public function getuserbyid($id)
    {
        $users = DB::table('member')->where('id' , $id )->get();
        if (count($users) == 0 )
        {
            return response()->json([
                'message' => "No user found with this id-$id"
            ]);
        }
        return response()->json([
            "id" => $users[0]->id,
            "first_name" => $users[0]->first_name,
            "last_name" => $users[0]->last_name
        ]);

        //return view('user_view',['users' =>$users]);
    }

    public function getallusers()
    {
        $users = DB::table('member')
            ->get();

        return response()->json([
            'All users' => $users
        ]);

        //return view('user_view',['users'=>$users]);
    }

    public function deleteuser($id)
    {
        $count = DB::table('member')
            ->where('id' , $id)
            ->count();
        if ($count == 0)
        {
            return response()->json([
                'message' => "User with id-$id does not exists"
            ]);
        }
        DB::table('member')
            ->where('id' , $id)
            ->delete();

        return response()->json([
            'message' => "user with id-$id deleted"
        ]);
    }
}
