<?php
namespace lij\str;

/**
 * 字符串校验
*/
class StringVerification{

    public static function is_safe_query($str){
        return preg_match('/^[a-zA-Z]+$/i', $str)?true:false;
    }

    public static function is_chinese($str){
        return preg_match('/^[\u4e00-\u9fa5]+$/', $str)?true:false;
    }

    public static function is_safe_filename($str){
        return preg_match('/^[-a-zA-Z0-9\.\p{Han}_]+$/u',$str)?true:false;
    }

    public static function is_jdbh($str){
        return preg_match('/^[a-zA-Z][-a-zA-Z0-9]{9,17}$/i',$str)?true:false;
    }

    public static function is_zero($zero){
        return (string)$zero==='0'?true:false;
    }
}

?>