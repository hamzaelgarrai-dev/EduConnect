<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
     public function register(RegisterRequest $request){


        $user = User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>$request->password,
            "role"=>$request->role,
        
        ]);

        $request->validated();
        $token = $user->createToken($request->name);

        return [

            'user' => $user,
            'token' => $token->plainTextToken
        ];

    }


        public function login(LoginRequest $request){
        
            $user = User::where('email', $request->email)->first();

            if(!$user || !Hash::check($request->password , $user->password)){

                return [
                    "message" => "the credentials are incorrect"
                ];
            }
            $token = $user->createToken($user->name);

              return [

            'user' => $user,
            'token' => $token->plainTextToken
            ];


    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return [
                    "message" => "you are logged out"
                ];
    }
}
