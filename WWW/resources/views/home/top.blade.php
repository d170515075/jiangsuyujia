<header>
    <div class="topBox">
        <div class="borderBottom">
            <div class="container">
                <div class="welcomeBox">欢迎光临官方企业网站</div>
                <div class="languageBox">
                    <!--<a href="#" class="en">English</a><a href="#" class="zh">中文版</a>-->
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-8 logo">
                    <a href="{{asset("")}}"><img src="{{asset("public/home/images/logo.png")}}"/></a>
                </div>

                <div class="col-xs-6 col-sm-3 col-md-2">
                    <div class="address"></div>
                </div>

                <div class="col-xs-6 col-sm-3 col-md-2">
                    <div class="tel">
                        <img src="{{asset("public/home/images/tel.gif")}}" alt="" /><br />{{empty($data)?"":$data->telephone}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-static-top navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{asset("")}}"></a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="{{asset("")}}">网站首页</a></li>
                    <li class="dropdown">
                        <a href="{{asset("index.php/about")}}" class="dropdown-toggle" data-toggle="dropdown">关于我们</a><a href="#" id="app_menudown" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-menu-down btn-xs"></span></a>
                        <!--  <ul class="dropdown-menu" role="menu">
                              <li><a class='' href='about.html'>公司简介</a></li>
                              <li><a class='' href='contact.html'>联系我们</a></li>
                          </ul>-->
                    </li>
                    <li class="dropdown">
                        <a href="{{asset("/index.php/article")}}" class="dropdown-toggle" data-toggle="dropdown">公司动态</a>
                        <a href="#" id="app_menudown" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-menu-down btn-xs"></span></a>
                        <!--  <ul class="dropdown-menu" role="menu">
                              <li><a class='' href='article.html'>公司新闻</a></li>
                              <li><a class='' href='article.html'>行业新闻</a></li>
                          </ul>-->
                    </li>
                    <li class="dropdown">
                        <a href="{{asset("/index.php/product")}}" class="dropdown-toggle" data-toggle="dropdown">产品中心</a><a href="#" id="app_menudown" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-menu-down btn-xs"></span></a>
                        <!-- <ul class="dropdown-menu" role="menu">
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
                         </ul>-->
                    </li>
                    <li><a href="{{asset("/index.php/comment")}}">在线留言</a></li>
                    <li><a href="{{asset("/index.php/contact")}}">联系我们</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>