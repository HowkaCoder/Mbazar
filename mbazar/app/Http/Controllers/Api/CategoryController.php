<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Animals;

class CategoryController extends Controller
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
        
    $this->response['success'] = true;
    $this->response['message'] = "successful catgories";
    $this->response['data'] = Categories::all();
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
        $animals = Animals::select('cities.name as city_name', 'categories.name as category_name', 'animals.*')
        ->join('cities', 'cities.id', 'animals.city_id')
        ->join('categories', 'categories.id', 'animals.category_id')
        ->where('animals.category_id', $id)->get();
        
    $this->response['success'] = true;
    $this->response['message'] = "successful catgories";
    $this->response['data']['animals'] = $animals;
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
        //
    }
}
