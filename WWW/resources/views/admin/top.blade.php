<script>
    function exit() {
        G.alert({content:"确定退出吗?",ok:function () {
                ajax("{{url("admin/logout")}}",data="_token={{csrf_token()}}",function (str) {
                    window.location="{{url("admin/login")}}";
                })
                return true;
            },cancel:function () {

            }
        });
    }
</script>
<script>
    function modify_password() {
        var content = "<table width='100%' cellspacing='0' cellpadding='0' border='0'>"
            + "<tbody>"
            + "<tr>"
            + "<td valign='top'>"
            + "<table id='changepwd' class='infoList'>"
            + "<tbody>"
            + "<tr>"
            + "<td height='30' width='100' align='right'>原始密码&nbsp;</td>"
            + "<td height='30'>&nbsp;<input name='voldpassword' class='input' style='width:130px;' autocomplete='off' type='password'></td>"
            + "</tr>"
            + "<tr>"
            + "<td height='30' align='right'>新设密码&nbsp;</td>"
            + "<td height='30' align='left'>&nbsp;<input name='vnewpassword' autocomplete='off' class='input' style='width:130px;' type='password'></td>"
            + "</tr>"
            + "<tr>"
            + "<td height='30' align='right'>确认密码&nbsp;</td>"
            + "<td height='30' align='left'>&nbsp;<input name='vrenewpassword' autocomplete='off' class='input' style='width:130px;' type='password'></td>"
            + "</tr>"
            + "</tbody>"
            + "</table>"
            + "</td>"
            + "</tr>"
            + "</tbody>"
            + "</table>";
        G.alert({ title: "修改密码", content: content,width:380,
            okVal: "确定修改",
            ok: function () {
                var voldpassword = $("input[name='voldpassword']");
                var vnewpassword = $("input[name='vnewpassword']");
                var vrenewpassword = $("input[name='vrenewpassword']");
                if (voldpassword.val() === "") {
                    G.myTips({ content: "请填写原始密码", obj: voldpassword, myclick: true });
                } else if (voldpassword.val().length < 6 || voldpassword.val().length > 20) {
                    G.myTips({ content: "请输入6-20位密码", obj: voldpassword, myclick: true });
                } else if (vnewpassword.val() === "") {
                    G.myTips({ content: "请填写新密码", obj: vnewpassword, myclick: true });
                } else if (vnewpassword.val().length < 6 || vnewpassword.val().length > 20) {
                    G.myTips({ content: "请输入6-20位密码", obj: vnewpassword, myclick: true });
                } else if (vnewpassword.val() !== vrenewpassword.val()) {
                    G.myTips({ content: "两次密码不一致，请重新輸入！", obj: vrenewpassword, myclick: true });
                } else if (vnewpassword.val() === voldpassword.val()) {
                    G.myTips({ content: "旧密码与新密码一致，请更换新密码。", obj: vnewpassword, myclick: true });
                } else{
                    ajax("{{url("admin/modify_password")}}","_token={{csrf_token()}}"+"&voldpassword=" +
                        voldpassword.val() + "&vnewpassword=" + vnewpassword.val(), function (str) {
                        if (str==="ok") {
                            G.alert({content: "密码更改成功,请重新登录", ok: function () {
                                    window.location="{{url("admin/login")}}";
                                    return true;
                                } });
                        } else{
                            G.myTips({ content:str, obj: voldpassword, myclick: true });
                        }
                    }, function () { G.maskClose(); });
                }
            },
            cancel: function () {

            }
        });
    }
</script>
<div class="topbar-wrap white">
    <div class="topbar-inner clearfix">
        <div class="topbar-logo-wrap clearfix">
            <ul class="navbar-list clearfix">
                <li><a class="on" href="{{url("admin")}}">首页</a></li>
                <li><a href="{{asset("")}}" target="_blank">网站首页</a></li>
            </ul>
        </div>
        <div class="top-info-wrap">
            <ul class="top-info-list clearfix">
                <li>欢迎您：{{session("user")->username}}</li>
                <li><a href="javascript:void(0)" onclick="modify_password()">修改密码</a></li>
                <li><a href="javascript:void(0)" onclick="exit()">退出</a></li>
            </ul>
        </div>
    </div>
</div>