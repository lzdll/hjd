<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {
    /**
     * 构造方法 流量主
     *
     * @return mixed
     */
    public function __construct()
    {
        parent::__construct();
        $this->_initNav();
        $this->load->library('session');
        $this->load->model('flow_model');
		$this->load->model('user_model');
		$this->load->model('advert_model');
    }
    /**
     * 初始化导航信息
     */
    private function _initNav()
    {
        $method = $this->router->method;
        $nav = array();
        if ( $method == 'lists' ) 
        {
            $nav[] = array('name' => '广告主', 'url' => '');
        }
        $this->data['nav'] = array_merge($this->data['nav'], $nav);
    }

	public function lists()
	{
       
        $input = array_merge($this->input->get(), $this->input->post());
        $page=intval(trim($this->input->get('p')))?intval(trim($this->input->get('p'))):1;
		$filter = array();
        $search = array_intersect_key($input, $filter);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 10;
		$offset =intval($page) > 0 ?intval($page-1)*$pagesize:0;
		//获取广告主 条件
        $where = $this->flow_model->conditions(array('type'=>0,'role_id'=>2));
        $total = $this->flow_model->getCount($where);
        $list = $this->flow_model->findAlls($where,$pagesize,$offset);
		foreach($list as $key=>$val){
			//获取广告数量
			$ad_where = "owner='".$val['account_code']."'";
			$ad_total = $this->flow_model->getAdCount($ad_where);
			$list[$key]['ad_total'] = $ad_total?$ad_total:0;
			//获取充值次数
			$cz_list = $this->flow_model->getFinaCount($val);
			$list[$key]['cz_total'] = $cz_list['total']?$cz_list['total']:0;
			$list[$key]['cz_money'] = $cz_list['cz_money']?$cz_list['cz_money']:0;
			$list[$key]['sy_money'] = $cz_list['cz_money']-$cz_list['tx_money'];

		}
		$page=getPage($total,$pagesize,$page,$page_len=7,"/advertiser/index/lists");
		//充值总额 余额总额
		$Account = $this->flow_model->getAccount($where ='1 = 1 ANd id>0');

        $this->data['list'] = $list;
        $this->data['total'] = $total;
		$this->data['account'] = $Account;
        $this->data['search'] = $search;
        $this->data['pagesize'] = $pagesize;
        //分页
        if ($total > 0) {
            $this->data['page'] = $page;
        }
		$this->layout->view('/advertiser/list', $this->data);
	} 
	public function details()
	{
        $input = array_merge($this->input->get(), $this->input->post());
		$page=intval(trim($_GET['p']))?intval(trim($_GET['p'])):1;
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
		$offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
		//获取用户信息
		$user_where['id']=$input['id'];
		$user_where['user_code']=$input['code'];
        $user_info = $this->user_model->getInfo($user_where);
		//获取广告数量
		$ad_where = "owner='".$user_info['user_code']."'";
		$ad_total = $this->flow_model->getAdCount($ad_where);
		$ad_total = $ad_total?$ad_total:0;
		//获取充值次数
		$cz_list = $this->flow_model->getFinaCount(array('code'=>$user_info['user_code']));
		$list['cz_money'] = $cz_list['cz_money']?$cz_list['cz_money']:0;
		$list['sy_money'] = $cz_list['cz_money']-$cz_list['tx_money'];
		//广告推广量
		if(empty($begin_time)){
            $begin_time = date('Y-m-d', strtotime('-7 days'));
        }
        if(empty($end_time)){
            $end_time = date('Y-m-d', time());
        }
		$weekarray=array("日","一","二","三","四","五","六"); //先定义一个数组
		$day_list=getDates($begin_time, $end_time);
		foreach($day_list as $v){
			$week_arr[]="'周".$weekarray[date("w",strtotime($v))]."'";
		}
		$stInfo = $this->flow_model->getExtensionStatices($user_info['user_code'],$begin_time,$end_time);
        $datedata = getDateSection($begin_time, $end_time);
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
		$this->data['week_arr'] = implode(',',$week_arr);
        $this->data['staticesCpc'] = implode(',',$staticesCpc);
        $this->data['staticesCpm'] = implode(',',$staticesCpm);
		//计算交易流水
		$Adprice = $this->flow_model->getAdprice($user_info['user_code'],$begin_time,$end_time);
		foreach($day_list as $val){
			$ad_price='';
			foreach($Adprice as $key=>$vals){
				if($vals['d'] == $val){
					$ad_price+=$vals['adprice']+$vals['coprice'];
				}else{
					$ad_price+=0;
				}
			}
			$ad_rr[]=$ad_price?$ad_price:0;
		}
		$list2 = $this->flow_model->findAdAlls(array("user_code"=>$user_info['user_code']),$pagesize,$offset);
		foreach($list2 as $key=>$val){
			//获取CPM
			$cpm = $this->advert_model->getCpm($val);
			$list2[$key]['cmp_price'] = $cpm['cmp_price']?$cpm['cmp_price']:0;
			$sdk_info = $this->advert_model->getBaingInfo(array('code'=>$val['code']));
			$list2[$key]['sdk_name'] = $sdk_info[0]['name']?$sdk_info[0]['name']:'';
			

		}
        $this->data['list2'] = $list2;
        $this->data['list'] = $list;
        $this->data['total'] = $total;
		$this->data['ad_total'] = $ad_total?$ad_total:0;
        $this->data['code'] = trim($input['code']);
		$this->data['ad_rr'] = implode(',',$ad_rr);
        $this->data['user_info'] = $user_info;
        //分页
        if ($total > 0) {
            $page = getPage($total,$pagesize,$page,$page_len=7,"/myad/index/lists");
            $this->data['page'] = $page;
        }
		$this->layout->view('/advertiser/details', $this->data);
	} 

	public function resetpwd()
	{
        $input = array_merge($this->input->get(), $this->input->post());
		if($this->input->post()){
			$id=intval($input['id']);
			$update['password'] = gen_pwd(trim($input['password']));
            $update['updated_time'] = date("Y-m-d H:i:s");
            $update_info = $this->user_model->edit($id,$update);
            if ($update_info) {
                ci_redirect('/advertiser/index/lists', 3, '重置成功');
            }
            exit;
		}
		$this->data['code']=$input['code'];
		$this->data['id']=$input['id'];
		$this->data['type']=$input['type'];
		$this->layout->view('/advertiser/resetpwd', $this->data);
	}


	/**
     * 修改千人展示价
     */
	public function credit(){
		$data = $this->input->post();
        $res = array('status' => false, 'msg' => '');
        $update = array();
		//判断是否存在
		$where ="1 = 1 ANd id>0 AND owner='".$data['code']."'";
		$Account = $this->flow_model->getAccountId($where);
        if ($Account['id']) {//存在更新
            $update['credit']=$data['credit']*100;
			$rUp =$this->db->where(array('owner'=>$data['code']))->update('wy_account', $update);
        }else{//不存在 插入
			$res['msg'] = "数据不存在";
            $this->_outputJSON($res);
			exit;
		}
        if ($rUp === false) {
            $res['msg'] = "更改失败";
            $this->_outputJSON($res);
        }
        $res['status'] = true;
        $this->_outputJSON($res);
	}
	

}
