<?php
namespace Core\library;
class Excel {

    var $inEncode;


    var $outEncode;

    public function __construct($param){

    }


    public function setEncode($incode,$outcode){

        $this->inEncode=$incode;

        $this->outEncode=$outcode;

    }


    public function setTitle($titlearr){

        $title="";

        foreach($titlearr as $v){

            if($this->inEncode!=$this->outEncode){

                $title.=iconv($this->inEncode,$this->outEncode,$v)."\t";

            }

            else{

                $title.=$v."\t";

            }

        }

        $title.="\n";

        return $title;

    }


    public function setRow($array){

        $content="";

        foreach($array as $k => $v){

            foreach($v as $vs){

                if($this->inEncode!=$this->outEncode){

                    $content.=iconv($this->inEncode,$this->outEncode,$vs)."\t";

                }

                else{

                    $content.=$vs."\t";

                }

            }

            $content.="\n";

        }

        return $content;

    }


    public function downloadExcelByString($titlearr,$array,$filename=''){

        if($filename == ''){

            $filename=date("Y-m-d");

        }
        $title=$this->setTitle($titlearr);

        $content=$this->setRow($array);

        header("Content-type:application/vnd.ms-excel");

        header("Content-Disposition:filename=".$filename.".xls");

        echo $title;

        echo $content;exit;

    }


    public function downloadExcelByTable($th,$data,$filename){
        $th_str = '<tr>';
        foreach($th as $k=>$val){
            $th_str .= '<th>'.$val.'</th> ';
        }
        $th_str .= '</tr>';
        $str = "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\"\r\nxmlns:x=\"urn:schemas-microsoft-com:office:excel\"\r\nxmlns=\"http://www.w3.org/TR/REC-html40\">\r\n<head>\r\n<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">\r\n</head>\r\n<body>";
        $str .="<table border=1>".$th_str;
        //$str .= $headtitle;
        foreach ($data  as $key=> $rt )
        {
            $str .= "<tr>";
            foreach ( $rt as $k => $v )
            {
                $str .= "<td>{$v}</td>";
            }
            $str .= "</tr>\n";
        }
        $str .= "</table></body></html>";
        header( "Content-Type: application/vnd.ms-excel; name='excel'" );
        header( "Content-type: application/octet-stream" );
        header( "Content-Disposition: attachment; filename=".$filename.'.xls' );
        header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
        header( "Pragma: no-cache" );
        header( "Expires: 0" );
        exit( $str );
    }

}