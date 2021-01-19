<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>登录</title>
	<link rel="stylesheet" href="/resources/views/admin/login/css/reset.css" />
	<link href="{{asset("/public/home/images/yjicon.ico")}}" rel="SHORTCUT ICON">
	<link rel="stylesheet" href="/resources/views/admin/login/css/login.css" />
    <script type="text/javascript" src="/public/js/ajax.js"></script>
    <script type="text/javascript" src="/public/js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript">
        function login() {
            var username=document.getElementById("username");
            var password=document.getElementById("password");
            var captcha=document.getElementById("captcha");
            var info=document.getElementById("info");
            if ((username.value == "" && password.value == "") || (/^\s+$/.test(username.value) && /^\s+$/.test(password.value))) {
                info.innerHTML = "请输入用户名和密码";
                info.style.display = "block";
            } else if (username.value == "" || /^\s+$/.test(username.value)) {
                info.innerHTML = "请输入用户名";
                info.style.display = "block";
            } else if (password.value == "" || /^\s+$/.test(password.value)) {
                info.innerHTML = "请输入密码";
                info.style.display = "block";
            } else if (captcha.value == "" || /^\s+$/.test(captcha.value)) {
                info.innerHTML = "请输入验证码";
                info.style.display = "block";
            }else{
                var string="username="+username.value+"&password="+password.value+"&captcha="+captcha.value+
                    "&_token={{csrf_token()}}";
                ajax("{{asset("index.php/admin_login")}}",data=string,function (str) {
                    if (str==="login_ok"){
                        window.location="http://{{$_SERVER["HTTP_HOST"]}}/index.php/admin";
                    }else{
                        info.innerHTML=str;
                        info.style.display="block";
                    }
                })
            }
        }
    </script>
    <script>
        $(function () {
            onkeydown=function (e) {
                if (e.keyCode==13){
                    login();
                }
            }
        })
    </script>
</head>
<body style="background-image: url('/resources/views/admin/login/images/bg-01.jpg');">
<div class="page">
	<div class="loginwarrp">
		<div class="logo">
            管理员登陆
        </div>
        <div class="login_form">
            <p id="info" style="color:red;"></p>
			<form id="Login" name="Login" method="post" onsubmit="" action="">
				<li class="login-item">
					<span>用户名：</span>
					<input type="text" id="username" class="login_input" placeholder="请输入用户名">
				</li>
				<li class="login-item">
					<span>密　码：</span>
					<input type="password" id="password" class="login_input" placeholder="请输入密码">
				</li>
				<li class="login-item verify">
					<span>验证码：</span>
					<input type="text" id="captcha" class="login_input verify_input" placeholder="请输入验证码">
				</li>
				<img style="cursor: pointer;" src="{{asset("/index.php/captcha")}}" onclick="this.src='{{asset('/index.php/captcha?t=')}}'+Math.random()" border="0" class="verifyimg" />
				<div class="clearfix"></div>
				<li class="login-sub">
					<input style="cursor: pointer;" type="button" value="登录" onclick="login()" />
				</li>                      
           </form>
		</div>
	</div>
</div>
</body>
</html>