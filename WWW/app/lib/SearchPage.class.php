<?php

class SearchPage
{
    public $limit;
    private $totalRows;
    public $pageSize;
    private $url;
    private $pageNum;
    private $prev;
    public $page;

    function __construct($totalRows, $pageSize, $search)
    {
        $this->totalRows = $totalRows;
        $this->pageSize = $pageSize;
        $this->url = $_SERVER["PHP_SELF"] . $search;
        $this->pageNum = ceil($this->totalRows / $pageSize);
        if (empty($_GET["page"])){
            $this->page=1;
        }else if (preg_match("/^[0-9]+$/",$_GET["page"]) !==1){
            $this->page=1;
        }else{
            if ($_GET["page"]>$this->pageNum){
                $this->page=1;
            }else{
                $this->page=$_GET["page"];
            }
        }
        $this->prev = $this->prev();
        $this->limit =(($this->page - 1) * $this->pageSize) . ",{$this->pageSize}";
    }

    private function prev()
    {
        if ($this->page == 1) {
            return "<li class='disabled'><a href='javascript:void(0)'>上一页</a></li>";
        } else {
            return "<li><a  href='{$this->url}&page=" . ($this->page - 1) . "'>上一页</a></li>";
        }
    }



    private function pagelist()
    {
        if ($this->pageNum <= 9) {
            for ($i = 1; $i <= $this->pageNum; $i++) {
                if ($this->page == $i) {
                    echo "<li class='active'><a href='javascript:void(0)'>{$i}</a></li>";
                } else {
                    echo "<li><a  href='{$this->url}&page={$i}'>{$i}</a></li>";
                }
            }
        } else if ($this->pageNum > 9) {
            for ($i = 1; $i <= 3; $i++) {
                if ($this->page == $i) {
                    echo "<li class='active'><a href='javascript:void(0)'>{$i}</a></li>";
                } else {
                    if ($i == 3 && $this->page > 6) {
                        echo "<li><a href='javascript:void(0)'>..</a></li>";
                    } else {
                        echo "<li><a href='{$this->url}&page={$i}'>{$i}</a></li>";
                    }
                }
            }
            //=======================
            if ($this->page <= 6) {
                for ($i = 4; $i <= 9; $i++) {
                    if ($this->page == $i) {
                        echo "<li class='active'><a href='javascript:void(0)'>{$i}</a></li>";
                    } else {
                        if ($i == 9) {
                            echo "<li><a href='javascript:void(0)'>..</a></li>";
                        } else {
                            echo "<li ><a href='{$this->url}&page={$i}'>{$i}</a></li>";
                        }
                    }
                }
            }
            //=============
            if ($this->page > 6 && $this->pageNum - $this->page >= 3) {
                for ($i = $this->page - 2; $i <= $this->page + 3 && $i <= $this->pageNum; $i++) {
                    if ($this->page == $i) {
                        echo "<li class='active'><a href='javascript:void(0)'>{$i}</a></li>";
                    } else {
                        if ($i == $this->page + 3 && $this->page + 3 < $this->pageNum) {
                            echo "<li><a href='javascript:void(0)'>..</a></li>";
                        } else {
                            echo "<li ><a href='{$this->url}&page={$i}'>{$i}</a></li>";
                        }
                    }
                }
            }
            //=====
            if ($this->pageNum - $this->page < 3) {
                for ($i = $this->pageNum - 5; $i <= $this->pageNum; $i++) {
                    if ($this->page == $i) {
                        echo "<li class='active'><a href='javascript:void(0)'>{$i}</a></li>";
                    } else {
                        echo "<li ><a href='{$this->url}&page={$i}'>{$i}</a></li>";
                    }
                }
            }
        }
        //====
    }

    private function next()
    {
        if ($this->page >= $this->pageNum) {
            return "<li class='disabled'><a href='javascript:void(0)'>下一页</a></li>";
        } else {
            return "<li><a href='{$this->url}&page=" . ($this->page + 1) . "'>下一页</a></li>";
        }
    }

    private function goPage()
    {
        return "<input style='margin-top:-3px;text-align: center;width:50px;vertical-align: middle;' id='goPage' class='page_text' type='number'value='{$this->page}'onkeypress=\"javascript:
if(window.event) // IE
  {
  keynum = e.keyCode
  return keynum>=48&&event.keyCode<=57;
  }
else if(e.which) 
  {
  keynum = e.which;
  return keynum>=48&&event.keyCode<=57;
  }
\"
onkeydown='JavaScript:var currKey = 0, e = e || event;
                currKey = e.keyCode || e.which || e.charCode; if (currKey==13){
 var page=(this.value<1)?this.value=1:this.value;var page=(this.value>" . $this->pageNum . ")?" . $this->pageNum . ":this.value;location=\"" . $this->url . "&page=\"+page+\"\";
};'
>
 <input style='margin-top:-3px;vertical-align: middle;' class='page_btn' type='button'value='确定'onclick='Javascript:var goPage=document.getElementById(\"goPage\"); var page=(goPage.value<1)?goPage.value=1:goPage.value;
var page=(goPage.value>" . $this->pageNum . ")?" . $this->pageNum . ":goPage.value;
location=\"" . $this->url . "&page=\"+page+\"\"'>
";
    }
    public function Fpage()
    {
        echo "<ul class='pagination pagination-sm'>";
        echo "{$this->prev()}";
        echo "{$this->pagelist()}";
        echo "{$this->next()}";
        echo "<li class='disabled'>共{$this->pageNum}页</li><li><a href='javascript:void(0)'>{$this->goPage()}</a></li>";
        echo "</ul>";
    }
}