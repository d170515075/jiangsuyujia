Date.prototype.Format = function (fmt) {
    var o = {
        "M+": this.getMonth() + 1,                 //月份   
        "d+": this.getDate(),                    //日   
        "H+": this.getHours(),                   //小时   
        "m+": this.getMinutes(),                 //分   
        "s+": this.getSeconds(),                 //秒   
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度   
        "S": this.getMilliseconds()             //毫秒   
    };
    if (/(y+)/.test(fmt)) {
        fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    }
    for (var k in o) {
        if (new RegExp("(" + k + ")").test(fmt)) {
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        }
    }
    return fmt;
}


var S = {
    request: null,
    intervalTime: null,
    intervalOpenTime: null,
    initialization: null,
    scrollinterval: null,
    stop: true,
    lineStop: true,
    loadingWrap: true,
    backList: [],
    action: "/totaldata/action.ashx",
    loginDefautl: "/login/?e=" + +new Date()
};

var _INI_ = {

    //弹出对话框容器
    alertHtm: "<div id='myWarpr'>"
              + "<table class='myLayer' cellspacing='0' cellpadding='0' border='0'>"
              + "<tbody>"
              + "<tr>"
              + "<td>"
              + "<div class='myLayerOn'></div>"
              + "<div class='myLayerTitle'><h3></h3><a href='javascript:;' class='myLayerClose' title='關閉'></a></div>"
              + "<div class='myLayerContent' style='width:auto;height:auto;'></div>"
              + "<div class='myLayerFooter'><a href='javascript:;' class='btn grayBtn myLayerCancel' title='取消'>取消</a><a href='javascript:;' class='btn hotBtn myLayerOk' title='确认'>确认</a></div><div class='myLayerLoading'></div>"
              + "</td></tr></tbody></table></div>"

};

