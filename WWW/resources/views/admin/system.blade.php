
<!DOCTYPE html>
<html>
<head>
   @include("admin.head")
    <script>
        function submit() {
            var email=document.getElementById("email");
            var contacts=document.getElementById("contacts");
            var telephone=document.getElementById("telephone");
            var phone=document.getElementById("phone");
            var icp=document.getElementById("icp");
            var address=document.getElementById("address");
            var profile=document.getElementById("profile");
            var string="_token={{csrf_token()}}&email="+email.value+"&contacts="+contacts.value+"&telephone="+telephone.value+
                    "&icp="+icp.value+"&address="+address.value+"&profile="+profile.value+"&phone="+phone.value;
            ajax("{{url("admin/system_set")}}",string,function (str) {
                if (str==="ok"){
                    G.alert({content:"提交成功",ok:function () {
                            window.location="{{url("admin")}}";
                            return true;
                        }})
                }else{
                    G.alert({content:str,ok:function () {
                             return true;
                        }})
                }
            })
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
            <div class="crumb-list"><i class="icon-font"></i><a href="{{url("admin")}}">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">系统设置</span></div>
        </div>
        <div class="result-wrap">
            <div class="config-items">
                    <div class="config-title">
                        <h1><i class="icon-font">&#xe014;</i>站长信息设置</h1>
                    </div>
                    <div class="result-content">
                        <table width="100%" class="insert-tab">
                            <tr>
                                <th width="15%"><i class="require-red">*</i>网站联系邮箱：</th>
                                <td><input type="text" id="email" value="{{empty($data)?"":$data->email}}" size="85" class="common-text"></td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>联系人：</th>
                                <td><input type="text" id="contacts" value="{{empty($data)?"":$data->contacts}}" size="85" class="common-text"></td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>手机：</th>
                                <td><input type="text" id="phone" value="{{empty($data)?"":$data->phone}}" size="85" class="common-text"></td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>联系电话：</th>
                                <td><input type="text" id="telephone" value="{{empty($data)?"":$data->telephone}}" size="85" class="common-text"></td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>备案ICP：</th>
                                <td><input type="text" id="icp" value="{{empty($data)?"":$data->icp}}" size="85" class="common-text"></td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>地址：</th>
                                <td><input type="text" id="address" value="{{empty($data)?"":$data->address}}" size="85" class="common-text"></td>
                            </tr>
                            <tr>
                                <th valign="top" style="padding-top:15px;"><i class="require-red">*</i>公司简介：</th>
                                <td valign="top" style="padding-top:15px;">
                                    <textarea id="profile" style="padding:5px;" cols="50" rows="10">{{empty($data)?"":$data->profile}}</textarea></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <input onclick="submit()" type="button" value="提交" class="btn btn-primary btn6 mr10">
                                    <input type="button" value="返回" onClick="history.go(-1)" class="btn btn6">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
        </div>
    </div>
    <!--/main-->
 </div>
</body>
</html>