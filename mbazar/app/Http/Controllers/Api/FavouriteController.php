<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favourites;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class FavouriteController extends Controller
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
    public function index(Request $request)
    {
        $favourites = Favourites::select('cities.name as city_name','favourites.id as favourite_id', 'animals.id as animal_id', 'animals.*')
        ->join('animals', 'animals.id', 'favourites.animal_id')
        ->join('cities', 'cities.id', 'animals.city_id')
        ->where('favourites.user_id', $request->user_id)->get();
        $this->response['success'] = true;
        $this->response['message'] = 'favorites';
        $this->response['data'] = $favourites;
        return response()->json($this->response, 200);
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
      'user_id' => 'required',
      'animal_id' => 'required',
    ]);
    if ($validator->fails()) {
      $this->response['success'] = false;
      $this->response['message'] = $validator->errors()->first();
      return response()->json($this->response, 401);
    }

    $favourites = Favourites::where('user_id', $request->user_id)
    ->where('animal_id', $request->animal_id)->get();

    if(count($favourites) < 1){
    Favourites::create([
      'user_id' => $request->user_id,
      'animal_id' => $request->animal_id,
    ]);
    $this->response['success'] = true;
    $this->response['message'] = 'favorite created';
    $this->response['data'] = [];
    return response()->json($this->response, 200);
    }else{
    $this->response['success'] = false;
    $this->response['message'] = 'favorite alredy comment';
    $this->response['data'] = [];
    return response()->json($this->response, 200);
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
        Favourites::where('id', $id)->delete();
        $this->response['success'] = true;
        $this->response['message'] = 'favorite deleted';
        $this->response['data'] = [];
        return response()->json($this->response, 200);
    }
}
