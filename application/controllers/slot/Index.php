<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller
{

    /**
     * 构造方法
     *
     * @return mixed
     */
    public function __construct()
    {
        parent::__construct();
        $this->_initNav();
        $this->load->library('session');
        $this->load->model('slot_model');
        $this->load->model('account_model');
    }

    /**
     * 初始化导航信息
     */
    private function _initNav()
    {
        $method = $this->router->method;
        $nav = array();
        $this->data['nav'] = array_merge($this->data['nav'], $nav);
    }

    /**
     * 客户数据首页
     */
    public function index()
    {
        $begin_time = $this->input->get('begin_time');
        $end_time = $this->input->get('end_time');
        if(empty($begin_time)){
            $begin_time = date('Y-m-d', strtotime('-7 days'));
        }
        if(empty($end_time)){
            $end_time = date('Y-m-d', time());
        }
        //广告推广量统计
        $stInfo = $this->slot_model->getExtensionStatices($this->user['user_code'],'',$begin_time,$end_time);
        $datedata = $this->getDateSection($begin_time, $end_time);
        $sectionCount = count(explode(',', $datedata));
        $staticesCpc = $staticesCpm = $staticesStPrice = array();
        if(!empty($stInfo)){
            foreach ($stInfo as $key =>$val){
                $staticesCpc[] = $val['cpc'] ;
                $staticesCpm[] = $val['cpm'] ;
                $staticesStPrice[] = $val['st_price'] ;
            }
        }
        $st_total = $ad_total = $avgamount = $total_cpc = $st_price = 0;
        if(count($staticesCpm) < $sectionCount){
            $max = ($sectionCount-count($staticesCpm));
            for ($i=0;$i<$max;$i++){
                $staticesCpc[] = 0;
                $staticesCpm[] = 0;
                $staticesStPrice[] = 0;
            }
        }
        //收益统计
        $stProfit = $this->slot_model->getProfitStatices($this->user['user_code'],$begin_time,$end_time);
        //总收益
        $account = $this->account_model->getInfo(array('owner'=>$this->user['user_code']));
        //今日收益
        $todayProfit = $this->account_model->getTodayProfit($this->user['user_code'],$this->user['type']);
        $this->data['accountinfo'] = $account;
        $this->data['todayProfit'] = $todayProfit[0];
        $this->data['statices'] = $stInfo;
        $this->data['section'] = $datedata;
        $this->data['st_price'] = $st_price;
        $this->data['staticesCpc'] = implode(',',$staticesCpc);
        $this->data['staticesCpm'] = implode(',',$staticesCpm);
        $this->data['staticesStPrice'] = implode(',',$staticesStPrice);
        $this->data['date'] = $this->getDateTime();
        $this->layout->view('/slot/index', $this->data);
    }
    private function getDateSection($startdate, $enddate){
        
        $stimestamp = strtotime($startdate);
        $etimestamp = strtotime($enddate);
        // 计算日期段内有多少天
        $days = ($etimestamp-$stimestamp)/86400+1;
        // 保存每天日期
        $str = '';
        for($i=0; $i<$days; $i++){
            $str .= "'".date('n.j', $stimestamp+(86400*$i))."',";
        }
        return mb_substr($str, 0,-1);
    }
    private function getDateTime(){
        $date['today']['begin_date'] = date("Y-m-d");
        $date['today']['end_date'] = date("Y-m-d",strtotime("+1 day"));
        $date['yesterday']['begin_date'] = date("Y-m-d",strtotime("-1 day"));
        $date['yesterday']['end_date'] = date("Y-m-d");
        $date['week']['begin_date'] = date("Y-m-d",strtotime("-1 week"));
        $date['week']['end_date'] = date("Y-m-d");
        $date['month']['begin_date'] = date("Y-m-01");
        $date['month']['end_date'] = date("Y-m-d");
        
        return $date; 
    }
}

