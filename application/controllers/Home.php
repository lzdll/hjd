<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
    private $redis_house_key = "admin_info_";
    /**
     * 构造方法
     *
     * @return mixed
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('home_model');
       
     
    }

    
    
	public function index()
    {
		//根据点击排行 求出最多广告
        $ad_list = $this->home_model->getOne($where);
        $homelist = array(); 
		//获取流量池金主 等其他信息
		$other_list = $this->home_model->getOtherList($where);
		//流量池金主
		$Mower = $this->home_model->getMower($where);
        //广告推广量
		$begin_time = $this->input->get('begin_time');
        $end_time = $this->input->get('end_time');
        if(empty($begin_time)){
            $begin_time = date('Y-m-d', strtotime('-7 days'));
        }
        if(empty($end_time)){
            $end_time = date('Y-m-d', time());
        }
		 $stInfo = $this->home_model->getExtensionStatices('','',$begin_time,$end_time);
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
                    $st_total += $val['st_total'];
                    $ad_total += $val['ad_total'];
                    $avgamount += $val['avgamount'];
                    $total_cpc += $val['total_cpc'];
                    $st_price += $val['st_price'];
                }
            }
		$avgamount = sprintf("%.2f",$avgamount/$sectionCount);
		$this->data['avgamount'] = $avgamount;
        $this->data['section'] = $datedata;
        $this->data['staticesCpc'] = implode(',',$staticesCpc);
        $this->data['staticesCpm'] = implode(',',$staticesCpm);
		//计算流量池
		$Finance = $this->home_model->getFinance($begin_time,$end_time);
		$day_list=$this->getDates($begin_time, $end_time);
		foreach($day_list as $val){
			$money1 =$money2='';
			foreach($Finance as $key=>$val2){
				if($val2['d'] == $val){
					$money1+=$val2['money1']/100;
					$money2+=$val2['money2']/100;
				}else{
					$money1+=0;
					$money2+=0;
				}
			}
			$m1_arr[]=$money1;
			$m2_arr[]=$money2;
		}
		//计算用户画像
		$hxiang = $this->home_model->getUsersex($begin_time,$end_time);
		//计算交易流水
		$Adprice = $this->home_model->getAdprice($begin_time,$end_time);
		foreach($day_list as $val){
			$ad_price='';
			foreach($Adprice as $key=>$vals){
				if($vals['d'] == $val){
					$ad_price+=$vals['adprice']+$vals['coprice'];
				}else{
					$ad_price+=0;
				}
			}
			$ad_rr[]=$ad_price/100;
		}
        $this->data['ad_name'] =$ad_list[0]['name'];
		$this->data['hxiang'] =$hxiang[0];
		$this->data['other_list'] =$other_list[0];
		$this->data['day_money'] =$Mower[0]['day_money']?$Mower[0]['day_money']/100:0;
		$this->data['m1_arr'] = implode(',',$m1_arr);
        $this->data['m2_arr'] = implode(',',$m2_arr);
		$this->data['ad_rr'] = implode(',',$ad_rr);
		$this->data['date'] = $this->getDateTime();
        $this->layout->view('/home/index', $this->data);
    }

   public function getDates($startdate, $enddate){
		$stimestamp = strtotime($startdate);
        $etimestamp = strtotime($enddate);
        // 计算日期段内有多少天
        $days = ($etimestamp-$stimestamp)/86400+1;
		//保存每天日期
        $str = '';
        for($i=0; $i<$days; $i++){
            $arr[]=date("Y-m-d",strtotime("-$i day"));
        }
        return $arr;
   
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
