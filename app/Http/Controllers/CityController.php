<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
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
        $data  = City::all();
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
        $validator = Validator::make($request->all() , [
            "name"=>"required"
        ]);
        if($validator->fails()){
            $this->responce['message'] = $validator->errors()->first();
            $this->responce['code'] = 419;
            return $this->responce;
        }
        else{
            City::create(["name"=>$request->name]);
            return $this->responce;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = City::where('id' , $id)->get();
        if(count($data)==0){
            $this->responce['message'] = "Error";
            $this->responce['data'] = $id;
            $this->responce['code'] = 419;
            return $this->responce;
        }
        $this->responce['data'] = $data;
        return $this->responce;
    
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
        City::where('id' , $id)->delete();
        return $this->responce;
    }
}
