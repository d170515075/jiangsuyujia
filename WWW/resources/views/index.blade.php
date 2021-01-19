<!DOCTYPE html>
<html>
<head>
    @include("home.head")
    <title>江苏羽佳塑业有限公司官方网站</title>
    <script>
        function query() {
            var queryTxt=document.getElementById("queryTxt");
            window.location="{{asset("/index.php/product")}}/?search="+queryTxt.value;
        }
    </script>
    <script>
        $(function () {
            if (/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
                $("#pc_profile").css("display","none");
                $("#profile").css("display","block");
            }else{
                $("#pc_profile").css("display","block");
                $("#profile").css("display","none");
            }
        })
    </script>
</head>
<body>
@include("home.top")
<!-- Banner -->
@include("home.banner")
<!-- 内容 -->
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-9 col-md-9">
            <!--手机显示－－-->
            <div id="profile" style="display:none;">
                <h3>公司简介</h3>
                <p>江苏羽佳塑业有限公司是一家从事塑料制品生产,销售一条龙服务的企业.主营产品：塑料托盘、塑料周转箱、塑料水桶、塑料水箱、静音车、告示牌、榨水车、超市用品及禽用设备等几大系列的300余个品种。</p>
            </div>
            <!--电脑-->
            <div id="pc_profile" style="display:none;">
                    <h5>公司简介</h5>
        {{empty($data)?"":$data->profile}}
            </div></div>
        <!--///////-->

        <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="searchGroup" >
                <div class="searchBox">
                    <div class="title">产品查询</div>
                    <input type="text" id="queryTxt" placeholder="请输入关键字"/>
                    <a href="javascript:void(0)" onclick="query()">搜 索</a>
                </div>
                <div class="serviceBtn">
                    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=236729243&site=qq&menu=yes">
                        <img src="{{asset("public/home/images/qq.jpg")}}" /><br />客服QQ</a>
                    <a target="_blank" href="http://weibo.com/">
                    <!--   <img src="{{asset("public/home/images/wb.jpg")}}" /><br />关注微博</a>-->
                        <a href="javascript:showWechatQR();">
                            <img src="{{asset("public/home/images/wx.jpg")}}" /><br />关注微信</a>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 关注微信模态框（Modal）start -->
<div class="modal fade" id="wechatModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 0;">
            <div class="modal-header">请扫描二维码关注我们</div>
            <div class="modal-body" style="text-align: center">
                <img src="{{asset("public/home/images/qrcode.jpg")}}" alt="" />
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function showWechatQR() {
        $("#wechatModal").modal("show")
    }
</script>
<!-- 关注微信模态框（Modal）end -->

<div style="background:#f9f9f9; padding-top:30px; margin-top:30px; padding-bottom:10px">
    <div class="container">
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="productBox">
                    <div class="titleBar">
                        <h1>最新产品</h1>
                        <span></span>
                        @if(count($product)>0)
                            @for($i=0;$i<count($product);$i++)
                                <a href="{{asset("/index.php/product")}}/{{$product[$i]->id}}/p_id">{{$product[$i]->name}}</a>
                            @endfor
                        @endif
                    </div>
                    <div class="list">
                        @for($i=0;$i<count($product_data);$i++)
                            <div class="col-xs-6 col-sm-3 col-md-2 col-mm-6 productImg">
                                <a title="{{$product_data[$i]->title}}" href='{{asset("/index.php/product_detail")}}/{{$product_data[$i]->id}}'>
                                    <span class="imgLink-hover"><span class="hover-link"></span></span>
                                    <img src="{{asset("")}}/public/upload/product/{{$product_data[$i]->img}}" alt="{{$product_data[$i]->title}}" />
                                </a>
                                <a class="productTitle" href="{{asset("/index.php/product_detail")}}/{{$product_data[$i]->id}}" title="{{$product_data[$i]->title}}">
                                    {{$product_data[$i]->title}}
                                </a>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!--<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="indexNavigationGroup" id="classification">
                <div class="navigationBox">
               <div class="titleBar">
                       <h1>导航栏目</h1>
                        <span></span>
                    </div>
                    <div class="list">
                        <ul id="firstpane">
                            <li><a class='' href='product.html'>产品分类1</a><span>+</span>
                                <ul>
                                    <li><a class='' href='product.html'>产品子分类1</a><ul></ul></li>
                                    <li><a class='' href='product.html'>产品子分类2</a><ul></ul></li>
                                </ul>
                            </li>
                            <li><a class='' href='product.html'>产品分类2</a></li>
                            <li><a class='' href='product.html'>产品分类3</a></li>
                            <li><a class='' href='product.html'>产品分类4</a></li>
                            <li><a class='' href='product.html'>产品分类5</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->

<div class="container">
    <div class="row">

        <div class="col-xs-12 col-sm-9 col-md-9">
            <div class="newsBox">
                <div class="titleBar">
                    <h1>公司动态</h1>
                    <span></span> <a class="rightMore" href="article.html">>></a>
                </div>
                <ul class="indexNewsList">
                    @for($i=0;$i<count($news);$i++)
                        <li class="col-xs-12 col-sm-6 col-md-6">
                            <a href="{{asset("/index.php/article_detail")}}/{{$news[$i]->id}}">
                                @if(preg_match("/\d+[.jpg|.png]{4}/",$news[$i]->content,$arr))
                                    @if(is_file($_SERVER["DOCUMENT_ROOT"]."/public/upload/news/".$arr[0]))
                                        <div class="img" style="background-image: url({{asset("public/upload/news")."/".$arr[0]}})"></div>
                                    @else
                                        <div class="img" style="background-image: url({{asset("public/home/images/news")."/1.jpg"}})"></div>
                                    @endif
                                @else
                                    <div class="img" style="background-image: url({{asset("public/home/images/news")."/1.jpg"}})"></div>
                                @endif
                                <div class="txt">
                                    <span class="title">
                                       {{$news[$i]->title}}
                                    </span>
                                    <span class="time">[{{$news[$i]->time}}]</span>
                                    <p>{{$news[$i]->content}}</p>
                                </div>
                            </a>
                        </li>
                    @endfor
                </ul>
            </div>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="contactBox" style="padding:10px;">
                <p>联系人：{{empty($data)?"":$data->contacts}}</p>
                <p>手机：{{empty($data)?"":$data->phone}}</p>
                <p>电话：{{empty($data)?"":$data->telephone}}</p>
                <p>邮箱：{{empty($data)?"":$data->email}}</p>
                <p>地址： {{empty($data)?"":$data->address}}</p>
            </div>
        </div>
    </div>
</div>

<div style="background:#f9f9f9; padding-top:20px; margin-top:20px; padding-bottom:20px;">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="linkBox">
                    <div class="titleBar">
                        <h1>友情链接</h1>
                        <span></span>
                        <ul class="linkList">
                            <li><a target="_blank" href="{{asset("")}}">官方官网</a></li>
                            <li><a target="_blank" href="http://www.baidu.com">百度</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@include("home.footer")

<!--客服面板-->
@include("home.service")
</body>
</html>
