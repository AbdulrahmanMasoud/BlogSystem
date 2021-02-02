<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * This Login For Users 
     * 1- Valedation
     * 2- Check User IS Exist Or Not
     * 3- If User Not Exist Will Return False And Error Message
     * 4- if User Exist Will Generate Token And Return success Message For Him 
     */
    public function login(Request $request){
        // 1- Valedation
        $validator = Validator::make($request->all(),[
            'email'=> 'required|email',
            'password'=> 'required',
        ],$messages =[
            'email' => 'Pleas Add Valid Email address',
            'email.required' => 'We need to know your email address!',
            'password.required' => 'We need to know your Password',
        ]);
        $errors = $validator->errors();
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'msg'=>'Errorr',
                'errors'=>$errors
            ],404);
        }

        // 2- Check User
        $credentials = $request->only('email', 'password');
        $token =  Auth::guard('api')->attempt($credentials);

        // 3- if User Not Exist
        if(!$token){ 
            return response()->json([
            'status'=>false,
            'msg'=>'بيانات الدخول غير صحيحه',
            ],404);
        }

        // 4- if User Exist
        $user = Auth::guard('api')->user();
        $user->user_token = $token;
        return response()->json([
            'status'=>true,
            'msg'=>'Login User Done ',
            'user_token'=>$token,
        ],200);
    }


    /**
     * This Register For Users 
     * 1- Valedation
     * 2- Check User Is Exist Or Not If User Exist Will Return Error Messag
     * 3- If User Not Exist Will Add This User In Database And Return True Message
     */
    public function register(Request $request){
        // 1- Valedation
        
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=> 'required|unique:users',
            'password'=> 'required',
        ],$messages =[
            'name.required' => 'Pleas Add Your Name',
            'email' => 'Pleas Add Valid Email address',
            'email.required' => 'We need to know your email address!',
            'password.required' => 'We need to know your Password',
        ]);

        // 2- Check User Is Exist And Get Errors
        $errors = $validator->errors();
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'msg'=>'Errorr',
                'errors'=>$errors
            ],404);
        }

        // 3- User Is Not Exist
        $register = User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // if Has any Error In Registration
        if(!$register){
            return response()->json([
                'status'=>false,
                'msg'=>'Error Has Som Error Here',
            ],404);
        }
        // 3- Return True Mmessage
        return response()->json([
            'status'=>true,
            'msg'=>'Registerd Done',
        ],200);
        
    }
}
