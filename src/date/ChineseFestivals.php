<?php
namespace lij\date;
use lij\str\StringVerification as sv;
use lij\date\DateCalculation as dc;

class ChineseFestivals{
    private $data_path;
    private $date_str;
    private $status;
    private $info;
    private $format_date_str;
    private $curr_year;
    private $year_arr;
    private $month_day;
    public function __construct(){
        $this->data_path = dirname(__FILE__).'/HolidaysAndCompensatoryLeaveInChina/';
    }
    public function set_data_path($path){
        $this->date_path = $path;
    }
    public function set_date_str($date_str){
        if(empty($date_str)){
            $this->status = 0;
            $this->info = '日期参数不正确!';
        }else if(!self::check_date_str($date_str)){
            $this->status = 0;
            $this->info = '日期格式错误';
        }else{
            $this->date_str = $date_str;
            $day_time = strtotime($date_str);
            $this->curr_year = date('Y',$day_time);
            $this->month_day = date('md',$day_time);
            $this->format_date_str = date('Y-m-d',$day_time);
        }
    }
    public static function check_date_str($date_str){
        if(empty($date_str) || strlen($date_str<4)){
            return false;
        }
        $day_time = strtotime($date_str);
        if(date('Ymd',$day_time)!=$date_str && date('Y-m-d',$day_time)!=$date_str){
            return false;
        }
        return true;
    }
    public static function check_is_weekend($date_str){
        $weekend = date('N',strtotime($date_str));
        return in_array($weekend,array(6,7))?true:false;
    }
    public function get_day_info_base(){
        $this->set_year_data_file();
        $curr_year = $this->curr_year;
        $year_arr = $this->year_arr;
        $month_day = $this->month_day;
        if($year_arr){
            if(!empty($year_arr[$month_day])||sv::is_zero($year_arr[$month_day])){
                return $year_arr[$month_day];
            }else{
                return self::check_is_weekend($curr_year.$month_day)?1:0;
            }
        }else{
            return self::check_is_weekend($curr_year.$month_day)?1:0;
        }
    }
    public function get_next_week_work_days(){
        $base_date = $this->format_date_str;
        $first_date = dc::get_date_add_num($base_date,8-dc::get_date_week_num($base_date));
        $work_date_list = [];
        $work_date = $first_date;
        for($i=1;$i<8;$i++){
            $work_date = date('Y-m-d',strtotime('+1 day',strtotime($work_date)));
            $this->set_date_str($work_date);
            if(sv::is_zero($this->get_day_info_base())){
                $work_date_list[$i] = $work_date;
            }
        }
        $this->work_list = $work_date_list;
        if(count($work_date_list)==5&&empty($work_date_list[6])){
            return [
                'first_work_date' => $work_date_list[1],
                'last_work_date' => $work_date_list[5]
            ];
        }
        $keys = array_keys($work_date_list);
        for($j=count($keys);$j>0;$j--){
            if($keys[$j]-1>$keys[$j-1]){
                $last_key = $keys[$j-1];
                break;
            }
        }
        return [
            'first_work_date' => $work_date_list[$keys[0]],
            'last_work_date' => $work_date_list[$last_key?$last_key:$keys[0]]
        ];
    }
    /***
     * 简单的获取节假日情况
     * 0 普通或调休工作日  1 普通休假日  2 三倍工资节日
    */
    public function get_day_info_simple(){
        $this->set_year_data_file();
        $curr_year = $this->curr_year;
        $year_arr = $this->year_arr;
        $month_day = $this->month_day;
        if($year_arr){
            if(!empty($year_arr[$month_day])||sv::is_zero($year_arr[$month_day])){
                $this->info = $year_arr[$month_day];
            }else{
                $this->info = self::check_is_weekend($curr_year.$month_day)?1:0;
            }
        }else{
            $this->info = self::check_is_weekend($curr_year.$month_day)?1:0;
        }
        return [
            'status'=>1,
            'info'=>$this->info,
            'date'=>$this->format_date_str
        ];
    }
    /**
     * 获取一天的节假日情况
     * 1 工作日  2 调休(工作日)  3 周未  4 假日
     */
    public function get_day_info_standard(){

    }
    private function set_year_data_file(){
        $year = $this->curr_year;
        if(empty($year)){
            $year=date('Y');
        }
        $cache = [];
        $data_file = $this->data_path.$year.'_data.json';
        if(file_exists($data_file)){
            $cache[$year]=json_decode(file_get_contents($data_file),true);
            $this->year_arr = $cache[$year];
        }else{
            $this->year_arr = [
                $year=>[]
            ];
        }
    }
}