<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  public function show(){
      $user=DB::table("user")->paginate(10);
      return view("admin.user")->with("user",$user);
  }
    public function delete_user(){
        $id=$_POST["id"];
        $n=DB::delete("delete from user where id in($id)");
        if ($n>0){
            echo "ok";
        }else{
            echo "删除失败请重试";
        }
    }
    public function add(){
      $sel=DB::table("user")->where( "username",$_POST["username"])->get();
      if (count($sel)>0){
          echo "用户名已经存在不可用";
          exit();
      }
      $n=DB::table("user")->insert([
          "username"=>$_POST["username"],
          "password"=>md5($_POST["password"]),
      ]);
      if ($n>0){
          echo "ok";
      }else{
          echo "添加失败请重试";
      }
    }
}
