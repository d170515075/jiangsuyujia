<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Monolog\Handler\IFTTTHandler;

class CommentController extends Controller
{
    public function show(){
        $row=DB::table("site_info")->get();
        if (count($row)==0){
            $data="";
        }else{
            $data=$row[0];
        }
        return view("home.comment",["data"=>$data]);
    }
    public function article_detail($id){
        $row=DB::table("site_info")->get();
        if (count($row)==0){
            $data="";
        }else{
            $data=$row[0];
        }
        $newsrow=DB::table("news")->where("id",$id)->get();
        return view("home.article_detail",["data"=>$data,"newsrow"=>$newsrow]);
    }
    public function sub_msg(){
        $full_name=trim($_POST["full_name"]);
        $email=trim($_POST["email"]);
        $qq=trim($_POST["qq"]);
        $telephone=trim($_POST["telephone"]);
        $title=trim($_POST["title"]);
        $content=trim($_POST["content"]);
        $captcha=trim($_POST["captcha"]);
       if (empty($full_name)){
           echo "请输入姓名";
           exit();
       }
       if (empty($telephone)){
           echo "请输入电话";
           exit();
       }
       if (empty($title) || empty($content)){
           echo "请输入标题和内容";
           exit();
       }
       if (empty($captcha)){
           echo "请输入验证码";
           exit();
       }
        if (strcasecmp($captcha,$_SESSION["captcha"])!==0){
            echo "验证码错误";
            exit();
        }
        $n=DB::table("message")->insert([
           "full_name"=>$full_name,
            "qq"=>$qq,
            "email"=>$email,
            "title"=>$title,
            "content"=>$content,
            "telephone"=>$telephone,
            "time"=>date("Y-m-d H:i:s")
        ]);
       if ($n>0){
           echo "ok";
       }else{
           echo "提交失败请重试";
       }
    }
}
