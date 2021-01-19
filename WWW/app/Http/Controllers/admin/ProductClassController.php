<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ProductClassController extends Controller
{
    public function batch_del_class(){
        $id=$_POST["id"];
        $idarr=explode(",",$id);
        for ($i=0;$i<count($idarr);$i++){
            $row=DB::table("product_class")->where("id",$idarr[$i])->get();
            if (empty($row[0]->p_id)){
                $child=DB::table("product_class")->where("p_id",$row[0]->id)->get();
                if (count($child)>0){
                    echo "请先删除子类";
                    exit();
                }
            }
        }
        DB::beginTransaction();
        try{
            DB::update("update product set class_id='' where class_id in($id)");
            DB::delete("delete from product_class where id in($id)");
            DB::commit();
            echo "ok";
        }catch (Exception $e){
            DB::rollback();
            echo "删除失败请重试";
        }
    }
    public function delone_class(){
       $id=$_POST["id"];
        $row=DB::table("product_class")->where("id",$id)->get();
        if (empty($row[0]->p_id)){
            $child=DB::table("product_class")->where("p_id",$row[0]->id)->get();
            if (count($child)>0){
                echo "请先删除子类";
                exit();
            }
        }
        DB::beginTransaction();
        try{
            DB::update("update product set class_id=? where class_id=?",["",$id]);
            DB::delete("delete from product_class where id=?",[$id]);
            DB::commit();
             echo "ok";
        }catch (Exception $e){
            DB::rollback();
            echo "删除失败请重试";
        }
    }
    public function modify_class(){
        $id=$_POST["id"];
        $name=$_POST["name"];
        $res=DB::table("product_class")->where("id","!=",$id)->where("name",$name)->get();
        if (count($res)>0){
            echo "分类名称已经存在不可用";
            exit();
        }
        $num=DB::table("product_class")->where("id",$id)->update(["name"=>$name]);
        if ($num>0){
            echo "ok";
        }else{
            echo "修改失败请重试";
        }
    }
    public function add_parent(){
        $name=$_POST["name"];
        $p_id="0";
        $namearr=explode(",",$name);
        $a=0;
        for ($i=0;$i<count($namearr);$i++){
            $num=DB::table("product_class")->where("name",$namearr[$i])->get();
            if (count($num)==0){
                $n=DB::table("product_class")->insert(["name"=>$namearr[$i],"p_id"=>$p_id]);
                $n>0?$a++:"";
            }
        }
        if ($a>0){
            echo "ok";
        }else{
            echo "添加失败请重试";
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
   return view("admin.product_class")->with("product_class",$arr);
    }
   public function add_child(){
     $name=$_POST["name"];
     $p_id=$_POST["p_id"];
     $namearr=explode(",",$name);
     $a=0;
      for ($i=0;$i<count($namearr);$i++){
          $num=DB::table("product_class")->where("p_id","!=","0")->where("name",$namearr[$i])->get();
          if (count($num)==0){
        $n=DB::table("product_class")->insert(["name"=>$namearr[$i],"p_id"=>$p_id]);
            $n>0?$a++:"";
          }
      }
      if ($a>0){
          echo "ok";
      }else{
          echo "添加失败或分类已存在请重试";
      }
   }
}
