<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("home.head")
    <title>产品中心</title>
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
                    
                    <div class="productList">
                        @for($i=0;$i<count($product);$i++)
                       <div id="productImg" class="col-xs-6 col-sm-4 col-md-3 col-mm-6 productImg">
                           <div style="width:100%;height:250px;">
                            <a title="{{$product[$i]->title}}" href='{{asset("/index.php/product_detail")}}/{{$product[$i]->id}}' style="max-height:200px;">
                                <span class="imgLink-hover"><span class="hover-link"></span></span>
                                <img class="img-responsive" src="/public/upload/product/{{$product[$i]->img}}" alt="{{$product[$i]->title}}" />
                            </a>
                            <a class="productTitle" href="{{asset("/index.php/product_detail")}}/{{$product[$i]->id}}" title="{{$product[$i]->title}}">
                                {{$product[$i]->title}}
                            </a>
                        </div>
                       </div>
                        @endfor
                    </div>

                    <div class='pageBar'>{!!$product->links()!!}</div>

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
