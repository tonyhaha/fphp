<?php
namespace Core\library;

class Pagination
{

    protected $_page_max = 0;
    protected $_total = 0;
    protected $_limit = 10;
    protected $_p = 'page';
    protected $_split = '';

    public function __construct($param)
    {

    }

    public function show($total, $limit)
    {
        $this->_page_max = ceil($total / $limit);
        $this->_total = $total;
        $this->_limit = $limit;

        $page_max = $this->_page_max;
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?',$url);
        $url = $url[0];
        $param = $this->_getParam();

        $p = isset($_GET[$this->_p]) ? intval($_GET[$this->_p]) : 1;
        $p = $p < 1 ? 1 : $p;
        $p = $p > $page_max ? $page_max : $p;

        $html = '<style>
            div.php_page{
                font-family:\'微软雅黑\';
                font-size:14px;
                margin-bottom: 20px;
            }
            div.php_page a{
                color:#666666;
                text-decoration:none;
                border:1px solid #e1e2e3;
                padding:5px 10px;
                margin:0 3px;
            }

            div.php_page .php_page_current{
                padding:5px 10px;
                margin:0 3px;
                border:1px solid #428bca;
                font-weight:bold;
                color:gray;
            }

            div.php_page .php_page_info{
                margin:0 0 0 10px;
            }
            </style><div class="php_page" >';

        if ($p > 1) {
            $last_page = $p - 1;
            $html .= "<a href='$url?{$this->_p}=$last_page{$param}'>上页</a>";
            $html .= $this->_split;
        }

        if ($p == 1) {
            $html .= '<span class="php_page_current">1</span>';
        } else {
            $html .= "<a href='$url?{$this->_p}=1{$param}'>1</a>";
        }
        $html .= $this->_split;

        $start = $this->_getStart($p);
        $end = $this->_getEnd($p);

        if ($start > 2) {
            $html .= '...';
            $html .= $this->_split;
        }

        for ($i = $start; $i <= $end; $i++) {
            if ($p == $i) {
                $html .= "<span class='php_page_current'>" . $i . '</span>';
            } else {
                $html .= "<a href='$url?{$this->_p}={$i}{$param}'>" . $i . '</a>';
            }
            $html .= $this->_split;
        }
        if ($end < $page_max - 1) {
            $html .= '...';
            $html .= $this->_split;
        }

        if ($page_max > 1) {
            /*if ($p == $page_max) {
                echo "<span class='php_page_current'>$page_max</span>";
            } else {
                echo "<a href='$url?{$this->_p}={$page_max}{$param}'>$page_max</a>";
            }*/
            $html .= $this->_split;
        }

        if ($p < $page_max) {
            $next_page = $p + 1;
            $html .= "<a href='$url?{$this->_p}=$next_page{$param}'>下页</a>";
            $html .= $this->_split;
        }

        $html .= '<span class="php_page_info">';
        $html .= $this->_total . ' 条数据,当前第 ' . $p . ' 页,共 ' . $page_max . ' 页';
        $html .= '</span>';

        $html .= '</div>';
        return $html;
    }

    public function setP($val)
    {
        $this->_p = $val;
    }

    private function _getStart($p)
    {
        if ($p < 9) {
            return 2;
        } else {
            return $p > $this->_page_max - 8 ? $this->_page_max - 8 : $p;
        }
    }

    private function _getEnd($p)
    {
        $start = $this->_getStart($p);
        if ($p < 9) {
            $end = 9;
            return $end > $this->_page_max - 1 ? $this->_page_max - 1 : $end;
        } else {
            $end = $p + 7;
            return $end > $this->_page_max - 1 ? $this->_page_max - 1 : $end;
        }
    }

    private function _getParam()
    {
        $query_str = $_SERVER['QUERY_STRING'];
        if (!$query_str) {
            return '';
        }
        $query_arr = explode('&', $query_str);

        $param_arr = array();
        foreach ($query_arr as $query_item) {
            $item = explode('=', $query_item);
            $key = $item[0];
            $value = $item[1];
            $param_arr[$key] = $key . '=' . $value;
        }

        unset($param_arr[$this->_p]);
        if (empty($param_arr)) {
            return '';
        }
        $param = implode('&', $param_arr);
        return '&' . $param;
    }
}

?>