<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
   public function modify_password(){
      $voldpassword=$_POST["voldpassword"];
      $vnewpassword=$_POST["vnewpassword"];
      if (md5($voldpassword)!==session("user")->password){
           echo "原密码错误";
          exit();
      }
      $num=DB::update("update user set password=? where id=?",[md5($vnewpassword),session("user")->id]);
      if ($num>0){
          session(["user"=>""]);
          echo "ok";
      }else{
          echo "提交失败,请重试";
      }
   }
}
