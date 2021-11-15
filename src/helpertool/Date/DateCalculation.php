<?php
namespace Lij\Date;

/**
 * 日期计算工具类
*/
class DateCalculation{
	/**
	 * 计算两个日期的差,返回年,月,日的数组
	*/
    public static function date_subtraction($date1,$date2){
    	if(strtotime($date1)>strtotime($date2)){
    		$tmp=$date2;
    		$date2=$date1;
    		$date1=$tmp;
    	}
    	list($Y1,$m1,$d1)=explode('-',$date1);
    	list($Y2,$m2,$d2)=explode('-',$date2);
    	$Y=$Y2-$Y1;
    	$m=$m2-$m1;
    	$d=$d2-$d1;
    	if($d<0){
    		$d+=(int)date('t',strtotime("-1 month $date2"));
    		$m--;
    	}
    	if($m<0){
    		$m+=12;
    		$Y--;
    	}
    	return array('year'=>$Y,'month'=>$m,'day'=>$d);
    }
	/**
	 * 根据身份证号码获取年龄
	*/
    public static function get_age_from_id_number($idcard){
        if(!preg_match("/^[1-9][0-9]{16}[0-9Xx]$/i",$idcard)){
            return 0;
        }
        $birth_Date = strtotime(substr($idcard, 6, 8));
        $birth_Date = date('Y-m-d',$birth_Date);
        $age = self::date_subtraction($birth_Date,date('Y-m-d'))["year"];
        return $age;
    }
	public static function get_date_add_num($datestr,$num){
		$n = (int)$num<0?(int)$num:'+'.(int)$num;
		return date('Y-m-d',strtotime($n.' day',strtotime($datestr)));
	}
	public static function get_date_week_num($datestr){
		return date('w',strtotime($datestr));
	}
}

?>