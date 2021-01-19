<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("home.head")
     <title>产品详细</title>
    <script>
        function img(obj,img) {
            var w = obj.width();//容器宽度
            img.each(function(){//如果有很多图片，我们可以使用each()遍历
                var img_w = $(this).width();//图片宽度
                var img_h = $(this).height();//图片高度
                if(img_w>w){//如果图片宽度超出容器宽度--要撑破了
                    var height = (w*img_h)/img_w; //高度等比缩放
                    $(this).css({"width":w,"height":height});//设置缩放后的宽度和高度
                }
            });
        }
    </script>
    <script>
        $(function () {
            img($("#detailContent"),$("#detailContent img"));
            /* if (/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
                img($("#detailContent"),$("#detailContent img"));
             }*/
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

             <div class="col-xs-12 col-sm-8 col-md-9" id="rightBox">

                 <div class="positionBox">
                     <div class="titleBar">
                         <h1>当前位置</h1>
                         <span></span>
                         <a href="{{asset("")}}">首页</a> > <a href="{{asset("/index.php/product")}}">产品中心</a>
                     </div>
                 </div>

                 <div class="col-sm-12 col-md-12 pad">

                     <div class="detailTitle" style="border:0px; background:none; font-size:20px; color:#000;">
                         {{$product_detail[0]->title}}
                     </div>
                     <div class="detailTime">
                         {{$product_detail[0]->time}}
                     </div>

                     <div id="detailContent">

                        <span style="color:#505050;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;">
                             {!! $product_detail[0]->content !!}
                        </span>

                     </div>

                     <div class="otherPageBox">

                         <div class="col-xs-9 col-sm-9 col-md-9 pad">
                             <div class='otherPage'>
                                 @if(count($prev)>0)
                                     <div class='prevBox'>上一个：<a href='{{asset("/index.php/product_detail")}}/{{$prev[0]->id}}'>{{$prev[0]->title}}</a></div>
                                 @endif
                                 @if(count($next)>0)
                                     <div class='nextBox'>下一个：<a href='{{asset("/index.php/product_detail")}}/{{$next[0]->id}}'>{{$next[0]->title}}</a></div>
                                 @endif
                             </div>
                         </div>

                         <div class="col-xs-3 col-sm-3 col-md-3 pad">
                             <a class="back" href="{{asset("/index.php/product")}}">返回</a>
                         </div>

                     </div>
                    @if(count($prev)>1)
                    <div class="aboutProduct">
                        <div class="titleBar">
                            <h1>相关产品</h1>
                            <span>&nbsp</span>
                        </div>
                        <div class="productList">
                            @for($i=1;$i<count($prev);$i++)
                             <div class="col-xs-6 col-sm-4 col-md-3 col-mm-6 productImg">
                                <div style="width:100%;height:250px;">
                                <a title="{{$prev[$i]->title}}" href='{{asset("/index.php/product_detail")}}/{{$prev[$i]->id}}' style="max-height:200px;">
                                    <span class="imgLink-hover"><span class="hover-link"></span></span>
                                    <img class="img-responsive" src="{{asset("/public/upload/product")}}/{{$prev[$i]->img}}" alt="{{$prev[$i]->title}}" />
                                </a>
                                <a class="productTitle" href="{{asset("/index.php/product_detail")}}/{{$prev[$i]->id}}"
                                   title="{{$prev[$i]->title}}">{{$prev[$i]->title}}</a>
                            </div>
                             </div>
                            @endfor
                        </div>
                    </div>
                        @elseif(count($next)>1)
                         <div class="aboutProduct">
                             <div class="titleBar">
                                 <h1>相关产品</h1>
                                 <span>&nbsp</span>
                             </div>
                             <div class="productList">
                                 @for($i=1;$i<count($prev);$i++)
                                     <div class="col-xs-6 col-sm-4 col-md-3 col-mm-6 productImg">
                                         <div style="width:100%;height:250px;">
                                         <a title="{{$prev[$i]->title}}" href='{{asset("/index.php/product_detail")}}/{{$prev[$i]->id}}' style="max-height:200px;">
                                             <span class="imgLink-hover"><span class="hover-link"></span></span>
                                             <img class="img-responsive" src="{{asset("/public/upload/product")}}/{{$prev[$i]->img}}" alt="{{$prev[$i]->title}}" />
                                         </a>
                                         <a class="productTitle" href="{{asset("/index.php/product_detail")}}/{{$prev[$i]->id}}"
                                            title="{{$prev[$i]->title}}">{{$prev[$i]->title}}</a>
                                     </div>
                                     </div>
                                 @endfor
                             </div>
                         </div>
                    @endif
                </div>

            </div>

            <div class="col-xs-12 col-sm-4 col-md-3">

                <div class="navigationBox" id="classification">
                    <div class="titleBar">
                        <h1>产品分类</h1>
                        <span></span>
                    </div>
                    <div class="list">
                        <ul id="firstpane">
                            @for($i=0;$i<count($product_class);$i++)
                                <li><a class='' href='{{asset("/index.php/product")}}/{{$product_class[$i]["p_class"]->id}}/p_id'>{{$product_class[$i]["p_class"]->name}}</a><span>+</span>

                                    <ul>
                                        @for($j=0;$j<count($product_class[$i]["c_class"]);$j++)
                                            <li><a class='' href='{{asset("/index.php/product")}}/{{$product_class[$i]["c_class"][$j]->id}}/c_id'>{{$product_class[$i]["c_class"][$j]->name}}</a></li>
                                        @endfor
                                    </ul>

                                </li>
                            @endfor
                        </ul>
                    </div>
                </div>
                
                <div class="leftContactBox">     
                    @include("home.leftcontact")
                </div>

            </div>

        </div>
    </div>
    
    @include("home.footer")
    
    <!--客服面板-->
    @include("home.service")
</body>
</html>
