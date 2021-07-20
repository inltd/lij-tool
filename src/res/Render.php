<?php
namespace lij\res;

class Render{
    private $res_data;

    public function __construct($arr){
        if(is_array($arr)){
            $this->res_data = $arr;
        }else{
            $this->res_data = [
                'status' => 1,
                'data' => (string)$arr
            ];
        }
    }

    public function ajaxReturn(){
        $array = $this->res_data;
        if(!$array){
            $array = ["status" => 0];
        }
        $content=json_encode($array,JSON_UNESCAPED_UNICODE);
        if(empty($_GET['callback'])){
            echo $content;exit;
        }else{
            echo $_GET['callback']."(".$content.")";exit;
        }
    }
}