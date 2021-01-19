<?php

namespace App\Http\Controllers\home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function show(){
        $row=DB::table("site_info")->get();
        $product=DB::table("product_class")->where("p_id","0")->get();
        if (count($row)==0){
            $data="";
        }else{
            $data=$row[0];
        }
        $product_data=DB::select("select * from product group by class_id order by id desc limit ?,?",[0,6]);
        $news=DB::select("select * from news order by id desc limit ?,?",[0,4]);
        return view("index",["data"=>$data,"product"=>$product,"product_data"=>$product_data,"news"=>$news]);
    }
}
