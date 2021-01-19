<!DOCTYPE html>
<html>
<head>
    @include("admin.head")
    <style>
   input[type=checkbox]{
       margin-bottom:5px;
        }
    </style>
    <script>
        function add() {
            var str="<div style='padding:20px;'>" +
                    "<table>" +
                    "<tr>" +
                    "<td style='text-align:right;'>用户名：</td>"+
                "<td><input type='text' id='username'></td>"+
                "</tr>"+
                "<tr>" +
                "<td style='text-align:right;padding-top:15px;'>密码：</td>"+
                "<td style='padding-top:15px;'><input type='password' id='password'></td>"+
                "</tr>"+
                "<tr>" +
                "<td style='text-align:right;padding-top:15px;'>确认密码：</td>"+
                "<td style='padding-top:15px;'><input type='password' id='confirmpassword'></td>"+
                "</tr>"+
                "</table>"+
                    "<div id='info' style='color:red;padding-top:15px;'></div>"+
                "<div>";
            G.alert({title:"添加用户",content:str,ok:function () {
                var username=document.getElementById("username");
               var password=document.getElementById("password");
            var confirmpassword=document.getElementById("confirmpassword");
            var info=document.getElementById("info");
                    if (username.value == "" || /^\s+$/.test(username.value)) {
                        info.innerHTML = "请输入用户名";
                        return false;
                    } else if (password.value == "" || /^\s+$/.test(password.value)) {
                        info.innerHTML = "请输入密码";
                        return false;
                    }else if (confirmpassword.value == "" || /^\s+$/.test(confirmpassword.value)) {
                        info.innerHTML = "请输入确认密码";
                        return false;
                    }else if (username.value.length<4 || username.value.length>20) {
                        info.innerHTML = "请输入4-20位用户名";
                        return false;
                    }else if (password.value.length<6 || password.value.length>30) {
                        info.innerHTML = "请输入6-30位密码";
                        return false;
                    }else if (password.value !== confirmpassword.value) {
                        info.innerHTML = "两次密码输入不一致";
                        return false;
                    }else{
                        var string="_token={{csrf_token()}}&username="+username.value+"&password="+password.value;
                        ajax("{{url("admin/add_user")}}",string,function (str) {
                            if (str==="ok"){
                                G.alert({content:"添加成功",ok:function(){window.location=window.location.href;return true;}})
                                return true;
                            }else{
                                info.innerHTML=str;
                                return false;
                            }
                        })
                    }
                },cancel:function () {

                }})
        }
    </script>
    <script>
        function delone(id) {
            G.alert({content:"确定删除吗？",ok:function () {
                    ajax("{{url("admin/delete_user")}}","_token={{csrf_token()}}&id="+id,function (str) {
                        if (str==="ok"){
                            G.alert({content:"删除成功",ok:function(){window.location=window.location.href;return true;}});
                        }else{
                            G.alert({content:str,ok:function(){return true;}});
                        }
                    })
                },cancel:function () {

                }});
        }
    </script>
    <script>
        function batch_del() {
            var checkbox=$(".checkbox");
            var id=[];
            for (var i=0;i<checkbox.length;i++){
                if (checkbox[i].checked){
                   id.push(checkbox[i].value);
                }
            }
            if (id.length===0){
                return G.alert({content:"请选择删除项",ok:function(){return true;}});
            }
          G.alert({content:"确认删除吗?",ok:function () {
                  var string="id="+id+"&_token={{csrf_token()}}";
                  ajax("{{url("admin/delete_user")}}",string,function (str) {
                      if (str==="ok"){
                          G.alert({content:"删除成功",ok:function(){window.location=window.location.href;return true;}})
                      }else{
                          G.alert({content:str,ok:function(){return true;}});
                      }
                  });
                  return true;
              },cancel:function () {

              }})
        }
    </script>
    <script>
        function select_all(obj) {
         var checkbox=$(".checkbox");
        if (obj.checked){
          for (var i=0;i<checkbox.length;i++){
              checkbox[i].checked=true;
          }
        }else{
            for (var i=0;i<checkbox.length;i++){
                checkbox[i].checked=false;
            }
        }
        }
    </script>
</head>
<body>
@include("admin.top")
<div class="container clearfix">
@include("admin.left")
<!--/sidebar-->
<div class="main-wrap">
    <div class="crumb-wrap">
        <div class="crumb-list">
            <i class="icon-font"></i>
            <a href="{{url("admin")}}">首页</a>
            <span class="crumb-step">&gt;</span><span class="crumb-name">用户管理</span>
        </div>
    </div>
    <div class="result-wrap">
         <div class="result-title">
                <div class="result-list">
                    <a href="javascript:void(0)" onclick="add()"><i class="icon-font"></i>新增</a>
                    <a id="batchDel" href="javascript:void(0)" onclick="batch_del()"><i class="icon-font"></i>批量删除</a>
                </div>
            </div>
            <div class="result-content">
                <table class="result-tab" width="100%">
                    <tr>
                        <th class="tc">
                            <input type="checkbox" onclick="select_all(this)">全选</th>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>操作</th>
                    </tr>
                    @for($i=0;$i<count($user);$i++)
                        <tr>
                            <td class="tc">
                                @if($user[$i]->username!="admin")
                                <input type="checkbox" class="checkbox" value="{{$user[$i]->id}}">
                                    @endif
                            </td>
                            <td>{{$user[$i]->id}}</td>
                            <td>{{$user[$i]->username}}</td>
                            <td>
                                @if($user[$i]->username!="admin")
                                <a class="link-update" href="javascript:void(0)" onclick="delone('{{$user[$i]->id}}')">
                                    <i style="margin-right:2px;" class="icon-font">&#xe019;</i>删除</a>
                                    @endif
                            </td>
                        </tr>
                        @endfor
                </table>
                <div class="list-page">{!! $user->links() !!}</div>
            </div>
    </div>
</div>
<!--/main-->
</div>
</body>
</html>