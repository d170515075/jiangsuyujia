<footer>
    <div class="copyright">
        <p>
            <a href="{{asset("index.php/about")}}">公司简介</a>&nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="{{asset("index.php/article")}}">公司动态</a>&nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="{{asset("/index.php/product")}}">产品中心</a>&nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="{{asset("/index.php/contact")}}">联系我们</a>
        </p>
        <p class="copyright_p">© 2000-2017 MojoCube All Rights Reserved. 信息产业部备案号：{{empty($data)?"":$data->icp}}</p>
    </div>
</footer>
<script type="text/javascript" src="{{asset("/public/home/js/common.js")}}"></script>