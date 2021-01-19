<!DOCTYPE html>
<html>
<head>
    @include("admin.head")
    <script type="text/javascript" src="{{asset("public/ckeditor/ckeditor.js")}}"></script>
    <script>
        function update(id) {
            var stemTxt = CKEDITOR.instances.editor.document.getBody().getText();//获取CK纯文本
            var info = document.getElementById("info");
            var title = document.getElementById("title");
            var html = encodeURIComponent(CKEDITOR.instances.editor.getData());
            if (title.value === "" || /^\s+$/.test(title.value)) {
                info.innerHTML = "请输入标题";
            } else if (stemTxt === "" || /^\s+$/.test(stemTxt)) {
                info.innerHTML = "内容不能为空";
            }else {
                var string="id="+id+"&title="+encodeURIComponent(title.value)+"&content=" + html+"&_token={{csrf_token()}}";
                ajax("{{url("admin/update_news")}}",data=string,function (str) {
                    switch (str) {
                        case "ok":
                            G.alert({content:"修改成功",ok:function(){
                                    window.location ="{{url("admin")}}";
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
</head>
<body>
@include("admin.top")
<div class="container clearfix">
@include("admin.left")
<!--/sidebar-->
<div class="main-wrap">
    <div class="crumb-wrap">
        <div class="crumb-list"><i class="icon-font"></i><a href="{{url("admin")}}">首页</a>
            <span class="crumb-step">&gt;</span><a class="crumb-name" href="{{url("admin")}}">公司动态</a>
            <span class="crumb-step">&gt;</span><span>修改动态</span>
        </div>
    </div>
    <div class="result-wrap">
        <div class="result-content">
            <table class="insert-tab" width="100%">
                <tbody>
                <tr>
                    <th><i class="require-red">*</i>标题：</th>
                    <td><input class="common-text required" id="title" size="50" type="text" value="{{$news[0]->title}}"></td>
                </tr>
                <tr>
                    <th valign="top"><i class="require-red">*</i>内容：</th>
                    <td>
                        <textarea id="editor" name="editor">{{$news[0]->content}}</textarea>
                        <script type="text/javascript">
                            CKEDITOR.replace("editor", {
                                width:"90%",
                                height: "400px",
                                filebrowserImageUploadUrl: '{{url("admin/upload_news_img")}}?_token={{csrf_token()}}',
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
                        <input class="btn btn-primary btn6 mr10" value="提交" type="button" onclick="update('{{$news[0]->id}}')">
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