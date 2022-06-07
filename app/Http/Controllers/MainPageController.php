<?php

namespace App\Http\Controllers;

use App\Models\Advertise;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    public function index(){
        $arr = [ 'mostview'=>[] , 'lastview'=>[] ];
        $arr['mostview'] = Advertise::select('advertises.id as id' , 'title' , 'price' , 'advertises.created_at as created_at' , 'cities.name as city_name' , 'advertises.img1 as img1 ', 'advertises.img2 as img2 ','advertises.img3 as img3')
        ->join('cities' , 'cities.id' , 'advertises.city_id')
        ->OrderBy('view' , 'desc')
        ->take(8)
        ->get();
        $arr['lastview'] = Advertise::select('advertises.id as id' , 'title' , 'price' , 'advertises.created_at as created_at' , 'cities.name as city_name' , 'advertises.img1 as img1 ', 'advertises.img2 as img2 ','advertises.img3 as img3')
        ->join('cities' , 'cities.id' , 'advertises.city_id')
        ->OrderBy('id' , 'desc')
        ->take(8)
        ->get();
        return $arr;
    }
}
