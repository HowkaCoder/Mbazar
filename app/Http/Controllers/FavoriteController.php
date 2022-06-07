<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
{
    private $responce = [
        'message'=>"success!",
        "code"=>200,
        "data"=> []
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Favorite::all();
        return $data;
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
        $validator = Validator::make($request->all() ,[
            "user_id" => "required|exists:App\Models\User,id",
            "advertise_id" => "required|exists:App\Models\Advertise,id"
        ] );
        if($validator->fails()){
            $this->responce['message'] = $validator->errors()->first();
            $this->responce['code'] = 419;
            return $this->responce;
        }
        Favorite::create([
            "user_id"=>$request->user_id,
            "advertise_id"=>$request->advertise_id
        ]);
        return $this->responce;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Favorite::select('advertises.id as id' , 'title' , 'img1','img2','img3', 'top' , 'cities.name as city_name' , 'price' , 'favorites.created_at as created_at')
        ->join('advertises' , 'advertises.id' , 'favorites.advertise_id')
        ->join('cities' , 'cities.id' , 'advertises.city_id')
        ->where('favorites.user_id' , $id)
        ->take(8)
        ->get();
        return $data;
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
        $advertise_id = $request->advertise_id;
        Favorite::where('user_id' , $id)->where('advertise_id' , $advertise_id)->delete();
        return $this->responce;
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
}
