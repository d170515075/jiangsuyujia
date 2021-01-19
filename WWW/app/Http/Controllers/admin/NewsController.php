<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class NewsController extends Controller
{
    public function upload(){
        $file = Input::file("upload");
        if ($file->isValid()){
            $realPath=$file->getRealPath();//临时文件绝对路径
            $ext = $file->getClientOriginalExtension(); // 文件后缀名
            if ($ext!="jpg" && $ext!="png"){
                echo "<span style='color:red;'>只支持jpg png 图片格式</span>";
                exit();
            }
            $newName=date("YmdHis").mt_rand(1000,9999).".".$ext;
           $file->move("{$_SERVER["DOCUMENT_ROOT"]}/public/upload/news",$newName);
            $pic="/public/upload/news/".$newName;
            $CKEditorFuncNum = $_GET["CKEditorFuncNum"];
            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('$CKEditorFuncNum',\"$pic\",'');</script>";
        }
    }
    public function delete(){
        $id=$_POST["id"];
        $str="";
        $totalnews=DB::select("select content from news where id in ($id)");
        for ($i=0;$i<count($totalnews);$i++){
            $str.=$totalnews[$i]->content;
        }
        $n=DB::delete("delete from news where id in($id)");
        if ($n>0){
            echo "ok";
            preg_match_all("/[0-9]+[.jpg|.png]{4}/",$str,$arr);
            for ($i=0;$i<count($arr[0]);$i++){
                $path=$_SERVER["DOCUMENT_ROOT"]."/public/upload/news/".$arr[0][$i];
                if (is_file($path)){
                    unlink($path);
                }
            }
        }else{
            echo "删除失败请重试";
        }
    }
    public function update(){
        $id=$_POST["id"];
        $title=trim($_POST["title"]);
        $content=$_POST["content"];
        $n=DB::table("news")->where("id",$id)->update(["title"=>$title,"content"=>$content]);
        if ($n>0){
            echo "ok";
        }else{
            echo "提交失败,请重试";
        }
    }
    public function modify($id){
        $news=DB::table("news")->where("id",$id)->get();
        return view("admin.modify_news",["news"=>$news]);
    }
    public function browse(){
        $id=$_POST["id"];
        $row=DB::table("news")->where("id",$id)->get();
        return $row;
    }
    public function index(){
        $news=DB::table("news")->orderBy("id","desc")->paginate(10);
        return view("admin.index")->with("news",$news);
    }
    public function add(){
        $title=trim($_POST["title"]);
        $content=$_POST["content"];
        $time=date("Y-m-d H:i:s");
        $insert=DB::insert("insert into news(title,content,time) values(?,?,?)",[$title,$content,$time]);
        if ($insert>0){
            echo "ok";
        }else{
            echo "提交失败,请重试";
        }
    }
}
