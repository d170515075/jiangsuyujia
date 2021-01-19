<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class AboutController extends Controller
{
    public function show(){
        $row=DB::table("site_info")->get();
        if (count($row)==0){
            $data="";
        }else{
            $data=$row[0];
        }
        return view("home.about",["data"=>$data]);
    }
}
