<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    public function show(){
        $row=DB::table("site_info")->get();
        if (count($row)==0){
            $data="";
        }else{
            $data=$row[0];
        }
        return view("admin.system",["data"=>$data]);
    }
   public function set(){
       $input=$_POST;
       unset($input["_token"]);
  $n=DB::table("site_info")->get();
     if (count($n)==0){
       $m=DB::table("site_info")->insert($input);
        }else{
        $m=DB::table("site_info")->update($input);
      }
   if ($m>0){
         echo "ok";
     }else{
         echo "提交失败请重试";
     }
   }
}
