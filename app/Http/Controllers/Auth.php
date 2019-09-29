<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
class Auth extends Controller
{
    public function Auth(Request $request)
    {   
        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password'=> 'required',
        ],[
            'email.required' => 'The email field is required',
            'password.required' => 'The password field is required',
        ]);

        if($validator->fails()){
    		return response(["errors"=>$validator->errors(), 'msg'=>'unprocessed request'], 422);
        }

        $credentials = $request->only('email','password');
        $token=null;
        
        try{
            if(!$token=JWTAuth::attempt($credentials))
            {
                return response()->json(['msg' => 'Invalid Password or User'],401);
            }
        }catch(JWTException $ex){
            return response()->json(['msg' => 'Internal Server error'],500);
        }
                   
        
        return response()->json(compact('token'));
        
    }
}
