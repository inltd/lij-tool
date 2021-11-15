<?php
namespace Lij\Arr;
// use Lij\Arr\TypeCheck

class TypeCheck{
    /**
     * 数组类型判断
    */
    public static function is_dict($arr){
        //return array_keys($arr) !== range(0,count($arr)-1);
        if(!is_array($arr)) return false;
        $ak = array_keys($arr);
        foreach($ak as $k){
            if(is_numeric($k)) return false;
        }
        return true;
    }
    public static function is_list($arr){
        if(!is_array($arr)) return false;
        return array_keys($arr) === range(0,count($arr)-1);
    }
    public static function is_mix_arr($arr){
        if(!is_array($arr)) return false;
        return self::is_dict($arr)||self::is_list($arr)?false:true;
    }
    /**
     * 一维字典
    */
    public static function is_odarr($arr){
        if(!self::is_dict($arr)) return false;
        foreach ($arr as $v){
            if(!is_numeric($v)&&!is_string($v)&&!is_bool($v)&&!is_null($v)) return false;
        }
        return true;
    }
    /**
     * 一维字典组成的数组
    */
    public static function is_odlistbydict($arr){
        if(!self::is_list($arr)) return false;
        foreach ($arr as $v){
            if(!self::is_odarr($v)) return false;
        }
        return true;
    }
    /**
     * 二维列表
    */
    public static function is_tdlist($arr){
        if(!self::is_list($arr)) return false;
        foreach ($arr as $v){
            if(!self::is_list($v)) return false;
        }
        return true;
    }
}


?>