<?php
class Curl{
    public function cPost($url,$field){
        //初始化curl
        $ch=curl_init();
        //设置请求地址
        curl_setopt($ch,CURLOPT_URL,$url);
        //设置返回的数据不直接展示在页面上
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //关闭头信息
        curl_setopt($ch, CURLOPT_HEADER, false);
        //设置禁止证书校验
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        //设置请求超时的时间
        curl_setopt($ch,CURLOPT_TIMEOUT,30);
        //设置开启POST
        curl_setopt($ch,CURLOPT_POST,1);
        //传递POST数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$field);
        //定义一个空字符串.接收返回结果
        $data="";
        if (curl_exec($ch)){
            $data=curl_multi_getcontent($ch);
        }
        //关闭curl
        curl_close($ch);
        //返回得到的结果
        return $data;
    }
    public function cGet($url){
        //初始化curl
        $ch=curl_init();
        //设置请求地址
        curl_setopt($ch,CURLOPT_URL,$url);
        //设置返回的数据不直接展示在页面上
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //关闭头信息
        curl_setopt($ch, CURLOPT_HEADER, false);
        //设置禁止证书校验
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        //设置请求超时的时间
        curl_setopt($ch,CURLOPT_TIMEOUT,30);
        //定义一个空字符串.接收返回结果
        $data="";
        if (curl_exec($ch)){
            $data=curl_multi_getcontent($ch);
        }
        //关闭curl
        curl_close($ch);
        //返回得到的结果
        return $data;
    }
}
?>