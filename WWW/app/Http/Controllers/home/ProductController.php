<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{
    public function show($id="",$type=""){
        $res=DB::table("product_class")->where("p_id","0")->get();
        $arr=array();
        for ($i=0;$i<count($res);$i++){
            $tmparr=array();
            $child=DB::table("product_class")->where("p_id",$res[$i]->id)->get();
            $tmparr["p_class"]=$res[$i];
                $tmparr["c_class"]=$child;
            $arr[]=$tmparr;
        }
        $site=DB::table("site_info")->get();
        if (count($site)==0){
            $data="";
        }else{
            $data=$site[0];
        }
        if (isset($_GET["search"]) && $_GET["search"]!=""){
            $perPage=12;
            if (!isset($_GET["page"]) || empty($_GET["page"]) || $_GET["page"]<=0){
                $page=1;
            }else{
                $page=$_GET["page"];
            }
             $all=DB::select("select id from product where title like ?",["%{$_GET["search"]}%"]);
            $total=count($all);
            $items=DB::select("select * from product where title like ? limit ?,?",["%{$_GET["search"]}%",($page-1)*$perPage,$perPage]);
            $product=new LengthAwarePaginator($items,$total,$perPage,$page,[
                "path"=>asset("/index.php/product")."/?search={$_GET["search"]}",
                "pageName"=>"page"
            ]);
        }else if (empty($type) || empty($id)){
            $product=DB::table("product")->paginate(12);
        }else if ($type=="c_id"){
            $product=DB::table("product")->where("class_id",$id)->paginate(12);
        }else if ($type=="p_id"){
           $perPage=12;
           if (!isset($_GET["page"]) || empty($_GET["page"]) || $_GET["page"]<=0){
               $page=1;
           }else{
               $page=$_GET["page"];
           }
           $c_id=DB::table("product_class")->where("p_id",$id)->lists("id");
          $inid=implode(",",$c_id);
          $all=DB::select("select id from product where class_id in ($inid)");
           $total=count($all);
           $items=DB::select("select * from product where class_id in ($inid) limit ?,?",[($page-1)*$perPage,$perPage]);
           $product=new LengthAwarePaginator($items,$total,$perPage,$page,[
                "path"=>asset("/index.php/product")."/{$id}/{$type}",
               "pageName"=>"page"
           ]);
        }
        return view("home.product",["product_class"=>$arr,"product"=>$product,"data"=>$data]);
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
    public function product_detail($id){
        $row=DB::table("site_info")->get();
        if (count($row)==0){
            $data="";
        }else{
            $data=$row[0];
        }
        $res=DB::table("product_class")->where("p_id","0")->get();
        $arr=array();
        for ($i=0;$i<count($res);$i++){
            $tmparr=array();
            $child=DB::table("product_class")->where("p_id",$res[$i]->id)->get();
            $tmparr["p_class"]=$res[$i];
            $tmparr["c_class"]=$child;
            $arr[]=$tmparr;
        }
        $product_detail=DB::table("product")->where("id",$id)->get();
        $prev=DB::select("select * from product where id<? order by id desc limit ?,?",[$id,0,5]);
        $next=DB::select("select * from product where id>? limit ?,?",[$id,0,5]);
         return view("home.product_detail",[
            "data"=>$data,
            "product_class"=>$arr,
            "product_detail"=>$product_detail,
            "prev"=>$prev,
             "next"=>$next
        ]);
    }
}
