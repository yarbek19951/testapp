<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['create']]);
    }

    public function index(Request $request){

        $user = User::where("id",auth('api')->id())->first();
        return response()->json([
            "status"=>1,
            "data"=>$user
        ],Response::HTTP_OK);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required','email','unique:users'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'=>true,
                'message' =>  $validator->errors(),
            ] , Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = new User;
        $user->name = $request->get("name");
        $user->email = $request->get("email");
        $user->password = Hash::make($request->get("password"));
        $user->save();
        return response()->json([
            "status"=>1,
            "msg"=>"User created",
            "data"=>$user
        ],Response::HTTP_OK);
    }
}
