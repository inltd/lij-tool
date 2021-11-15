<?php
namespace Web\Dingding;

class Dingding
{
    private $appid;

    public function __construct($app_id)
    {
        $this->app_id = $app_id;
    }

    public function send_msg(){
        echo "发送消息!";
    }

}