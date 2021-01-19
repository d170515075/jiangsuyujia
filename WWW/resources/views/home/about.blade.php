<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
     @include("home.head")
    <title>关于我们</title>
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
                        <a href="{{asset("")}}">首页</a> > <a href="{{asset("index.php/about")}}">关于我们</a>
                    </div>
                </div>

                <div class="col-sm-12 col-md-12 pad">
                    
                    <div class="detailContent" style="line-height:1.8em">
                        {{empty($data)?"":$data->profile}}
                        <div><img style="width:100%;max-height:500px;" src="{{asset("/public/home/images/about.jpg")}}"/></div>
                    </div>
                
                    <div style="height:15px"></div>
                    
                </div>

            </div>

            <div class="col-xs-12 col-sm-4 col-md-3">

                <div class="navigationBox" id="classification">
                    <div class="titleBar">
                        <h1>导航栏目</h1>
                        <span></span>
                    </div>
                    <div class="list">
                         @include("home.leftnav")
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
