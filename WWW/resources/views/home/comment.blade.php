<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("home.head")
     <title>在线留言</title>
    <script src="{{asset("/public/js/ajax.js")}}"></script>
    <script>
        function submit() {
          var full_name=document.getElementById("full_name");
            var email=document.getElementById("email");
            var qq=document.getElementById("qq");
            var telephone=document.getElementById("telephone");
            var title=document.getElementById("title");
            var content=document.getElementById("content");
            var captcha=document.getElementById("captcha");
            var string="_token={{csrf_token()}}&full_name="+full_name.value+"&email="+email.value+"&qq="+qq.value+"&telephone="+
                    telephone.value+"&title="+title.value+"&content="+content.value+"&captcha="+captcha.value;
          ajax("{{url('sub_msg')}}",string,function (str) {
                if (str==="ok"){
                    $("#modal-body").text("提交留言成功");
                    $("#myModal").modal();
                    $("#modal_ok").click(function () {
                        $("#myModal").modal("hide");
                        window.location=window.location.href;
                    });
                }else{
                    $("#modal-body").text(str);
                    $("#myModal").modal();
                  $("#modal_ok").click(function () {
                      $("#myModal").modal("hide");
                  });
                }
            })
        }
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
                        <a href="{{asset("")}}">首页</a> >
                        <a href="{{asset("/index.php/comment")}}">在线留言</a>
                    </div>
                </div>

                <div class="col-sm-12 col-md-12 pad">
                    <div id="ff">
                <center>
                    <table cellpadding="3" cellspacing="5" class="reg">
                        <tr>
                            <td align="center" colspan="2">
                                <br />
                                感谢您光临我公司网站，如您有任何疑问请与我们留言，我们会在第一时间联系您！<br />
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                姓名
                            </td>
                            <td align="left">
                                <input class="easyui-validatebox" type="text" id="full_name" data-options="required:true" style="width:90%;" />
                                <i style="color:red;">*</i>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                 电话
                            </td>
                            <td align="left">
                                <input class="easyui-validatebox" type="text" id="telephone" data-options="" style="width:90%;" />
                                <i style="color:red;">*</i>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                邮箱
                            </td>
                            <td align="left">
                                <input class="easyui-validatebox" type="text" id="email" data-options="validType:'email'" style="width:90%;" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                QQ
                            </td>
                            <td align="left">
                                <input class="easyui-validatebox" type="text" id="qq" data-options="" style="width:90%;" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                反馈标题
                            </td>
                            <td align="left">
                                <input class="easyui-validatebox" type="text" id="title" data-options="required:true" style="width:90%;" />
                                <i style="color:red;">*</i>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                反馈内容
                            </td>
                            <td align="left">
                                <textarea id="content" style="width:90%; height:70px"></textarea>
                                <i style="color:red;">*</i>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                验证码
                            </td>
                            <td align="left">
                                <input id="captcha" class="easyui-validatebox" type="text" data-options="" style="width:30%;" />
                                 <img style="cursor:pointer;height:35px;" src="{{asset("/index.php/captcha")}}" onclick="this.src='{{asset('/index.php/captcha?t=')}}'+Math.random()"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input onclick="submit()" class="btn" type="button" value="确定" />&nbsp;&nbsp;&nbsp;&nbsp;
                                <input class="btn" type="reset" value="重置" />
                            </td>
                        </tr>
                    </table>
                </center>
                </div>

                <div style="width:100%; height:30px;"></div>

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
<!--模态框-->
@include("common.modal1")
</body>
</html>
