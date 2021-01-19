<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function show(){
        $row=DB::table("site_info")->get();
        if (count($row)==0){
            $data="";
        }else{
            $data=$row[0];
        }
        $news=DB::table("news")->orderBy("id","desc")->paginate(10);
        return view("home.article",["data"=>$data,"news"=>$news]);
    }
    public function article_detail($id){
        $row=DB::table("site_info")->get();
        if (count($row)==0){
            $data="";
        }else{
            $data=$row[0];
        }
        $newsrow=DB::table("news")->where("id",$id)->get();
        $prev=DB::select("select * from news where id<? order by id desc limit ?,?",[$id,0,6]);
        $next=DB::select("select * from news where id>? limit ?,?",[$id,0,6]);
         return view("home.article_detail",[
             "data"=>$data,
             "newsrow"=>$newsrow,
             "prev"=>$prev,
             "next"=>$next
         ]);
    }
}
