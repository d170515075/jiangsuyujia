<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("home.head")
    <title>联系我们</title>
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
                        <a href="{{asset("")}}">首页</a> >
                        <a href="{{asset("/index.php/contact")}}">联系我们</a>
                    </div>
                </div>

                <div class="col-sm-12 col-md-12 pad">
                    
                    <div class="detailContent">
                    
                        <p style="text-align:left;">
                            <span style="line-height:1.5;">
                                <span style="line-height:2;font-size:14px;">
                                    <p style="white-space:normal;">
                                        <span style="line-height:1.5;">电话：{{empty($data)?"":$data->telephone}}</span>
                                    </p>
                                    <p style="white-space:normal;">
                                        邮箱：{{empty($data)?"":$data->email}}
                                    </p>
                                    <p style="white-space:normal;">
                                        网址：{{$_SERVER["HTTP_HOST"]}}
                                    </p>
                                    <p style="white-space:normal;">
                                        地址：{{empty($data)?"":$data->address}}
                                    </p>
                                      <iframe src="{{asset("/map.html")}}" style="width:100%;height:550px;"></iframe>
                                </span><br>
                            </span>
                        </p>
                        <p style="text-align:left;">
                            <span style="line-height:1.5;"></span>
                        </p>

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
