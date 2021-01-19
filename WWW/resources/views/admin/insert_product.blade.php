<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>系统后台</title>
    <link rel="stylesheet" type="text/css" href="{{asset("public/admin/css/common.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("public/admin/css/main.css")}}"/>
    <link rel="stylesheet" href="{{asset("public/galert/css/globals.css")}}">
    <link rel="stylesheet" href="{{asset("public/galert/css/memberGreen.css")}}">
    <link rel="stylesheet" href="{{asset("public/css/page.css")}}">
    <link href="{{asset("/public/home/images/yjicon.ico")}}" rel="SHORTCUT ICON">
    <script src="{{asset("public/galert/js/globals.js")}}"></script>
    <script src="{{asset("public/js/ajax.js")}}"></script>
    <!--//////////////-->
    <script src="{{asset("/public/uploadify/jquery.min.js")}}"></script>
    <script src="{{asset("/public/uploadify/jquery.uploadifive.min.js")}}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{asset("/public/uploadify/uploadifive.css")}}">
    <script type="text/javascript">
        $(function() {
            $('#file_upload').uploadifive({
                "buttonText":"选择图片",
                'auto'             : true,
                //'checkScript'      : 'check-exists.php',
                'formData'         : {
                      '_token'     : '{{csrf_token()}}'
                },
                'multi': false,
               // 'queueID'          : 'p_img',
                'uploadScript'     : '{{url("/admin/upload_img")}}',
                'onSelect': function(e, queueId, fileObj){
                    $(".filename").parent().css("display","none");
                    $(".uploadifive-queue-item").css("display","none");
                },
                'onUploadComplete' : function(file, data) {
                  //  $(".filename").parent().css("display","none");
                    if (!/\d+[.jpg|.png]{4}/.test(data)){
                       G.alert({content:data,ok:function(){return true;}})
                    }else{
                    var str="<img id='img' style='max-width:200px;max-height:200px;' src='"+data+"'/>";
                    $("#p_img").html(str);
                        $("#p_img").css("margin-top","10px");
                    }
                }
            });
        });
    </script>
    <style>
        input[type=checkbox]{
            margin-bottom:5px;
            margin-right:5px;
        }
        #sel_div{
            padding:0 50px 0 10px !important;
            height:40px;
            overflow-y: auto;
        }
        #sel_div p{
            margin-bottom:-15px;
        }
        #sel_div div{
            display:none;
            margin-top:-15px;
        }
    </style>
    <script type="text/javascript" src="{{asset("/public/ckeditor/ckeditor.js")}}"></script>
    <script>
        function add() {
            var stemTxt = CKEDITOR.instances.editor.document.getBody().getText();//获取CK纯文本
            var info = document.getElementById("info");
            var title = document.getElementById("title");
            var html = encodeURIComponent(CKEDITOR.instances.editor.getData());
            if (title.value === "" || /^\s+$/.test(title.value)) {
                info.innerHTML = "请输入标题";
            }else if (stemTxt === "" || /^\s+$/.test(stemTxt)) {
                info.innerHTML = "内容不能为空";
            }else {
                if (document.getElementById("img")){
                    var obj_img=document.getElementById("img");
                    var arr=obj_img.src.split("/");
                    var img=arr[arr.length-1];
                }else{
                    return G.alert({content:"请上传主图",ok:function(){
                            return true;
                        }});
                }
                var class_id="";
                if (document.getElementById("in_class_id")){
                    var in_class_id=document.getElementById("in_class_id");
                    class_id=in_class_id.value;
                    if (class_id===""){
                        info.innerHTML="请选择分类";
                        return false;
                    }
                }
                var string="img="+img+"&class_id="+class_id+"&title="+encodeURIComponent(title.value)+"&content=" + html+"&_token={{csrf_token()}}";
                ajax("{{url("/admin/add_product")}}",data=string,function (str) {
                    switch (str) {
                        case "ok":
                            G.alert({content:"提交成功",ok:function(){
                                    window.location ="{{url("admin/product")}}";
                                    return true;
                                }});
                            break;
                        default:
                            info.innerHTML = str;
                            break;
                    }
                })
            }
        }
    </script>
    <script>
        function sel(obj) {
            if($("#sel_div div").css("display")==="none"){
                obj.style.border="";
                $("#sel_div div").css("display","block");
                $("#sel_div").css("height","200px");
                $("#sel_div").css("border","1px solid #999999");
            }else{
                obj.style.border="1px solid #999999";
                $("#sel_div div").css("display","none");
                $("#sel_div").css("height","40px");
                $("#sel_div").css("border","");
            }
        }
    </script>
    <script>
        function sel_ck(obj,name) {
            var checkbox=$(".checkbox");
            for (var i=0;i<checkbox.length;i++){
                checkbox[i].checked=false;
            }
            if (obj.checked){
                obj.checked=false;
            }else{
                obj.checked=true;
            }
            $("#sel_div a").css("border","1px solid #999999");
            $("#sel_div div").css("display","none");
            $("#sel_div").css("height","40px");
            $("#sel_div").css("border","");
            var class_id=document.getElementById("in_class_id");
            class_id.value=obj.value;
            $("#sel_div a").html(name+"&nbsp;&nbsp;▼");
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
            <div class="crumb-list"><i class="icon-font"></i><a href="{{url("admin")}}">首页</a>
                <span class="crumb-step">&gt;</span><a class="crumb-name" href="{{url("admin/product")}}">产品管理</a>
                <span class="crumb-step">&gt;</span><span>新增产品</span>
            </div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <table class="insert-tab" width="100%">
                    <tbody>
                    <tr>
                        <th><i class="require-red">*</i>标题：</th>
                        <td><input class="common-text required" id="title" size="50" type="text"></td>
                    </tr>
                    <tr>
                        <th><i class="require-red">*</i>主图：</th>
                        <td>
                           <input class="common-text required" type="file" name="upload" id="file_upload">
                            <p id="p_img"></p>
                        </td>
                    </tr>
                    @if(count($product_class)>0)
                        <tr>
                            <th><i class="require-red">*</i>分类：</th>
                            <td style="position:absolute;z-index:1;background: #FFFFFF;">
                                <input type="hidden" value="" id="in_class_id">
                                <div id="sel_div">
                                    <a href="javascript:void(0)" style="padding:7px 10px 7px 5px;border:1px solid #999999;color: #0f0f0f;"
                                       onclick="sel(this)">选择分类&nbsp;&nbsp;▼</a>
                                    <div>
                                        @for($i=0;$i<count($product_class);$i++)
                                            @if(empty($product_class[$i]["c_class"]))
                                                <p><input onclick="sel_ck(this,'{{$product_class[$i]["p_class"]->name}}')" class="checkbox"
                                                          type="checkbox" value="{{$product_class[$i]["p_class"]->id}}">{{$product_class[$i]["p_class"]->name}}</p>
                                            @else
                                                <p><i style="margin-right:5px;" class="icon-font">&#xe027;</i>{{$product_class[$i]["p_class"]->name}}</p>
                                                @for($j=0;$j<count($product_class[$i]["c_class"]);$j++)
                                                    <p style="margin-left:20px;">
                                                        <input onclick="sel_ck(this,'{{$product_class[$i]["c_class"][$j]->name}}')" class="checkbox" type="checkbox"
                                                               value="{{$product_class[$i]["c_class"][$j]->id}}">{{$product_class[$i]["c_class"][$j]->name}}</p>
                                                @endfor
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th valign="top"><i class="require-red">*</i>内容：</th>
                        <td>
                            <textarea id="editor" name="editor"></textarea>
                            <script type="text/javascript">
                                CKEDITOR.replace("editor", {
                                    width:"90%",
                                    height: "400px",
                                    filebrowserImageUploadUrl: '{{url("admin/upload_product_img")}}?_token={{csrf_token()}}',
                                    toolbar: [
                                        ['Bold', 'Italic', 'Underline', 'Strike', 'Image', 'Smiley',
                                            'JustifyLeft', 'JustifyCenter', 'JustifyRight'],
                                        ['Link', 'TextColor', 'BGColor', 'Font', 'FontSize','Source']
                                    ]
                                });
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td id="info" style="color:red;"></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input class="btn btn-primary btn6 mr10" value="提交" type="button" onclick="add()">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/main-->
</div>
</body>
</html>