<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Animals;
use App\Models\Categories;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnimalController extends Controller
{
  protected $response = [
    'success' => false,
    'message' => 'product no created',
    'data'    => [],
  ];
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $lastes = Animals::select('animals.*', 'cities.name as city_name', 'categories.name as category_name')
    ->join('categories', 'categories.id', 'animals.category_id')
    ->join('cities', 'cities.id', 'animals.city_id')
    ->orderBy('id', 'DESC')->get()->take(8);
    $views = Animals::select('animals.*', 'cities.name as city_name', 'categories.name as category_name')
    ->join('categories', 'categories.id', 'animals.category_id')
    ->join('cities', 'cities.id', 'animals.city_id')->orderBy('view', 'DESC')->get()->take(8);
    $this->response['success'] = true;
    $this->response['message'] = "animals";
    $this->response['data'] = [
      'lastes' => $lastes,
      'views' => $views,
    ];
    return response($this->response, 200);
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
    $validator = Validator::make($request->all(), [
      'title' => 'required',
      'description' => 'required',
      'price' => 'required',
      'phone' => 'required',
      'user_id' => 'required',
      'category_id' => 'required',
      'city_id' => 'required',
    ]);

    if ($validator->fails()) {
      $this->response['success'] = false;
      $this->response['message'] = $validator->errors()->first();
      return response()->json($this->response, 401);
    }
   
   if (empty($request->img1) && empty($request->img2) && empty($request->img3)) {
      $img1_url = Categories::select('icon')->where('id', $request->category_id)->get()[0]['icon'];
      $img2_url = null;
      $img3_url = null;
    }
    else{
      if($request->hasFile('img1')){
        $extension = $request->file('img1')->extension();
        $file_name = time().'-'.Str::random(32).'.'.$extension;
        $request->file('img1')->move(public_path('images'), $file_name);
        $img1_url = 'https://malbazar.uz/images/'.$file_name;
      }else {
        $img1_url = null;
      }
      if($request->hasFile('img2')){
        $extension = $request->file('img2')->extension();
        $file_name = time().'-'.Str::random(32).'.'.$extension;
        $request->file('img2')->move(public_path('images'), $file_name);
        $img2_url = 'https://malbazar.uz/images/'.$file_name;
      }else {
        $img2_url = null;
      }
      if($request->hasFile('img3')){
        $extension = $request->file('img3')->extension();
        $file_name = time().'-'.Str::random(32).'.'.$extension;
        $request->file('img3')->move(public_path('images'), $file_name);
        $img3_url = 'https://malbazar.uz/images/'.$file_name;
      }else{
        $img3_url = null;
      }
    }

    $animal = Animals::create([
      'title' => $request->title,
      'description' => $request->description,
      'img1' => $img1_url,
      'img2' => $img2_url,
      'img3' => $img3_url,
      'price' => $request->price,
      'view' => 0,
      'phone' => $request->phone,
      'user_id' => $request->user_id,
      'category_id' => $request->category_id,
      'city_id' => $request->city_id,
      'top' => 0,
    ]);

    if ($animal) {
      $this->response['success'] = true;
      $this->response['message'] = "successful created ads";
      $this->response['data'] = [];
      return response($this->response, 200);
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
    $count = Animals::where('id', $id)->get()->count();
    
    if($count > 0){
    $data = DB::table('animals')->select('animals.*', 'categories.name as category_name', 'cities.name as city_name')
    ->join('categories', 'categories.id', 'animals.category_id')
    ->join('cities', 'cities.id', 'animals.city_id')->where('animals.id', $id)->get();
    Animals::find($id)->increment('view');
    $likes = Animals::select('animals.*','categories.name as category_name', 'cities.name as city_name')
    ->join('categories', 'categories.id', 'animals.category_id')
    ->join('cities', 'cities.id', 'animals.city_id')
    ->where('animals.category_id', $data[0]->category_id)
    ->inRandomOrder()->get()->take(8);
    $this->response['success'] = true;
    $this->response['message'] = "one ads";
    $this->response['data'] = [
        'animal' => $data[0],
        'likes' => $likes,
        'commentsCount' => 4,
    ];
    }else{
    $this->response['success'] = true;
    $this->response['message'] = "not found";
    $this->response['data'] = [];  
    }
    
    return response($this->response, 200);
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
    // Animals::find($id)->delete();
    // $this->response['success'] = true;
    // $this->response['message'] = "deleted";
    // $this->response['data'] = [];  
  }
}
