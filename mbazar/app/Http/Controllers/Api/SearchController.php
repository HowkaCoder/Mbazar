<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animals;
use App\Models\Categories;
use App\Models\Cities;
use App\Models\Searchs;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
  public function search(Request $request){
    $category_id = $request->category_id;
    $city_id = $request->city_id;
    $query = $request['query'];
     
    $cyr = [
        'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'ы', 'Ь', 'Э', 'Ю', 'Я'
      ];
      $lat = [
        'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'shch', '', 'y', '', 'e', 'yu', 'ya',
        'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'shch', '', 'y', '', 'e', 'yu', 'ya'
      ];
      $textcyr = str_replace($cyr, $lat, $query);
      $textlat = str_replace($lat, $cyr, $query);

      if($city_id != 'all' && $category_id != 'all') {
      $data = Animals::select('animals.*', 'cities.name')
      ->join('cities', 'cities.id', 'animals.city_id')
      ->where('category_id', $category_id)
      ->where('city_id', $city_id)
      ->where(function($res) use ($textcyr, $textlat){
        $res->where('title', 'like', '%'.$textlat.'%')
        ->orWhere('title', 'like', '%'.$textcyr.'%');
      })->get();
      }
      else if($city_id != 'all' && $category_id == 'all') {
      $data = Animals::select('animals.*', 'cities.name')
      ->join('cities', 'cities.id', 'animals.city_id')
      ->where('city_id', $city_id)
      ->where(function ($res) use ($textcyr, $textlat) {
        $res->where('title', 'like', '%' . $textlat . '%')
          ->orWhere('title', 'like', '%' . $textcyr . '%');
      })->get();
      }
     elseif($city_id == 'all' && $category_id != 'all') {
      $data = Animals::select('animals.*', 'cities.name')
      ->join('cities', 'cities.id', 'animals.city_id')
      ->where('category_id', $category_id)
      ->where(function ($res) use ($textcyr, $textlat) {
        $res->where('title', 'like', '%' . $textlat . '%')
          ->orWhere('title', 'like', '%' . $textcyr . '%');
      })->get();
    }
    elseif($city_id == 'all' && $category_id == 'all') {
      $data = Animals::select('animals.*', 'cities.name')
      ->join('cities', 'cities.id', 'animals.city_id')
      ->where(function ($res) use ($textcyr, $textlat) {
        $res->where('title', 'like', '%' . $textlat . '%')
          ->orWhere('title', 'like', '%' . $textcyr . '%');
      })->get();
    }
    $user_id = 'guest';
    if(!empty($request->user_id)){
      $user_id = $request->user_id;
    }  
      Searchs::create([
        'query' => $query,
        'user_id' => $user_id,
        'category_id' => $category_id,
        'city_id' => $city_id,
        'result' => count($data),
      ]);
      if(!empty($data)){
      $this->response['success'] = true;
      $this->response['message'] = "search results";
      $this->response['data'] = [
        'results' => $data,
      ];
      return response($this->response, 200);
      }else{
      $this->response['success'] = true;
      $this->response['message'] = "not found ads";
      $this->response['data'] = [
      ];
      return response($this->response, 401);
      }
    }

  
}
