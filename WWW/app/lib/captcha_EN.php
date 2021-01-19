<?php
//session_start();
header("Content-type:text/html;charset=utf-8");
$image=imagecreatetruecolor(100, 40);//2创建画布;
$bgImage=imagecolorallocate($image,255,255,255);//3设置图片背景颜色
imagefill($image,1,1,$bgImage);//填充颜色
$str="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
$shu=str_shuffle($str);//打乱字符串
$captchaCode=substr($shu,10,4);//截取字符串
$fontfile=$_SERVER["DOCUMENT_ROOT"]."/app/lib/MICROSS.TTF";//设置ttf文件路径
$fontColor=imagecolorallocate($image,mt_rand(0,0),mt_rand(0,0),mt_rand(0,0));
imagettftext($image,mt_rand(18,21), mt_rand(1,10),20, 30, $fontColor, $fontfile,$captchaCode);
for ($i=1;$i<10;$i++){
    imageline($image,rand(0,5),rand(1,38),rand(200,310),0,imagecolorallocate($image,rand(80,220),rand(80,220),rand(80,220)));
}
for ($i=1;$i<1000;$i++){
    imagesetpixel($image, rand(1,49), rand(1,49),imagecolorallocate($image,rand(50,200),rand(50,200),rand(50,200)));
}
$_SESSION['captcha']=$captchaCode;
header("Content-type:image/png");
imagepng($image);
imagedestroy($image);
?>
