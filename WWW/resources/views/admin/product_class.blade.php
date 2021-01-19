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
        function delone(id) {
            G.alert({content:"确定删除吗？",ok:function () {
                    ajax("{{url("admin/delone_class")}}","_token={{csrf_token()}}&id="+id,function (str) {
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
                    ajax("{{url("admin/batch_del_class")}}",string,function (str) {
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
    <script>
        function add_child(p_id,p_name) {
            var html="<div>"+
                    "<div onclick='jia()' style='cursor:pointer;color:blue;'><i class='icon-font'>&#xe026;</i>子类</div>"+
                "<div id='add_div'>"+
                    "<div style='margin-top:10px;color:blueviolet;'>父类名称："+p_name+"</div>"+
                "<div style='margin-top:10px'>子类名称：" +
                "<input class='common-text required product_class_name' size='40' type='text'>" +
                "</div>"+
                "</div>"+
                "<div id='msg' style='margin:10px auto auto 60px;color:red;'></div>"+
                "</div>";
          G.alert({title:"添加子类",content:html,ok:function () {
                  var msg=document.getElementById("msg");
                  var name=[];
                  var product_class_name=$(".product_class_name");
                  for (var i=0;i<product_class_name.length;i++){
                      if (product_class_name[i].value !=="" && !/^\s+$/.test(product_class_name[i].value)){
                          name.push(product_class_name[i].value);
                      }
                  }
                  if (name.length===0){
                      msg.innerHTML="请输入分类名称";
                      return false;
                  }
                  var string="_token={{csrf_token()}}&name="+name+"&p_id="+p_id;
                  ajax("{{url("admin/add_product_class")}}",string,function (str) {
                      if (str==="ok"){
                          G.alert({content:"添加成功",ok:function(){window.location=window.location.href;return true;}})
                      }else{
                          msg.innerHTML=str;
                          return false;
                      }
                  })
              },cancel:function () {

              }});
        }
    </script>
    <script>
        function jia() {
            var product_class_name=$(".product_class_name");
            if (product_class_name.length>=10){
                return false;
            }
            var str="<div style='margin-top:10px'>子类名称：<input class='common-text required product_class_name' size='40' type='text'>" +
                "</div>";
            $("#add_div").append(str);
        }
    </script>
    <script>
        function jia_parent() {
            var product_class_name=$(".product_class_name");
            if (product_class_name.length>=10){
                return false;
            }
            var str="<div style='margin-top:10px'>分类名称：<input class='common-text required product_class_name' size='40' type='text'>" +
                "</div>";
            $("#add_div").append(str);
        }
    </script>
    <script>
        function add_parent() {
            var html="<div>"+
                "<div onclick='jia_parent()' style='cursor:pointer;color:blue;'><i class='icon-font'>&#xe026;</i>添加分类</div>"+
                "<div id='add_div'>"+
               "<div style='margin-top:10px'>分类名称：" +
                "<input class='common-text required product_class_name' size='40' type='text'>" +
                "</div>"+
                "</div>"+
                "<div id='msg' style='margin:10px auto auto 60px;color:red;'></div>"+
                "</div>";
            G.alert({title:"添加分类",content:html,ok:function () {
                    var msg=document.getElementById("msg");
                    var name=[];
                    var product_class_name=$(".product_class_name");
                    for (var i=0;i<product_class_name.length;i++){
                        if (product_class_name[i].value !=="" && !/^\s+$/.test(product_class_name[i].value)){
                            name.push(product_class_name[i].value);
                        }
                    }
                    if (name.length===0){
                        msg.innerHTML="请输入分类名称";
                        return false;
                    }
                    var string="_token={{csrf_token()}}&name="+name;
                    ajax("{{url("admin/add_product_parent_class")}}",string,function (str) {
                        if (str==="ok"){
                            G.alert({content:"添加成功",ok:function(){window.location=window.location.href;return true;}})
                        }else{
                            msg.innerHTML=str;
                            return false;
                        }
                    })
                },cancel:function () {

                }});
        }
    </script>
    <script>
        function modify_class(id,name) {
            var html="<div>"+
            "<div id='add_div'>"+
                "<div style='margin-top:10px'>分类名称：" +
                "<input class='common-text required' id='product_class_name' size='40' type='text' value="+name+">" +
                "</div>"+
                "</div>"+
                "<div id='msg' style='margin:10px auto auto 60px;color:red;'></div>"+
                "</div>";
            G.alert({title:"修改分类",content:html,ok:function () {
                    var msg=document.getElementById("msg");
                    var product_class_name=document.getElementById("product_class_name");
                     if (product_class_name.value==="" || /^\s+$/.test(product_class_name.value)){
                        msg.innerHTML="请输入分类名称";
                        return false;
                    }
                    var string="_token={{csrf_token()}}&name="+product_class_name.value+"&id="+id;
                    ajax("{{url("admin/modify_class")}}",string,function (str) {
                        if (str==="ok"){
                        G.alert({content:"修改成功",ok:function(){window.location=window.location.href;return true;}})
                        }else{
                            msg.innerHTML=str;
                            return false;
                        }
                    })
                },cancel:function () {

                }});
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
                <span class="crumb-step">&gt;</span><span class="crumb-name">分类管理</span>
            </div>
        </div>
        <div class="result-wrap">
            <div class="result-title">
                <div class="result-list">
                    <a href="javascript:void(0)" onclick="add_parent()"><i class="icon-font"></i>添加分类</a>
                    <a id="batchDel" href="javascript:void(0)" onclick="batch_del()"><i class="icon-font"></i>批量删除</a>
                </div>
            </div>
            <div class="result-content">
                <table class="result-tab" width="100%">
                    <tr>
                        <th class="tc">
                            <input type="checkbox" onclick="select_all(this)">全选</th>
                        <th style="width:30px;"></th>
                        <th style="text-align: left;">分类名称</th>
                        <th>父分类</th>
                        <th>操作</th>
                    </tr>
                    @if(count($product_class)>0)
                    @for($i=0;$i<count($product_class);$i++)
                        <tr style="background:#d1e6e6;">
                            <td style="width:50px;text-align: center;">
                                <input class="checkbox" type="checkbox" value="{{$product_class[$i]["p_class"]->id}}">
                            </td>
                            <td><i class="icon-font">&#xe027;</i></td>
                            <td style="text-align: left;">{{$product_class[$i]["p_class"]->name}}</td>
                            <td>{{$product_class[$i]["p_class"]->name}}</td>
                            <td>
                                <a class="link-update" href="javascript:void(0)" onclick="add_child('{{$product_class[$i]["p_class"]->id}}','{{$product_class[$i]["p_class"]->name}}')">
                                    <i style="margin-right:2px;" class="icon-font">&#xe026;</i>子类</a>
                                <a class="link-update" href="javascript:void(0)" onclick="modify_class('{{$product_class[$i]["p_class"]->id}}','{{$product_class[$i]["p_class"]->name}}')">
                                    <i style="margin-right:2px;" class="icon-font">&#xe002;</i>修改 </a>
          <a class="link-update" href="javascript:void(0)" onclick="delone('{{$product_class[$i]["p_class"]->id}}')">
          <i style="margin-right:2px;" class="icon-font">&#xe019;</i>删除</a>
                            </td>
                        </tr>
                        @if(!empty($product_class[$i]["c_class"]))
                            @for($j=0;$j<count($product_class[$i]["c_class"]);$j++)
                                    <tr>
                                        <td></td>
                                        <td style="width:30px;">
                                            <input class="checkbox" type="checkbox" value="{{$product_class[$i]["c_class"][$j]->id}}">
                                           </td>
                                        <td style="text-align: left;">{{$product_class[$i]["c_class"][$j]->name}}</td>
                                        <td>{{$product_class[$i]["p_class"]->name}}</td>
                                        <td>
                                            <a class="link-update" href="javascript:void(0)" onclick="modify_class('{{$product_class[$i]["c_class"][$j]->id}}','{{$product_class[$i]["c_class"][$j]->name}}')">
                                                <i style="margin-right:2px;" class="icon-font">&#xe002;</i>修改 </a>
                                            <a class="link-update" href="javascript:void(0)" onclick="delone('{{$product_class[$i]["c_class"][$j]->id}}')">
                                                <i style="margin-right:2px;" class="icon-font">&#xe019;</i>删除</a>
                                        </td>
                                    </tr>
                                @endfor
                            @endif
                        @endfor
                        @endif
                </table>
                <div class="list-page"></div>
            </div>
        </div>
    </div>
    <!--/main-->
</div>
</body>
</html>