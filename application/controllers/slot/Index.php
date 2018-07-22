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
        $this->load->library('/ucloud/proxy');
        $this->load->model('slot_model');
    }

    /**
     * 初始化导航信息
     */
    private function _initNav()
    {
        $method = $this->router->method;
        $nav = array();
        if ($method == 'index') // 列表
        {
            $nav[] = array('name' => '系统消息管理', 'url' => '');
        } else if ($method == 'lists') // 添加
        {
            $nav[] = array('name' => '广告列表', 'url' => '');
        } else if ($method == 'add') // 添加
        {
            $nav[] = array('name' => '添加广告', 'url' => '');
        }
        else if ( $method == 'edit' ) // 添加
        {
            $nav[] = array('name' => '编辑广告', 'url' => '');
        }
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
        $stInfo = $this->slot_model->getExtensionStatices($this->user['code'],'',$begin_time,$end_time);
        $datedata = $this->getDateSection($begin_time, $end_time);
        $sectionCount = count(explode(',', $datedata));
        $staticesCpc = $staticesCpm = array();
        if(!empty($stInfo)){
            foreach ($stInfo as $key =>$val){
                $staticesCpc[] = $val['cpc'] ;
                $staticesCpm[] = $val['cpm'] ;
            }
        }
        $st_total = $ad_total = $avgamount = $total_cpc = $st_price = 0;
        if(count($staticesCpm) < $sectionCount){
            $max = ($sectionCount-count($staticesCpm));
            for ($i=0;$i<$max;$i++){
                $staticesCpc[] = 0;
                $staticesCpm[] = 0;
            }
        }
        //收益统计
        $stProfit = $this->slot_model->getProfitStatices($this->user['code'],$begin_time,$end_time);
        $this->data['statices'] = $stInfo;
        $this->data['section'] = $datedata;
        $this->data['st_price'] = $st_price;
        $this->data['staticesCpc'] = implode(',',$staticesCpc);
        $this->data['staticesCpm'] = implode(',',$staticesCpm);
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

