<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertise;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AdvertiseController extends Controller
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
        $data = Advertise::where('status' , "sell")->get();
        
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
            'title'=>'required',
            "describtion"=>'required',
            "city_id"=>"required|exists:App\Models\City,id",
            "category_id"=>"required|exists:App\Models\Category,id",
            "from"=>"required",
            "phone"=>"required",
            "price"=>"required",
            "user_id"=>"required|exists:App\Models\User,id"
        ]);
        if($validator->fails()){
            $this->responce['message'] = $validator->errors()->first();
            $this->responce['code'] = 419;
            return $this->responce;
        }
        if(empty($request->img1) and empty($request->img2) and empty($request->img3)){
            $request->img1 = 'error.png';
        }
        else{
            if($request->hasFile('img1')){
            $fileName_1 = time().'_'.$request->file('img1')->getClientOriginalName();
            $request->file('img1')->storeAs('public/images', $fileName_1);
            }
            else{
                $fileName_1 = null;
            }
            if($request->hasFile('img2')){
            $fileName_2 = time().'_'.$request->file('img2')->getClientOriginalName();
            $request->file('img2')->storeAs('public/images', $fileName_2);
            }
            else{
                $fileName_2 = null;
            } 
            if($request->hasFile('img3')){
            $fileName_3 = time().'_'.$request->file('img3')->getClientOriginalName();
            $request->file('img3')->storeAs('public/images', $fileName_3);
            }
            else{
                $fileName_3 = null;
            }
        }
        
        Advertise::create([
            "title"=>$request->title,
            "describtion"=>$request->describtion,
            #question 1
            "view"=>000000,
            "phone"=>$request->phone,
            "top"=>true,
            #end question
            "city_id"=>$request->city_id,
            "img1"=>$fileName_1,
            "img2"=>$fileName_2,
            "img3"=>$fileName_3,
            "category_id"=>$request->category_id,
            "from"=>$request->from,
            "price"=>$request->price,
            "user_id"=>$request->user_id,
            "status"=>"sell"
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
        $user_id = Advertise::select('user_id')->where('id' , $id)->get();
        foreach($user_id as $value){
            $id =  $value->user_id;
        }
        $data = Advertise::select('title' , 'describtion' , 'cities.name as City_Name' , 'categories.name as Category_Name' , 'view' , 'price' , 'img1', 'img2','img3' )
        ->join('categories' ,'categories.id' , 'advertises.category_id')
        ->join('cities' , 'cities.id' , 'advertises.city_id')
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
    public function update(Request $request, $id) // <- DELETE
    {
        // return $request;
        if($request->status){
            Advertise::where('id' , $id)->update([
                'status'=>"sold"
            ]);
            return $this->responce;
        }else{
            Advertise::where('id' , $id)->update([
                'status'=>"deleted"
            ]);
            return $this->responce;

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //      w
    }
    public function upbeat(Request $request){
        $id = $request->id;
        $validator = Validator::make($request->all() , [
            'title'=>'required',
            "describtion"=>'required',
            "city_id"=>"required|exists:App\Models\City,id",
            "category_id"=>"required|exists:App\Models\Category,id",
            "phone"=>"required",
            "price"=>"required",
            "user_id"=>"required|exists:App\Models\User,id"
        ]);
        if($validator->fails()){
            $this->responce['message'] = $validator->errors()->first();
            $this->responce['code'] = 419;
            return $this->responce;
        }
        if(empty($request->img1) and empty($request->img2) and empty($request->img3)){
            $request->img1 = 'error.png';
        }
        else{
            if($request->hasFile('img1')){
            $fileName_1 = time().'_'.$request->file('img1')->getClientOriginalName();
            $request->file('img1')->storeAs('public/images', $fileName_1);
            }
            else{
                $fileName_1 = null;
            }
            if($request->hasFile('img2')){
            $fileName_2 = time().'_'.$request->file('img2')->getClientOriginalName();
            $request->file('img2')->storeAs('public/images', $fileName_2);
            }
            else{
                $fileName_2 = null;
            }
            if($request->hasFile('img3')){
            $fileName_3 = time().'_'.$request->file('img3')->getClientOriginalName();
            $request->file('img3')->storeAs('public/images', $fileName_3);
            }
            else{
                $fileName_3 = null;
            }
        }
        Advertise::where('id' , $id)->update([
            "title"=>$request->title,
            "describtion"=>$request->describtion,
            #question 1
            "view"=>000000,
            "phone"=>$request->phone,
            "top"=>true,
            #end question
            "city_id"=>$request->city_id,
            "img1"=>$fileName_1,
            "img2"=>$fileName_2,
            "img3"=>$fileName_3,
            "category_id"=>$request->category_id,
            "price"=>$request->price,
            "user_id"=>$request->user_id,
            "status"=>"sell"
        ]);
        return "lolo";
    }
    public function detail($id){
        
        $data = Advertise::select('title' , 'describtion' , 'cities.name as City_Name' , 'categories.name as Category_Name'  , 'categories.id as category_id', 'advertises.created_at as created_at' , 'view' , 'price' , 'img1', 'img2','img3' )
        ->join('categories' ,'categories.id' , 'advertises.category_id')
        ->join('cities' , 'cities.id' , 'advertises.city_id')
        ->where('advertises.id' , $id)
        ->get(); 
        foreach($data as $value){
            $value->similar = Advertise::select('title' , 'describtion' , 'cities.name as City_Name' , 'categories.name as Category_Name' , 'view' , 'price' , 'img1', 'img2','img3' )
            ->join('categories' ,'categories.id' , 'advertises.category_id')
            ->join('cities' , 'cities.id' , 'advertises.city_id')
            ->where('advertises.category_id' , $value->category_id)
            ->take(4)
            ->get();
            // return $value;
        }
        return $data;
    }
}

