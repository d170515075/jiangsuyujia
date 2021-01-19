<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get("product_detail/{id}","home\ProductController@product_detail");
Route::get("product/{id?}/{type?}","home\ProductController@show");
Route::post("sub_msg","home\CommentController@sub_msg");
Route::get("comment","home\CommentController@show");
Route::get("article_detail/{id}","home\ArticleController@article_detail");
Route::get("contact","home\ContactController@show");
Route::get('/',"home\IndexController@show");
Route::get("index","home\IndexController@show");
Route::get("about","home\AboutController@show");
Route::get("article","home\ArticleController@show");
Route::get("captcha","admin\AdminLoginController@captcha");
Route::post("admin_login","admin\AdminLoginController@login");
Route::get('admin/login',function (){return view("admin.login.login");});
Route::post("admin/logout","admin\AdminLoginController@logout");
Route::group(["middleware"=>"adminlogin"],function (){
     Route::post("admin/delete_msg","admin\MessageController@delete");
    Route::post("admin/browse_msg","admin\MessageController@get");
    Route::get("admin/message","admin\MessageController@show");
   Route::post("admin/add_user","admin\UserController@add");
    Route::post("admin/delete_user","admin\UserController@delete_user");
    Route::get("admin/user","admin\UserController@show");
    Route::post("admin/upload_product_img","admin\ProductController@upload");
    Route::post("admin/upload_img","admin\ProductController@upload_img");
    Route::post("admin/system_set","admin\SystemController@set");
    Route::post("admin/update_product","admin\ProductController@update_product");
    Route::get("admin/modify_product/{id}","admin\ProductController@modify_product");
    Route::post("admin/browse_product","admin\ProductController@browse_product");
    Route::post("admin/del_product","admin\ProductController@del");
    Route::post("admin/batch_del_class","admin\ProductClassController@batch_del_class");
    Route::post("admin/delone_class","admin\ProductClassController@delone_class");
    Route::post("admin/modify_class","admin\ProductClassController@modify_class");
    Route::post("admin/add_product_parent_class","admin\ProductClassController@add_parent");
    Route::get("admin/product_class","admin\ProductClassController@show");
    Route::post("admin/add_product_class","admin\ProductClassController@add_child");
    Route::post("admin/add_product","admin\ProductController@add");
    Route::get("admin/insert_product","admin\ProductController@show");
    Route::get("admin/product","admin\ProductController@index");
    Route::post("admin/upload_news_img","admin\NewsController@upload");
    Route::post("admin/delete_news","admin\NewsController@delete");
    Route::post("admin/update_news","admin\NewsController@update");
    Route::get("admin/modify_news/{id}","admin\NewsController@modify");
    Route::post("admin/browse_news","admin\NewsController@browse");
    Route::post("admin/add_news","admin\NewsController@add");
    Route::get("admin/insert_news",function (){return view("admin.insert_news");});
    Route::get('admin',"admin\NewsController@index");
     Route::get('admin/system',"admin\SystemController@show");
    Route::post("admin/modify_password","admin\AdminController@modify_password");
});