<?php
namespace Lij\Str;

/**
 * 字符串转换
*/
class StringConversion{
    public static function to_safe_query($str){
        return preg_match('/^.+$/',$str)?preg_replace('/[^a-zA-Z]/','',$str):false;
    }
    public static function only_chinese($str){
        return preg_match('/^.+$/',$str)?preg_replace('/[^\u4e00-\u9fa5]/','',$str):false;
    }
    public static function to_safe_filename($str){
        return preg_match('/^.+$/',$str)?preg_replace('/[^-a-zA-Z0-9\.\p{Han}]/u','_',$str):false;
    }
}

?>