<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    /**
     * This Login For Admins 
     * 1- Valedation
     * 2- Check Admin IS Exist Or Not
     * 3- If Admin Not Exist Will Return False And Error Message
     * 4- if Admin Exist Will Generate Token And Return success Message For Him 
     */
    public function adminLogin(Request $request){
        // Valedation
        $validator = Validator::make($request->all(),[
            'email'=> 'required|email',
            'password'=> 'required',
        ],$messages =[
            'email' => 'Pleas Add Valid Email address',
            'email.required' => 'We need to know your email address!',
            'password.required' => 'We need to know your Password',
        ]);
        // Get Errors
        $errors = $validator->errors();
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'msg'=>'Errorr',
                'errors'=>$errors
            ],404);
        }

        // 2- Check Admin
        $credentials = $request->only('email', 'password');
        $token =  Auth::guard('admin')->attempt($credentials);

        // 3- if Admin Not Exist
        if(!$token){ 
            return response()->json([
            'status'=>false,
            'msg'=>'بيانات الدخول غير صحيحه',
            ],404);
        }

        // 4- if Admin Exist
        $admin = Auth::guard('admin')->user();
        $admin->admin_token = $token;
        return response()->json([
            'status'=>true,
            'msg'=>'Login Admin Done ',
            'admin_token'=>$token
        ],200);
        
    }

    /**
     * This Logout For Admins 
     * 1- Check This Admin or Not Using guard(admin)
     */
    public function adminLogout(){
        Auth::guard('admin')->logout();
        return response()->json([
            'status'=>true,
            'msg'=>'You Are Logout Admin',
        ]);
    }









    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

   
}
