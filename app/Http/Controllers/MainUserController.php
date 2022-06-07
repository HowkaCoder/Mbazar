<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MainUserController extends Controller
{
    
    private $responce = [
        'message'=>"success!",
        "code"=>200,
        "data"=> []
    ];

    public function register(Request $request){
        
        $validator = Validator::make($request->all() , [
            'name'=>"required",
            "phone"=>"required",
            "password"=>"required"
        ]);
        if($validator->fails()){
            $this->responce['message'] = $validator->errors()->first();
            $this->responce['code'] = 419;
            return $this->responce;
        }
        $user = User::create([
            "name"=>$request->name,
            "phone"=>$request->phone,
            "from"=>$request->from,
            "password"=>Hash::make($request->password)
        ]);
        $token = $user->createToken($request->phone)->plainTextToken;
        $this->responce['data'] = [
            'token'=>$token , 
            'user_id'=>$user->id
        ];
        return $this->responce;
    }
    public function login(Request $request){
        
        $validator = Validator::make($request->all() , [
            'phone'=>['required'],
            'password'=>['required']
        ]);
        if($validator->fails()){
            $this->responce['message'] = $validator->errors()->first();
            $this->responce['code'] = 419;
            return $this->responce;
        } 
        if (!auth()->attempt($validator->validated())) {
            return $this->responce["messsage"]="login or password is incorrect";
        }
        $user = auth()->user();
        
        $token = $user->createToken($user->phone)->plainTextToken;
        
        $this->responce['data'] = [
            'token'=>$token , 
            'user_id'=>$user->id
        ];
        return $this->responce;    
    }
    public function logout(Request $request){
        $id = $request->id;
        if(Auth::check()){
            if($id == auth()->user()->currentAccessToken()->tokenable_id ){
                auth()->user()->currentAccessToken()->delete();
                return auth()->user();
            }
        }
    }
}
