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
        function img(obj,img) {
           var w = obj.width();//容器宽度
              img.each(function(){//如果有很多图片，我们可以使用each()遍历
                    var img_w = $(this).width();//图片宽度
                    var img_h = $(this).height();//图片高度
                    if(img_w>w){//如果图片宽度超出容器宽度--要撑破了
                        var height = (w*img_h)/img_w; //高度等比缩放
                        $(this).css({"width":w,"height":height});//设置缩放后的宽度和高度
                    }
                });
        }
    </script>
    <script>
        function browse(id) {
         ajax("{{url("admin/browse_news")}}","_token={{csrf_token()}}&id="+id,function (str) {
          var obj=eval("("+str+")");
           var html="<div id='browse_div'>" +
                  "<h4 style='font-weight:700;'>"+obj[0].title+"</h4>"+
                  "<br><div>发布时间:"+obj[0].time+"</div><br>"+
              "<div class='content' style='line-height:25px;'>"+obj[0].content+"</div>"+
              "</div>";
          G.alert({title:"公司动态",width:600,height:500,content:html,ok:function () {
                  return true;
              }});
             img($("#browse_div"),$("#browse_div img"));
         })
        }
    </script>
    <script>
        function delone(id) {
            G.alert({content:"确定删除吗？",ok:function () {
                    ajax("{{url("admin/delete_news")}}","_token={{csrf_token()}}&id="+id,function (str) {
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
                  ajax("{{url("admin/delete_news")}}",string,function (str) {
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
                    <a href="{{url("admin/insert_news")}}"><i class="icon-font"></i>新增</a>
                    <a id="batchDel" href="javascript:void(0)" onclick="batch_del()"><i class="icon-font"></i>批量删除</a>
                </div>
            </div>
            <div class="result-content">
                <table class="result-tab" width="100%">
                    <tr>
                        <th class="tc">
                            <input type="checkbox" onclick="select_all(this)">全选</th>
                        <th>ID</th>
                        <th>标题</th>
                        <th>发布时间</th>
                        <th>操作</th>
                    </tr>
                    @for($i=0;$i<count($news);$i++)
                        <tr>
                            <td class="tc"><input type="checkbox" class="checkbox" value="{{$news[$i]->id}}"></td>
                            <td>{{$news[$i]->id}}</td>
                            <td>{{$news[$i]->title}}</td>
                            <td>{{$news[$i]->time}}</td>
                            <td>
                                <a class="link-update" href="javascript:void(0)" onclick="browse('{{$news[$i]->id}}')">
                                    <i style="margin-right:2px;" class="icon-font">&#xe001;</i>浏览 </a>
                                <a class="link-update" href="{{url("admin/modify_news")}}/{{$news[$i]->id}}">
                                    <i style="margin-right:2px;" class="icon-font">&#xe002;</i>修改 </a>
                               <a class="link-update" href="javascript:void(0)" onclick="delone('{{$news[$i]->id}}')">
                                    <i style="margin-right:2px;" class="icon-font">&#xe019;</i>删除</a>
                            </td>
                        </tr>
                        @endfor
                </table>
                <div class="list-page">{!! $news->links() !!}</div>
            </div>
    </div>
</div>
<!--/main-->
</div>
</body>
</html>