var G = {
    alert: function (msg) {
        $("#myWarpr").remove();
        $("body").append(_INI_.alertHtm);
        var myobj = $("#myWarpr");
        var title = msg.title || "提示";
        var content = msg.content || "";
        var width = msg.width || "auto";
        var height = msg.height || "auto";
        var initialize = msg.initialize || false;
        var cancel = msg.cancel || false;
        var ok = msg.ok || false;
        var close = msg.close || false;
        var okVal = msg.okVal || "确认";
        var cancelVal = msg.cancelVal || "取消";
        var lock = true;
        var top, left;

        myobj.find(".myLayerTitle h3").html(title);
        myobj.find(".myLayerContent").html(content);
        myobj.find(".myLayerFooter").hide();
        myobj.find(".myLayerFooter a.myLayerCancel").html(cancelVal).attr("title", cancelVal).hide();
        myobj.find(".myLayerFooter a.myLayerOk").html(okVal).attr("title", okVal).hide();

        if (lock) { //遮罩层
            $("#mymask").remove();
            $("body").append("<div class='myLayerLoading' id='mymask'></div>");
            $("#mymask").show();
        }
        if (msg.obj) {
            var obj = msg.obj;
            var elmOffset = obj.offset();
            top = elmOffset.top + obj.height() + 10; //控件top坐標
            left = elmOffset.left + 10; //控件left坐標
        } else {
            myobj.find(".myLayerOn").hide();
            myobj.find(".myLayerContent").css({ "width": width, "height": height, "overflow-y": "auto" });
            var myWidth = myobj.find(".myLayerContent").width();
            var myHieht = myobj.find(".myLayerContent").height();
            top = ($(window).height() - myHieht) / 2.8;
            left = ($(window).width() - myWidth) / 2;
            $(window).resize(function () {
                myobj.find(".myLayer").css({ "left": ($(window).width() - myWidth) / 2, "top": ($(window).height() - myHieht) / 2.8 });
                $("#mymask").css("height", $(window).height());
            });
        }
        myobj.find(".myLayer").css({ "top": top, "left": left });
        window.scrollTo(0, 0);

        if (ok) {
            myobj.find(".myLayerFooter").show();
            myobj.find(".myLayerFooter a.myLayerOk").show().focus();
        }
        if (cancel) {
            myobj.find(".myLayerFooter").show();
            myobj.find(".myLayerFooter a.myLayerCancel").show();
        }
        if (initialize) {
            initialize(myobj);
        }
        myobj.find(".myLayerClose").unbind("click").click(function () {
            if (close) { close(); }
            G.alertClose();
        });
        myobj.find(".myLayerCancel").unbind("click").click(function () {
            if (close) { close(); }
            if (!cancel()) {
                G.alertClose();
            }
        });
        myobj.find(".myLayerOk").unbind("click").click(function () {
            if (ok()) { G.alertClose(); }
            if (close) { close(); }
        });
    },
    alertClose: function () {
        $("#myWarpr").remove();
        $("#mymask").remove();
    },

    mask: function () {
        $("#mask-eah").remove();
        $("#myLayerImg").remove();
        $("body").append("<div class='myLayerLoading' id='mask-eah'></div>");
        $("body").append("<div class='myLayerImg' id='myLayerImg'></div>");
        $("#mask-eah").show();
    },
    maskClose: function () {
        $("#mask-eah").remove();
        $("#myLayerImg").remove();
    },
    myLayerImg: function () {
        $("#myLayerImg").remove();
        $("body").append("<div class='myLayerImg' id='myLayerImg'></div>");
    },
    myLayerImgClose: function () {
        $("#myLayerImg").remove();
    },

    isAction: function (msg) {
        for (var i = 0; i < msg.ary.length; i++) {
            if (msg.key === msg.ary[i]) {
                return true;
                break;
            }
        }
    },
    strToObj: function (str) {
        var mystr = str.split("&"), s;
        var data = ["\"__\":\"" + mystr[0] + "\""];
        for (var i = 1; i < mystr.length; i++) {
            if (mystr[i]) {
                s = mystr[i].split("=");
                data.push("\"" + s[0] + "\":\"" + s[1] + "\"");
            }
        }
        return eval("({" + data.join(",") + "})");
    },

    myTips: function (msg) {
        var content = msg.content;
        var elmOffset = msg.obj.offset();
        var _top = msg.top || 3;
        var _left = msg.left || 10;
        var top = msg.top || elmOffset.top - _top; //控件top坐標
        var left = msg.left || elmOffset.left + msg.obj.width() + _left; //控件left坐標
        var myDiv = "<div id='myxTips' style='left:" + left + "px; top:" + top + "px;'><div id='myxTipsLeft'></div><div id='myxTipsContent'>" + content + "</div></div>";
        $("#myxTips").remove();
        $("body").append(myDiv);
        if (msg.myclick) {
            var count = 0;
            $("body").unbind("click").click(function () {
                count++;
                if (count > 1) {
                    $("#myxTips").remove();
                    $("body").unbind("click");
                }
            });
        }else {
            setTimeout("G.removeTips()",2000);
        }
    },
    removeTips: function () {
        $("#myxTips").remove();
    },

    ajax: function (data_action, callBack, errorBack) {
        return $.ajax({
            type: "post",
            url: data_action.split("&")[0],
            cache: false,
            timeout: 1000 * 30,
            dataType: 'json',
            data: G.strToObj(data_action + "&t=" + __sysinfo.autoTid),
            success: function (msg) {
                try {
                    if (msg.error) {
                        if (msg.error == "SystemMaintenance") {
                            location.href = S.loginDefautl;
                        } else {
                            if (errorBack) errorBack();
                            G.alert({ content: msg.error, ok: function () { return true; } });
                        }
                    } else {
                        if (callBack) {
                            callBack(msg);
                        }
                    }
                } catch (e) { if (errorBack) errorBack(); }
            }, error: function () {
                if (errorBack) errorBack();
                //G.alert({ content: "Error：the options for this ajax request", ok: function () { return true; } });
            }
        });
    },

    //鼠标经过方法
    mouseover: function (str, hover) {
        var obj = $(str);
        $(obj).mouseover(function () {
            var _hover = hover || "myqhs";
            $(this).addClass(_hover).mouseout(function () {
                $(this).removeClass(_hover);
            });
        });
    },

    //Url参数替换
    urlReplace: function (msg) {
        var oUrl = msg.url || "";
        var paramName = msg.paramName || "page";
        var val = msg.val || "";
        var pad = msg.pad;
        var re = new RegExp("(/\?|&)" + paramName + "=([^&]+$)|" + paramName + "=[^&]+&", "i");
        var nUrl = oUrl.replace(re, '');
        if (pad == true) { //替换原有参数
            var _a = nUrl.indexOf("?") === -1 ? "?" : "&";
            return nUrl + _a + paramName + "=" + val;
        } else { //删除原有参数并返回
            return nUrl;
        }
    },
    //解析Url参数
    query: function (name, referrer) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var _referrer = referrer || location.href;
        var r = decodeURI(_referrer).split("?")[1].match(reg);
        if (r != null)
            return unescape(r[2]);
        return null;
    },

    //Dight 格式化浮点数 How 保留位数
    forDight: function (Dight, How) {
        Dight = Math.round(Dight * Math.pow(10, How)) / Math.pow(10, How);
        return parseFloat(Dight);
    },

    //强制保留小数 How保留位数
    toDecimal: function (Dight, How) {
        if (isNaN(parseFloat(Dight))) {
            return false;
        }
        var f = Math.round(Dight * 100) / 100;
        var s = f.toString();
        var rs = s.indexOf('.');
        if (rs < 0) {
            rs = s.length;
            s += '.';
        }
        while (s.length <= rs + How) {
            s += '0';
        }
        return s;
    },

    //写cookies
    setCookie: function (name, value) {
        var Days = 10;
        var exp = new Date();
        exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
        document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
    },

    //读cookies
    getCookie: function (name) {
        var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
        if (arr = document.cookie.match(reg))
            return unescape(arr[2]);
        else
            return null;
    },

    //删cookies
    delCookie: function (name) {
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval = comm.getCookie(name);
        if (cval != null)
            document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
    },

    //浮点数或正整数
    DecimalSign: function (str) {
        return /^[0-9]+(\.[0-9]+)?$/.test(str);
    },

    //正整数
    NumberSign: function (str) {
        return /^[0-9]+$/.test(str);
    },

    clearNoNum:function (obj)
    {
        obj.val(obj.val().replace(/[^\d.]/g,"")) ; //清除“数字”和“.”以外的字符
        obj.val(obj.val().replace(/^\./g,"")); //验证第一个字符是数字而不是.
        obj.val(obj.val().replace(/\.{2,}/g,".")); //只保留第一个. 清除多余的.
        obj.val(obj.val().replace(/^(\-)*(\d+)\.(\d).*$/,'$1$2.$3')); //只能输入两个小数
        obj.val(obj.val().replace(".","$#$").replace(/\./g,"").replace("$#$","."));
    },

    //可带正负号的正整数
    NumberSignt: function (str) {
        return /^[+-]?[0-9]+$/.test(str);
    },

    //中文或字符串或数字
    ChznSign: function (str) {
        return /^[a-zA-Z0-9-\u4e00-\u9fa5]+$/.test(str);
    },

    //是否是英文字母或数字或_的字符串{0,50}（不允许下划线开始）
    StringSign: function (str) {
        return /^[a-z0-9A-Z][a-z0-9A-Z_]{0,50}$/.test(str);
    },

    //移除數組中的重複值
    AryMethod: function (ary) {
        var h = {};    //定义一个hash表  
        var arr = [];  //定义一个临时数组  
        for (var i = 0; i < ary.length; i++) {    //循环遍历当前数组  
            //对元素进行判断，看是否已经存在表中，如果存在则跳过，否则存入临时数组  
            if (!h[ary[i]]) {
                //存入hash表  
                h[ary[i]] = true;
                //把当前数组元素存入到临时数组中  
                arr.push(ary[i]);
            }
        }
        return arr;
    },

    //滾動軸DIV
    overflowDiv: function (msg) {
        var id = msg.id || +new Date();
        var height = msg.height || 280;
        var content = msg.content || "加载中...";
        return "<div id='" + id + "' style='max-height:" + height + "px; overflow-y:auto;'>" + content + "</div>";
    },

    //分页查询
    searchPage: function ($this, currentPage, totalPage) {
        var pageIndex = false;
        var id = $this.attr("id");
        var current_page = currentPage || parseInt($("#shell_pageControl .pager #currentPage").html()); //当前第几页
        var total_page = totalPage || parseInt($("#shell_pageControl .pager #totalPage").html()); //总页数
        if (id == "first" && current_page > 1) { //第一页
            pageIndex = 1;
        } else if (id == "previous" && current_page > 1) { //上一页
            pageIndex = current_page - 1;
        } else if (id == "next" && total_page > current_page) { //下一页
            pageIndex = current_page + 1;
        } else if (id == "last" && total_page > current_page) { //最后一页
            pageIndex = total_page;
        }
        return pageIndex;
    },

    //时间戳转换HH:mm:ss
    settimes: function (time) {
        if (time > 0 && G.NumberSign(time)) {
            time = parseInt(time);
            var MinutesRound = Math.floor(time / 60);
            var SecondsRound = Math.floor(time - (60 * MinutesRound));
            var Minutes = MinutesRound.toString().length <= 1 ? "0" + MinutesRound : MinutesRound;
            var Seconds = SecondsRound.toString().length <= 1 ? "0" + SecondsRound : SecondsRound;
            var strtime = Minutes + ":" + Seconds;
            return strtime;
        } else {
            return "00:00";
        }
    },
    settimer: function (time) {
        if (time > 0 && G.NumberSign(time)) {
            var days = Math.floor(time / 1440 / 60);
            var hours = Math.floor((time - days * 1440 * 60) / 3600);
            var minutes = Math.floor((time - days * 1440 * 60 - hours * 3600) / 60);
            var seconds = (time - days * 1440 * 60 - hours * 3600 - minutes * 60);
            hours = hours.toString().length == 1 ? "0" + hours : hours;
            minutes = minutes.toString().length == 1 ? "0" + minutes : minutes;
            seconds = seconds.toString().length == 1 ? "0" + seconds : seconds;
            return hours + ":" + minutes + ":" + seconds;
        } else {
            return "00:00:00";
        }
    },

    //加载条
    scrollLoad: function (msg) {
        var defaults = {
            top: msg.top || "98px",
            left: msg.left || "0",
            backColor: msg.backColor || "blue",
            width: msg.width || "0px",
            height: msg.height || "5px",
            display: msg.display || "block",
            scrollStart: msg.scrollStart || 0,
            scrollLneght: msg.scrollLneght || $(window).width() - 10,
            second: msg.second || 1,
            increase: msg.increase || 0.7,
            addDiv: msg.addDiv || "Yes"
        };
        if (defaults.addDiv == "Yes") {
            (function () {
                var newDiv = "<div class='loadScroll' id='LoadScroll'";
                newDiv += "style='";
                newDiv += "position:absolute;";
                newDiv += "top:" + defaults.top + ";";
                newDiv += "left:" + defaults.left + ";";
                newDiv += "width:" + defaults.width + ";";
                newDiv += "max-width:" + (defaults.scrollLneght - 20) + "px;";
                newDiv += "height:" + defaults.height + ";";
                newDiv += "'></div>";
                $("body").append(newDiv);
            })();
        }
        var scrollStart = defaults.scrollStart;
        var scrollLneght = defaults.scrollLneght;
        var resize;
        clearInterval(S.scrollinterval);
        S.scrollinterval = setInterval(function () {
            scrollStart = scrollStart + defaults.increase;
            scrollLneght = scrollLneght - defaults.increase;
            if (!msg.back) //递增
                $("#LoadScroll").css("width", scrollStart + "px");
            else //递减
                $("#LoadScroll").css("width", scrollLneght + "px");

            if ((!msg.back && scrollStart > defaults.scrollLneght) || (msg.back && scrollLneght < 0)) {
                clearInterval(S.scrollinterval);
                if (msg.remove) {
                    setTimeout(function () { $("#LoadScroll").remove(); }, 300);
                }
            }
        }, defaults.second);
    },
    //加载数据异常，数据回滚
    rollBack: function () {
        var scrollLneght = $("#LoadScroll").width();
        var increase = 50;
        var second = 10;
        setTimeout(function () {
            G.scrollLoad({ scrollLneght: scrollLneght, increase: increase, second: second, addDiv: "No", back: true, remove: true });
        }, 500);
    },

    //加载完成
    loadEnd: function () {
        var scrollStart = $("#LoadScroll").width();
        var increase = 90;
        G.scrollLoad({ scrollStart: scrollStart, increase: increase, addDiv: "No", remove: true });
    },

    //驗證密碼
    safety: function (pwd) {
        //判斷密碼是是否合法（合法返回True）
        var Num1 = '123456789';
        var Num2 = '987654321';
        var rex1 = /[0-9]+/g;
        var rex2 = /[a-z]+/g;
        var t_PWD = pwd;
        var PWD_Legality = true;
        var t_PWD_str = t_PWD.toLowerCase();

        var resx1 = /^[0-9]+$/g;
        if (resx1.test(t_PWD_str)) PWD_Legality = false;
        resx1 = /^[a-z]+$/g;
        if (resx1.test(t_PWD_str)) PWD_Legality = false;

        // var strs1 = t_PWD_str.match(rex1);
        // if (strs1 != null) {
        //     for (var i = 0; i < strs1.length; i++) {
        //         if (strs1[i].length > 3) {
        //             if (Num1.indexOf(strs1[i]) != -1)
        //                 PWD_Legality = false; //数字顺序
        //             if (Num2.indexOf(strs1[i]) != -1)
        //                 PWD_Legality = false; //数字倒序
        //         }
        //     }
        // }
        // strs1 = t_PWD_str.match(rex2);
        // if (strs1 != null) {
        //     if (strs1.length == 1) {
        //         if (strs1[0].length == 1)
        //             PWD_Legality = false;
        //     } //只有一个字母
        // }
        //
        // for (var i = 0; i < t_PWD_str.length - 2; i++) {
        //     if (t_PWD_str.charAt(i) == t_PWD_str.charAt(i + 1)) {
        //         if (t_PWD_str.charAt(i) == t_PWD_str.charAt(i + 2)) {
        //             PWD_Legality = false;
        //         }
        //     }
        // }



        return PWD_Legality;
    },

    //RMB显示中文
    toRmb: function (value) {
        var whole = value || $("#Credits").val(), num, dig;
        if (!/^[0-9]*[1-9][0-9]+$/.test(whole) && whole != "") return;
        if (whole.indexOf(".") == -1) {
            num = whole;
            dig = "";
        }
        else {
            num = whole.substr(0, whole.indexOf("."));
            dig = whole.substr(whole.indexOf(".") + 1, whole.length);
        }

        var i = 1;
        var len = num.length;
        var dw2 = new Array("", "萬", "億");
        var dw1 = new Array("十", "百", "千");
        var dw = new Array("", "一", "二", "三", "四", "五", "六", "七", "八", "九");
        var k1 = k2 = 0, str = "";

        for (i = 1; i <= len; i++) {
            var n = num.charAt(len - i);
            if (n == "0") {
                if (k1 != 0)
                    str = str.substr(1, str.length - 1);
            }

            str = dw[Number(n)].concat(str);

            if (len - i - 1 >= 0) {
                if (k1 != 3) {
                    str = dw1[k1].concat(str);
                    k1++;
                }
                else {
                    k1 = 0;
                    var temp = str.charAt(0);
                    if (temp == "萬" || temp == "億")
                        str = str.substr(1, str.length - 1);
                    str = dw2[k2].concat(str);
                }
            }
            if (k1 == 3)
                k2++;
        }
        if (str.length >= 2)
            if (str.substr(0, 2) == "一十") str = str.substr(1, str.length - 1);
        //document.getElementById(sName).innerHTML = str;
        return str;
    },

    //HK 3色球
    contains: function (num) {
        var red = [1, 2, 7, 8, 12, 13, 18, 19, 23, 24, 29, 30, 34, 35, 40, 45, 46];
        var blue = [3, 4, 9, 10, 14, 15, 20, 25, 26, 31, 36, 37, 41, 42, 47, 48];
        var green = [5, 6, 11, 16, 17, 21, 22, 27, 28, 32, 33, 38, 39, 43, 44, 49];
        for (var i = 0; i < red.length; i++) {
            if (red[i] == num) {
                return "red";
            }
        }
        for (var i = 0; i < blue.length; i++) {
            if (blue[i] == num) {
                return "bluer";
            }
        }
        for (var i = 0; i < green.length; i++) {
            if (green[i] == num) {
                return "green";
            }
        }
    },

    //GX 3色球
    contains_gx: function (num) {
        var red = [1, 4, 7, 10, 13, 16, 19];
        var blue = [2, 5, 8, 11, 14, 17, 20];
        var green = [3, 6, 9, 12, 15, 18, 21];
        for (var i = 0; i < red.length; i++) {
            if (red[i] == num) {
                return "red";
            }
        }
        for (var i = 0; i < blue.length; i++) {
            if (blue[i] == num) {
                return "bluer";
            }
        }
        for (var i = 0; i < green.length; i++) {
            if (green[i] == num) {
                return "green";
            }
        }
    },

    /// <summary>
    /// 复式计算，0返回总列表List、1总组数
    /// </summary>
    /// <param name="cycle">循环次数</param>
    /// <param name="ary">循环数组</param>
    /// <returns>{list:数组,count:总组数}</returns>
    DuplexSum: function (cycle, ary) {
        var list = [];
        var len = ary.length, _count = 0;
        for (var a = 0; a < len; a++) {
            var _a = a + 1;
            for (var b = _a; b < len; b++) {
                if (cycle == 2) {
                    _count++;
                    list.push(ary[a] + "," + ary[b]);
                    continue;
                }
                var _b = b + 1;
                for (var c = _b; c < len; c++) {
                    if (cycle == 3) {
                        _count++;
                        list.push(ary[a] + "," + ary[b] + "," + ary[c]);
                        continue;
                    }
                    var _c = c + 1;
                    for (var d = _c; d < len; d++) {
                        if (cycle == 4) {
                            _count++;
                            list.push(ary[a] + "," + ary[b] + "," + ary[c] + "," + ary[d]);
                            continue;
                        }
                        var _d = d + 1;
                        for (var e = _d; e < len; e++) {
                            if (cycle == 5) {
                                _count++;
                                list.push(ary[a] + "," + ary[b] + "," + ary[c] + "," + ary[d] + "," + ary[e]);
                                continue;
                            }
                            var _e = e + 1;
                            for (var f = _e; f < len; f++) {
                                if (cycle == 6) {
                                    _count++;
                                    list.push(ary[a] + "," + ary[b] + "," + ary[c] + "," + ary[d] + "," + ary[e] + "," + ary[f]);
                                    continue;
                                }
                                var _f = f + 1;
                                for (var g = _f; g < len; g++) {
                                    if (cycle == 7) {
                                        _count++;
                                        list.push(ary[a] + "," + ary[b] + "," + ary[c] + "," + ary[d] + "," + ary[e] + "," + ary[f] + "," + ary[g]);
                                        continue;
                                    }
                                    var _g = g + 1;
                                    for (var h = _g; h < len; h++) {
                                        if (cycle == 8) {
                                            _count++;
                                            list.push(ary[a] + "," + ary[b] + "," + ary[c] + "," + ary[d] + "," + ary[e] + "," + ary[f] + "," + ary[g] + "," + ary[h]);
                                            continue;
                                        }
                                        var _h = h + 1;
                                        for (var y = _h; y < len; y++) {
                                            if (cycle == 9) {
                                                _count++;
                                                list.push(ary[a] + "," + ary[b] + "," + ary[c] + "," + ary[d] + "," + ary[e] + "," + ary[f] + "," + ary[g] + "," + ary[h] + "," + ary[y]);
                                                continue;
                                            }
                                            var _y = y + 1;
                                            for (var z = _y; z < len; z++) {
                                                if (cycle == 10) {
                                                    _count++;
                                                    list.push(ary[a] + "," + ary[b] + "," + ary[c] + "," + ary[d] + "," + ary[e] + "," + ary[f] + "," + ary[g] + "," + ary[h] + "," + ary[y] + "," + ary[z]);
                                                    continue;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return { list: list, count: _count };
    }
};

function forceMiddle(msg) {
    var id = msg.id || +new Date();
    var title = msg.title || "";
    var title_nav = msg.titleNav || "";
    var theadAry = msg.thead || [];
    var tbodyAry = msg.tbody || [];

    if (title) {
        $("#shell_title").html(title);
    }

    if (title_nav && title_nav != "") {
        $("#shell_top").append("<div id='title-nav'>" + title_nav + "</div>");
    }

    var mythead = ["<tr>"];
    for (var i = 0; i < theadAry.length; i++) {
        mythead.push("<th>" + theadAry[i] + "</th>");
    }
    mythead.push("</tr>");
    if (msg.eachThead) {
        mythead = [msg.eachThead];
    }

    var fonDiv = "";
    if (msg.fonDiv) {
        fonDiv = "<div id='fondiv' style='text-align:center;padding:5px 0;margin-top:2px;' class='bc'><a href='javascript:void(0);'>點擊獲取更多...</a><span id='nodataTitle' class='hiden'>無數據加載！</span></div>";
    }
    return "<div id='" + id + "'><table class='middle-table'><thead>" + mythead.join("") + "</thead><tbody>" + tbodyAry.join("") + "</tbody></table>" + fonDiv + "</div>";
}

function pageMiddle(msg, callBack) {
    var currentPage = msg.currentPage || 0;
    var totalPage = msg.totalPage || 0;
    var middle = "<div id='shell_pageControl'><div class='pager' id='data-page'>"
            + "<span class='first cursor' id='first'>首页</span>"
            + "<span class='previous cursor' id='previous'>上一页</span>"
            + "<span class='current_page'>第<b id='currentPage'>" + currentPage + "</b>页</span>"
            + "<span class='total_page'>共<b class='total' id='totalPage'>" + totalPage + "</b>页</span>"
            + "<span class='next cursor' id='next'>下一页</span>"
            + "<span class='last cursor' id='last'>尾页</span>"
        + "</div></div>";
    if (msg.obj) {
        if ($("#data-page").length == 0) {
            msg.obj.html(middle);
        }
        msg.obj.html(middle);
        //绑定分页事件
        $("#data-page span.cursor").unbind("click").click(function () {
            var page = G.searchPage($(this));
            if (page && callBack) {
                if (callBack) {
                    callBack(G.urlReplace({ url: "?" + msg.referrer, paramName: "page", val: page, pad: true }).replace("?", ""));
                }
            }
        });
    }
}
//模拟测速
function SelectBoxSet(n) {

    var data = __sysinfo.ipJoin || __sysinfo.data.ipJson;;
    for (var k =0 ; k < data.length; k++){
        ping({url:data[k],beforePing:function (index) {
                $("#lineching input[type='text']").eq(index).val("测速中");
            },afterPing:function (index,time) {
                var t = "";
                if (time < 200){
                    t = "超好";
                }else if (time < 500){
                    t = "较好";
                }else if (time >= 2000 ){
                    t = "超时";
                }else {
                    t = time + "毫秒";
                }
                $("#lineching input[type='text']").eq(index).val(t);

            },interval : 1,idx:k})
    }


}

function ping(option) {
    var time, requestTime, responseTime ;
    var getUrl = function(url){    //保证url带http://
        var strReg="^((https|http)?://){1}"
        var re=new RegExp(strReg);
        return re.test(url)?url:"http://"+url;
    }
    $.ajax({
        url: getUrl(option.url)+'/netTest/?date='+ (new Date()).getTime() ,  //设置一个空的ajax请求
        // url: 'http://ub1.kf963.com/netTest/?date='+ (new Date()).getTime() ,  //设置一个空的ajax请求
        type: 'GET',
        dataType: 'json',
        timeout: 3000,
        beforeSend : function()
        {
            if(option.beforePing) option.beforePing(option.idx);
            requestTime = new Date().getTime();
        },
        complete : function(json)
        {
            responseTime = new Date().getTime();
            time = Math.abs(requestTime - responseTime);
            if(option.afterPing) option.afterPing(option.idx,time);
        }
    });



}

function floatAdd(arg1, arg2) {
    var r1, r2, m;
    try {
        r1 = arg1.toString().split(".")[1].length
    } catch (e) {
        r1 = 0
    }
    try {
        r2 = arg2.toString().split(".")[1].length
    } catch (e) {
        r2 = 0
    }
    return m = Math.pow(10, Math.max(r1, r2)), parseFloat(((arg1 * m + arg2 * m) / m).toFixed(4));
}

function floatSubtr(arg1, arg2) {
    return floatAdd(arg1, -arg2);
}

function peishuquanzhuan(category,peiNumArr,dw5zi,qz) {

    var createNumberArr = [];
    if (category == 2){

        for (var n = 0 ; n < peiNumArr[0].length; n++){
            for (var n2 = 0 ; n2 < peiNumArr[1].length; n2++){
                if (qz && n == n2) { continue;}
                for (var k = 0; k < 3 + dw5zi;k++){
                    for (var k2 = k + 1; k2 < 4 + dw5zi;k2++){
                        var tmp = [[0,1],[1,0]];
                        var tmp2 = [peiNumArr[0][n],peiNumArr[1][n2]];
                        for (var q = 0; q < tmp.length; q++) {
                            var number = ['X', 'X', 'X', 'X', 'X'];
                            number[k] = tmp2[tmp[q][0]];
                            if (dw5zi == 1) number[4] = tmp2[tmp[q][1]];
                            else number[k2] = tmp2[tmp[q][1]];
                            if (createNumberArr.indexOf(number.join("")) == -1)
                                createNumberArr.push(number.join(""));
                        }
                    }
                }
            }
        }
    }else if (category == 3){

        for (var n = 0 ; n < peiNumArr[0].length; n++){
            for (var n2 = 0 ; n2 < peiNumArr[1].length; n2++){
                if (qz && n == n2) { continue;}
                for (var n3 = 0 ; n3 < peiNumArr[2].length; n3++) {
                    if (qz && (n3 == n2 || n3 == n)) { continue;}
                    for (var k = 0; k < 2; k++) {
                        for (var k2 = k + 1; k2 < 3; k2++) {
                            for (var k3 = k2 + 1; k3 < 4; k3++) {
                                var tmp = [[0,1,2],[0,2,1],[1,0,2],[1,2,0],[2,0,1],[2,1,0]];
                                var tmp2 = [peiNumArr[0][n],peiNumArr[1][n2],peiNumArr[2][n3]];
                                for (var q = 0; q < tmp.length; q++) {
                                    var number = ['X', 'X', 'X', 'X', 'X'];
                                    number[k + dw5zi] = tmp2[tmp[q][0]];
                                    number[k2 + dw5zi] = tmp2[tmp[q][1]];
                                    if (dw5zi == 1)number[4] = tmp2[tmp[q][2]];
                                    else number[k3 + dw5zi] = tmp2[tmp[q][2]];
                                    if (createNumberArr.indexOf(number.join("")) == -1)
                                        createNumberArr.push(number.join(""));
                                }
                            }
                        }
                    }
                }
            }
        }
    }else if (category == 4){
        for (var n = 0 ; n < peiNumArr[0].length; n++){
            for (var n2 = 0 ; n2 < peiNumArr[1].length; n2++){
                if (qz && n == n2) { continue;}
                for (var n3 = 0 ; n3 < peiNumArr[2].length; n3++) {
                    if (qz && (n3 == n2 || n3 == n)) { continue;}
                    for (var n4 = 0 ; n4 < peiNumArr[3].length; n4++) {
                        if (qz && (n3 == n4 || n4 == n2 || n4 == n)) { continue;}
                        for (var k = 0; k < 1; k++) {
                            for (var k2 = k + 1; k2 < 2; k2++) {
                                for (var k3 = k2 + 1; k3 < 3; k3++) {
                                    for (var k4 = k3 + 1; k4 < 4; k4++) {
                                        var tmp = [[0,1,2,3],[0,1,3,2],[0,2,1,3],[0,2,3,1],[0,3,2,1],[0,3,1,2],
                                        [1,0,2,3],[1,0,3,2],[1,2,0,3],[1,2,3,0],[2,0,1,3],[2,0,3,1],[2,1,0,3],[2,1,3,0]
                                        ,[2,3,0,1],[2,3,1,0],[3,0,1,2],[3,0,2,1],[3,1,0,2],[3,1,2,0],[3,2,0,1],[3,2,1,0]];
                                        var tmp2 = [peiNumArr[0][n],peiNumArr[1][n2],peiNumArr[2][n3],peiNumArr[3][n4]];
                                        for (var q = 0; q < tmp.length; q++) {
                                            var number = ['', '', '', '', ''];
                                            number[k ] = tmp2[tmp[q][0]];
                                            number[k2 ] = tmp2[tmp[q][1]];
                                            number[k3] = tmp2[tmp[q][2]];
                                            number[k4] = tmp2[tmp[q][3]];

                                             number.splice(dw5zi-1,0,'X');

                                            if (createNumberArr.indexOf(number.join("")) == -1)
                                                createNumberArr.push(number.join(""));
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return  createNumberArr;
}

function dwcreatenumber(category,posNumArr,numPos) {

    var createNumberArr = [];
    if (category == 2){
        for (var i = 0; i < posNumArr[numPos[0]].length;i++){
            for (var n = 0; n < posNumArr[numPos[1]].length; n++){
                var number = ['X','X','X','X','X'];
                number[numPos[0]] = posNumArr[numPos[0]][i];
                number[numPos[1]] = posNumArr[numPos[1]][n];
                if (createNumberArr.indexOf(number.join("")) == -1)
                    createNumberArr.push(number.join(""));
            }
        }
    }else if (category == 3){
        for (var i = 0; i < posNumArr[numPos[0]].length;i++){
            for (var n = 0; n < posNumArr[numPos[1]].length; n++){
                for (var n2 = 0; n2 < posNumArr[numPos[2]].length; n2++){
                    var number = ['X','X','X','X','X'];
                    number[numPos[0]] = posNumArr[numPos[0]][i];
                    number[numPos[1]] = posNumArr[numPos[1]][n];
                    number[numPos[2]] = posNumArr[numPos[2]][n2];
                    if (createNumberArr.indexOf(number.join("")) == -1)
                        createNumberArr.push(number.join(""));
                }
            }
        }
    }else if (category == 4){
        for (var i = 0; i < posNumArr[numPos[0]].length;i++){
            for (var n = 0; n < posNumArr[numPos[1]].length; n++){
                for (var n2 = 0; n2 < posNumArr[numPos[2]].length; n2++){
                    for (var n3 = 0; n3 < posNumArr[numPos[3]].length; n3++){
                        var number = ['X','X','X','X','X'];
                        number[numPos[0]] = posNumArr[numPos[0]][i];
                        number[numPos[1]] = posNumArr[numPos[1]][n];
                        number[numPos[2]] = posNumArr[numPos[2]][n2];
                        number[numPos[3]] = posNumArr[numPos[3]][n3];
                        if (createNumberArr.indexOf(number.join("")) == -1)
                            createNumberArr.push(number.join(""));
                    }
                }
            }
        }
    }
    return createNumberArr;
}

function brother(number) {

    var tmpNumber = [];
    for (var n = 0; n < number.length; n++) {
        if (number[n] != 'X') tmpNumber.push(number[n]);
    }
    tmpNumber = tmpNumber.sort();
    var quchong = [];
    for (var n2 = 0; n2 < tmpNumber.length; n2++){
        if (quchong.indexOf(tmpNumber[n2]) == -1) quchong.push(tmpNumber[n2]);
    }

    tmpNumber = quchong;

    var count = 0;//9810 0459
    for (var n = 1; n < tmpNumber.length; n++){
       if (tmpNumber[n] - tmpNumber[n-1] == 1) count++;
       else if (count > 0)break;
    }

    if ((tmpNumber.length == 2 || tmpNumber.length == 3) && ( tmpNumber[tmpNumber.length - 1] - tmpNumber[0] == 9)){
        count++;
    }else if (tmpNumber.length == 4){
        if (tmpNumber.join("") == "0189") count = 3;
        else if (count == 0 && tmpNumber[tmpNumber.length - 1] - tmpNumber[0] == 9) count = 1;
        else if (tmpNumber[tmpNumber.length - 1] - tmpNumber[0] == 9 && (tmpNumber[1] - tmpNumber[0] == 1 || tmpNumber[3] - tmpNumber[2] == 1)) count++;
    }


    return count + 1;

}

function chong(number) {

    number = number.replace(/X/g,"");
    var tmpNumber={};
    for (var i = 0; i < number.length; i++) {
        if (tmpNumber[number[i]]) {
            tmpNumber[number[i]]++;
        }else {
            tmpNumber[number[i]]=1;
        }
    }

    var count = 0;
    var ssc = 0;
    for (var key in tmpNumber) {
        if (tmpNumber[key] > count) count = tmpNumber[key];
        if (tmpNumber[key] == 2) ssc++;
    }

    if (ssc == 2) return 5;

    return count;


}

function getNumbersByCategory(category,dw5zi) {
    var numPosArr;
    if (category == 2) {
        if (dw5zi == 0) numPosArr = [[0, 1], [0, 2], [0, 3], [1, 2], [1, 3], [2, 3]];
        else numPosArr = [[0, 4], [1, 4], [2, 4], [3, 4]];
    } else if (category == 3) {
        if (dw5zi == 0) numPosArr = [[0, 1, 2], [0, 1, 3], [0, 2, 3], [1, 2, 3]];
        else numPosArr = [[0, 1, 4], [0, 2, 4], [0, 3, 4], [1, 2, 4], [1, 3, 4], [2, 3, 4]];
    } else if (category == 4) {
        numPosArr = [[0, 1, 2, 3], [0, 1, 2, 4], [0, 1, 3, 4], [0, 2, 3, 4], [1, 2, 3, 4]];
        var index = [4,3, 2, 1, 0];
        numPosArr = [numPosArr[index[dw5zi-1]]];
    }
    var allNumberArr = [];
    for (var i = 0; i < numPosArr.length; i++) {
        var allPeiNumArr = [];
        var posArr = numPosArr[i];
        for (var n = 0; n < posArr.length; n++) {
            allPeiNumArr[posArr[n]] = "0123456789";
        }

        allNumberArr = allNumberArr.concat(dwcreatenumber(category, allPeiNumArr, posArr));

    }
    return allNumberArr;
}


//集合去掉重复
Array.prototype.uniquelize = function () {
    var tmp = {},
        ret = [];
    for (var i = 0, j = this.length; i < j; i++) {
        if (!tmp[this[i]]) {
            tmp[this[i]] = 1;
            ret.push(this[i]);
        }
    }

    return ret;
}

///集合取交集
Array.intersect = function () {
    var result = new Array();
    var obj = {};
    for (var i = 0; i < arguments.length; i++) {
        for (var j = 0; j < arguments[i].length; j++) {
            var str = arguments[i][j];
            if (!obj[str]) {
                obj[str] = 1;
            }
            else {
                obj[str]++;
                if (obj[str] == arguments.length)
                {
                    result.push(str);
                }
            }//end else
        }//end for j
    }//end for i
    return result;
}

//2个集合的差集 在arr不存在
Array.prototype.minus = function (arr) {
    var result = new Array();
    var obj = {};
    for (var i = 0; i < arr.length; i++) {
        obj[arr[i]] = 1;
    }
    for (var j = 0; j < this.length; j++) {
        if (!obj[this[j]])
        {
            obj[this[j]] = 1;
            result.push(this[j]);
        }
    }
    return result;
};

//并集
Array.union = function () {
    var arr = new Array();
    var obj = {};
    for (var i = 0; i < arguments.length; i++) {
        for (var j = 0; j < arguments[i].length; j++)
        {
            var str=arguments[i][j];
            if (!obj[str])
            {
                obj[str] = 1;
                arr.push(str);
            }
        }//end for j
    }//end for i
    return arr;
}