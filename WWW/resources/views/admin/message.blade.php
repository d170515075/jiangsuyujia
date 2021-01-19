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
        function browse(id) {
         ajax("{{url("admin/browse_msg")}}","_token={{csrf_token()}}&id="+id,function (str) {
          var obj=eval("("+str+")");
           var html="<div id='browse_div'>" +
                  "<h4 style='font-weight:700;'>"+obj[0].title+"</h4>"+
                  "<br><div>发布时间:"+obj[0].time+"</div><br>"+
              "<div class='content' style='line-height:25px;'>"+obj[0].content+"</div>"+
              "</div>";
          G.alert({title:"留言内容",width:600,height:500,content:html,ok:function () {
                  return true;
              }});
         })
        }
    </script>
    <script>
        function delone(id) {
            G.alert({content:"确定删除吗？",ok:function () {
                    ajax("{{url("admin/delete_msg")}}","_token={{csrf_token()}}&id="+id,function (str) {
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
                  ajax("{{url("admin/delete_msg")}}",string,function (str) {
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
            <span class="crumb-step">&gt;</span><span class="crumb-name">公司动态</span>
        </div>
    </div>
    <div class="result-wrap">
         <div class="result-title">
                <div class="result-list">
                    <a id="batchDel" href="javascript:void(0)" onclick="batch_del()"><i class="icon-font"></i>批量删除</a>
                </div>
            </div>
            <div class="result-content">
                <table class="result-tab" width="100%">
                    <tr>
                        <th class="tc">
                            <input type="checkbox" onclick="select_all(this)">全选</th>
                          <th>标题</th>
                        <th>姓名</th>
                        <th>QQ</th>
                        <th>邮箱</th>
                        <th>电话</th>
                        <th>发布时间</th>
                        <th>操作</th>
                    </tr>
                    @for($i=0;$i<count($msg);$i++)
                        <tr>
                            <td class="tc"><input type="checkbox" class="checkbox" value="{{$msg[$i]->id}}"></td>
                             <td>{{$msg[$i]->title}}</td>
                            <td>{{$msg[$i]->full_name}}</td>
                            <td>{{$msg[$i]->qq}}</td>
                            <td>{{$msg[$i]->email}}</td>
                            <td>{{$msg[$i]->telephone}}</td>
                            <td>{{$msg[$i]->time}}</td>
                            <td>
                                <a class="link-update" href="javascript:void(0)" onclick="browse('{{$msg[$i]->id}}')">
                                    <i style="margin-right:2px;" class="icon-font">&#xe001;</i>查看 </a>
                               <a class="link-update" href="javascript:void(0)" onclick="delone('{{$msg[$i]->id}}')">
                                    <i style="margin-right:2px;" class="icon-font">&#xe019;</i>删除</a>
                            </td>
                        </tr>
                        @endfor
                </table>
                <div class="list-page">{!! $msg->links() !!}</div>
            </div>
    </div>
</div>
<!--/main-->
</div>
</body>
</html>