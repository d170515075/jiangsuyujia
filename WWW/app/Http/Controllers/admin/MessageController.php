<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function show(){
        $msg=DB::table("message")->paginate(1);
        return view("admin.message")->with("msg",$msg);
    }
    public function delete(){
        $id=$_POST["id"];
        $n=DB::delete("delete from message where id in($id)");
        if ($n>0){
            echo "ok";
        }else{
            echo "删除失败请重试";
        }
    }
    public function get(){
        $row=DB::table("message")->where("id",$_POST["id"])->get();
        return $row;
    }
}
