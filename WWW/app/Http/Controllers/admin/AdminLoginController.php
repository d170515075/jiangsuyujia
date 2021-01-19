<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminLoginController extends Controller
{
   public function captcha(){
     return include $_SERVER["DOCUMENT_ROOT"]."/app/lib/captcha_EN.php";
   }
   public function login(){
       $username=trim($_POST["username"]);
       $password=md5($_POST["password"]);
       $captcha=trim($_POST["captcha"]);
        if (strcasecmp($captcha,$_SESSION["captcha"])!==0){
           echo "验证码错误";
           exit();
       }
       $user=DB::select("select * from user where username=? and password=?",[$username,$password]);
       if (count($user)==0){
          echo "账号或密码错误";
       }else{
       session(["user"=>$user[0]]);
         return "login_ok";
   }
   }
   public function logout(){
       session(["user"=>""]);
   }
}
