<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|unique:users|email',
            'password'=>'required|string|max:6|confirmed'
        ]);
        $user = User::create([
            'name'=>$fields['name'],
            'email'=>$fields['email'],
            'password'=>bcrypt($fields['password']),
        ]);

        $token = $user->createToken($user->email . 'token-name')->plainTextToken;

        return response()->json([
            'status' => 200,
            'username' => $user->name,
            'token' => $token,
            'message' => 'Registered Successfully',
        ]);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email'=>'required|string',
            'password'=>'required|max:6',
        ]);
        $user = User::where('email',$fields['email'])->first();

        if(!$user || !Hash::check($fields['password'],$user->password)){
            return response()->json([
                'message'=>'Invalid Credentials'
            ],401);
        }else {
            $token = $user->createToken($user->email . 'token-name')->plainTextToken;
            return response()->json([
                'status' => 200,
                'username' => $user->name,
                'token' => $token,
                'message' => 'Logged In Successfully',
            ]);
        }
    }

    public function logout(Request $request){
        if($request->user()){
            $request->user()->tokens()->delete();
        }
        return response()->json([
            'message'=>'logged out'
        ],200);
    }
}
