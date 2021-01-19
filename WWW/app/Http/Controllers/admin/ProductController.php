<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
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
            $file->move("{$_SERVER["DOCUMENT_ROOT"]}/public/upload/product",$newName);
            $pic="/public/upload/product/".$newName;
            $CKEditorFuncNum = $_GET["CKEditorFuncNum"];
            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('$CKEditorFuncNum',\"$pic\",'');</script>";
        }
    }
    public function upload_img(){
         $file = Input::file("Filedata");
        if ($file->isValid()){
            $realPath=$file->getRealPath();//临时文件绝对路径
            $ext = $file->getClientOriginalExtension(); // 文件后缀名
            if ($ext!="jpg" && $ext!="png"){
                echo "只支持jpg png 图片格式";
                exit();
            }
            $newName=date("YmdHis").mt_rand(1000,9999).".".$ext;
            $file->move("{$_SERVER["DOCUMENT_ROOT"]}/public/upload/product",$newName);
            $pic="/public/upload/product/".$newName;
            return $pic;
        }
    }
    public function update_product(){
         $n=DB::table("product")->where("id",$_POST["id"])->update([
             "title"=>$_POST["title"],
             "img"=>$_POST["img"],
             "class_id"=>$_POST["class_id"],
             "content"=>$_POST["content"]
         ]);
        if ($n>0){
            echo "ok";
        }else{
            echo "提交失败,请重试";
        }
    }
    public function modify_product($id){
        $res=DB::table("product_class")->where("p_id","0")->orderBy("id","desc")->get();
        $arr=array();
        for ($i=0;$i<count($res);$i++){
            $tmparr=array();
            $child=DB::table("product_class")->where("p_id",$res[$i]->id)->get();
            if (count($child)>0){
                $tmparr["p_class"]=$res[$i];
                $tmparr["c_class"]=$child;
            }else{
                $tmparr["p_class"]=$res[$i];
                $tmparr["c_class"]=$child;
            }
            $arr[]=$tmparr;
        }
        $product=DB::select("select product.*,product_class.name from product,product_class where product.id=? 
and product_class.id=product.class_id",[$id]);
        return view("admin.modify_product",["product"=>$product,"product_class"=>$arr]);
    }
    public function browse_product(){
        $res=DB::table("product")->where("id",$_POST["id"])->get();
        return $res;
    }
    public function del(){
        $id=$_POST["id"];
        $rows=DB::select("select * from product where id in($id)");
        $str="";
        $n=DB::delete("delete from product where id in ($id)");
       if ($n>0){
           echo "ok";
           for ($i=0;$i<count($rows);$i++){
               $path=$_SERVER["DOCUMENT_ROOT"]."/public/upload/product/".$rows[$i]->img;
              if (is_file($path)){
                  unlink($path);
              }
               $str.=$rows[$i]->content;
           }
           $pattern="/\d+[.jpg|.png|.gif|.jpeg]{4,6}/i";
           preg_match_all($pattern,$str,$arr);
          for($i=0;$i<count($arr[0]);$i++){
               $path=$_SERVER["DOCUMENT_ROOT"]."/public/upload/product/".$arr[0][$i];
               if (is_file($path)){
               unlink($path);
               }
           }
       }else{
           echo "删除失败请重试";
       }
    }
    public function show(){
        $res=DB::table("product_class")->where("p_id","0")->orderBy("id","desc")->get();
        $arr=array();
        for ($i=0;$i<count($res);$i++){
            $tmparr=array();
            $child=DB::table("product_class")->where("p_id",$res[$i]->id)->get();
            if (count($child)>0){
                $tmparr["p_class"]=$res[$i];
                $tmparr["c_class"]=$child;
            }else{
                $tmparr["p_class"]=$res[$i];
                $tmparr["c_class"]=$child;
            }
            $arr[]=$tmparr;
        }
      return view("admin.insert_product")->with("product_class",$arr);
    }
    public function add(){
       $title=trim($_POST["title"]);
        $img=trim($_POST["img"]);
        $content=$_POST["content"];
        $class_id=$_POST["class_id"];
        $time=date("Y-m-d H:i:s");
        $insert=DB::insert("insert into product(title,img,class_id,content,time) values(?,?,?,?,?)",[$title,$img,$class_id,$content,$time]);
        if ($insert>0){
            echo "ok";
        }else{
            echo "提交失败,请重试";
        }
    }
  public function index(){
      $product=DB::table("product")->join("product_class","class_id","=","product_class.id")->orderBy("id","desc")
          ->select("product.*","name","product_class.name")->paginate(10);
      return view("admin.product")->with("product",$product);
  }
}
