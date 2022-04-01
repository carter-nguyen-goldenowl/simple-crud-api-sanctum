<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'min:6|required_with:confirm_password|same:confirm_password',
        ]);
        if($validator->fails()){
            return response()->json([
                'validator_errors' => $validator->getMessageBag(),
            ]);
        }else{
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password' => hash::make($request->password),
            ]);
        }

        $token = $user->createToken($user->email . 'token-name')->plainTextToken;

        return response()->json([
            'status' => 200,
            'username' => $user->name,
            'token' => $token,
            'message' => 'Registered Successfully',
        ]);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required|string',
            'password'=>'required|max:6',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'validator_errors' => $validator->getMessageBag(),
            ]);
        }else{
            $user = User::where('email',$request->email)->first();

            if(!$user || !Hash::check($request->password,$user->password)){
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
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return response()->json([
            'status'=> 200,
            'message'=>'logged out'
        ]);
    }
}
