<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comments;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
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
      //'required|exists:App\Models\User,phone'
    $validator = Validator::make($request->all(), [
      'user_id' => 'required',
      'animal_id' => 'required',
      'text' => 'required',
    ]);
    if ($validator->fails()) {
      $this->response['success'] = false;
      $this->response['message'] = $validator->errors()->first();
      return response()->json($this->response, 401);
    }
    Comments::create([
      'user_id' => $request->user_id,
      'animal_id' => $request->animal_id,
      'text' => $request->text,
    ]);

    $this->response['success'] = true;
    $this->response['message'] = 'created comment';
    $this->response['data'] = [];
    return response()->json($this->response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comments = Comments::select('users.name as user_name', 'comments.*')
        ->join('users', 'users.id', 'comments.user_id')
        ->where('animal_id', $id)->get();
        $this->response['success'] = true;
        $this->response['message'] = 'comments';
        $this->response['data'] = $comments;
        return response()->json($this->response, 200);

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
        $deleted = Comments::findOrfail($id)->delete();
        $this->response['success'] = true;
        $this->response['message'] = 'deleted comment';
        $this->response['data'] = [];
        return response()->json($this->response, 200);
    }
}
