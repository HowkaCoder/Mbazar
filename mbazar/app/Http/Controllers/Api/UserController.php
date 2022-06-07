<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Animals;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  protected $response = [
    'success' => false,
    'message' => 'product no created',
    'data'    => [],
  ];
    /**
     * Display a listing of the resource.
     *;
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function register(Request $request){
    $validator = Validator::make($request->all(), [
      'phone' => 'required|unique:App\Models\User,phone',
      'name' => 'required',
      'password' => 'required',
    ]);

    if ($validator->fails()) {
      $this->response['success'] = false;
      $this->response['message'] = $validator->errors()->first();
      return response()->json($this->response, 401);
    }
//Hash::make($request->password)
    $user = User::create([
      'phone' => $request->phone,
      'name' => $request->name,
      'password' => $request->password,
    ]);

    $token = $user->createToken($request->phone)->plainTextToken;
    $this->response['success'] = true;
    $this->response['message'] = "successful registred";
    $this->response['data'] = [
      'token' => $token,
      'user_id' => $user->id,
    ];
    return response($this->response, 200);
    } 


    public function login(Request $request){
    $validator = Validator::make($request->all(), [
      'phone' => 'required|exists:App\Models\User,phone',
      'password' => 'required',
    ]);

    if ($validator->fails()) {
      $this->response['success'] = false;
      $this->response['message'] = $validator->errors()->first();
      return response()->json($this->response, 401);
    }

    $user = User::where('phone', $request->phone)->where('password', $request->password)->first();

    if (!$user) {
      $this->response['success'] = false;
      $this->response['message'] = "login or password is incorrect";
      return response()->json($this->response, 401);
    }

    $token = $user->createToken($request->phone)->plainTextToken;
    $this->response['success'] = true;
    $this->response['message'] = "successful login";
    $this->response['data'] = [
      'token' => $token,
      'user_id' => $user->id,
    ];
    return response($this->response, 200);
    }

    public function getme(Request $request)
    {
      return $request->user();
    }

    public function myads($id)
    {
        $user = User::find($id);
        $ads = Animals::select('animals.*', 'cities.name as city_name')
        ->join('cities', 'cities.id', 'animals.city_id')->where('user_id', $id)->get();
        if(count($ads)>0){
            $this->response['success'] = true;
            $this->response['message'] = "my ads";
        $this->response['data'] = [
            'ads' => $ads,
            'phone' => $user->phone,
            'user_name' => $user->name,
            'ads_count' => count($ads),
        ];
        return response($this->response, 200);
        }else{
            $this->response['success'] = true;
            $this->response['message='] = "empty";
            $this->response['data'] = [
                'ads' => [],
                'phone' => $user->phone,
                'user_name' => $user->name,
                'ads_count' => 0,
            ];
            return response($this->response, 200);
        }
    }
    
    public function delete_ads($id)
    {
      $deleted = Animals::where('id', $id)->delete();
      if ($deleted) {
        $this->response['success'] = true;
        $this->response['message'] = "deleted";
        $this->response['data'] = [];
        return response($this->response, 200);
      } else {
        $this->response['success'] = true;
        $this->response['message'] = "no deleted";
        $this->response['data'] = [];
        return response($this->response, 401);
      }
    }
    
}
