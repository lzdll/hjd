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
		$this->load->model('slot_model');
		$this->load->model('account_model');
		$this->load->model('stprice_model');
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

	public function lists()
	{
	  
        $input = array_merge($this->input->get(), $this->input->post());
        $page = isset($_GET['p'])?$_GET['p']:1;
		$filter = array();
        $search = array_intersect_key($input, $filter);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
        $offset =intval($page) > 0 ?intval($page-1)*$pagesize:0;
		//获取流量主 条件
        $where = $this->flow_model->conditions(array('type'=>1,'role_id'=>3));
        $total = $this->flow_model->getCount($where);
        $list = $this->flow_model->findAlls($where,$pagesize,$offset);
		foreach($list as $key=>$val){
			//获取广告数量
			$ad_where = "owner='".$val['user_code']."'";
			$ad_total = $this->flow_model->getAdCount($ad_where);
			$list[$key]['ad_total'] = $ad_total?$ad_total:0;
		}
        $this->data['list'] = $list;
        $this->data['total'] = $total;
        $this->data['search'] = $search;
        $this->data['pagesize'] = $pagesize;
        //分页
        if ($total > 0) {
            $this->data['pager'] = getPage($total,$pagesize,$page,$page_len=7,"/flow/index/lists");
            
        }
		$this->layout->view('/flow/list', $this->data);
	} 
	public function details()
	{
	    $page=intval(trim($_GET['p']))?intval(trim($_GET['p'])):1;
        $input = array_merge($this->input->get(), $this->input->post());
		$filter = array();
		$user_code = $this->input->get('code');
        $search = array_intersect_key($input, $filter);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
        $offset =intval($page) > 0 ?intval($page-1)*$pagesize:0;
		//获取流量主 条件
        $where = $this->flow_model->conditions(array('type'=>1,'role_id'=>3));
        $total = $this->flow_model->getCount($where);
        $list = $this->flow_model->findAlls($where,$pagesize,$offset);
        $where = array('owner'=>$this->input->get('code'));
        //流量主详情页面列表及分页，包含统计部分代码
        $slotcount = $this->slot_model->getCount($where);
        $slotlists = $this->slot_model->getDataByOwner($this->input->get('code'),$pagesize, $offset);
		foreach($list as $key=>$val){
			//获取广告数量
			$ad_where = "owner='".$val['code']."'";
			$ad_total = $this->flow_model->getAdCount($ad_where);
			$list[$key]['ad_total'] = $ad_total?$ad_total:0;
		}
		foreach ($slotlists as $skey =>$sval){
		    $slotPrice = $this->slot_model->getSlotPrice($sval['code']);
		    if($slotPrice){
		        foreach ($slotPrice as $pkey => $pval){
		            if($pval['type'] == 0){
		                $slotlists[$skey]['cpc_price'] = $pval['price']/100;
    		        }elseif($pval['type'] == 1){
    		            $slotlists[$skey]['cpm_price'] = $pval['price']/100;
    		        }
    		    }
		    }
		    if(bccomp($sval['rate'], 0) === -1 || empty($sval['rate'])){
		        $slotlists[$skey]['rate'] = 0;
		    }
		    if(!isset($slotlists[$skey]['cpm_price']) || empty($slotlists[$skey]['cpm_price'])){
		        $slotlists[$skey]['cpm_price'] = 0;
		    }
		    if(!isset($slotlists[$skey]['cpc_price']) || empty($slotlists[$skey]['cpc_price'])){
		        $slotlists[$skey]['cpc_price'] = 0;
		    }
		}
	    $begin_time = date('Y-m-d', strtotime('-7 days'));
	    $end_time = date('Y-m-d', time());
		//运营平台流量主详情页面统计图表部分代码
		$stInfo = $this->slot_model->getExtensionStatices($this->user['code'],'',$begin_time,$end_time);
		$datedata = $this->getDateSection($begin_time, $end_time);
		$sectionCount = count(explode(',', $datedata));
		$staticesCpc = $staticesCpm = array();
		$avg_cpm_price = $avgamount = 0;
		if(!empty($stInfo)){
		    foreach ($stInfo as $key =>$val){
		        $staticesCpc[] = $val['cpc'] ;
		        $staticesCpm[] = $val['cpm'] ;
		        $staticesPrice[] = $val['st_price'] ;
		        $avg_cpm_price += $val['avg_cpm_price'];
		        $avgamount += $val['avgamount'];
		    }
		}
		$st_total = $ad_total = $total_cpc = $st_price = 0;
		if(count($staticesCpm) < $sectionCount){
		    $max = ($sectionCount-count($staticesCpm));
		    for ($i=0;$i<$max;$i++){
		        $staticesCpc[] = 0;
		        $staticesCpm[] = 0;
		        $staticesPrice[] = 0 ;
		        $st_total += $val['st_total'];
		        $ad_total += $val['ad_total'];
		        $avgamount += $val['avgamount'];
		        $avg_cpm_price += $val['avg_cpm_price'];
		        $total_cpc += $val['total_cpc'];
		        $st_price += $val['st_price'];
		    }
		}
		if($sectionCount > 0){
		    $avg_cpm_price = sprintf("%.2f",$avg_cpm_price/$sectionCount);
    		$avgamount = sprintf("%.2f",$avgamount/$sectionCount);
		}else{
		    $avg_cpm_price = sprintf("%.2f",0);
    		$avgamount = sprintf("%.2f",0);		    
		}
		
		//获取用户信息
		$userinfo = $this->user_model->getInfo($where = array("code"=>$user_code));
		//获取账户信息
		$accountinfo = $this->account_model->getInfo($where = array("code"=>$user_code));
		
		//分页
		if ($total > 0) {
		    $this->data['pager'] =  getPage($total,$pagesize,$page,$page_len=7,"/flow/index/details");
		}
		
		$this->data['id'] = $this->input->get('id');
		$this->data['code'] = $this->input->get('code');
		$this->data['type'] = $this->input->get('type');
        $this->data['list'] = $list;
        $this->data['total'] = $total;
        $this->data['search'] = $search;
        $this->data['pagesize'] = $pagesize;
        $this->data['slotcount'] = $slotcount;
        $this->data['slotlists'] = $slotlists;
        $this->data['userinfo'] = $userinfo;
        $this->data['accountinfo'] = $accountinfo;
        $this->data['user_code'] = $user_code;
        $this->data['avg_cpm_price'] = $avg_cpm_price;
        $this->data['avgamount'] = $avgamount;
        $this->data['section'] = $datedata;
        $this->data['staticesCpc'] = implode(',',$staticesCpc);
        $this->data['staticesCpm'] = implode(',',$staticesCpm);
        $this->data['staticesPrice'] = implode(',',$staticesPrice);
        //分页
        if ($total > 0) {
            $this->data['pager'] =  getPage($total,$pagesize,$page,$page_len=7,"/flow/index/details");
        }
		$this->layout->view('/flow/details', $this->data);
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
                ci_redirect('/flow/index/lists', 3, '重置成功');
            }
            exit;
		}
		$this->data['code']=$input['code'];
		$this->data['id']=$input['id'];
		$this->data['type']=$input['type'];
		$this->layout->view('/flow/resetpwd', $this->data);
	} 
	public function updateslotprice(){
	    $param = $this->input->post('param');
	    $param = explode('_', $param);
	    $st_id = $param[0];
	    $status = $param[1];
	    if($status == 0){
	        $status = 1;
	    }elseif($status == 1){
	        $status = 0;
	    }
	    $result = $this->slot_model->edit($st_id, array('status'=>$status));
	    if ($result === false) {
	        $res['msg'] = "更改失败";
	        $this->_outputJSON($res);
	    }
	    $res['status'] = true;
	    $this->_outputJSON($res);
	}
	public function sealoff(){
	    $user_id = $this->input->post('user_id');
	    if(isset($user_id) && !empty($user_id)){
	        $status = $this->user_model->edit($user_id,array('status' => 1));
	        if ($result === false) {
	            $res['msg'] = "更改失败";
	            $this->_outputJSON($res);
	        }
	        $res['status'] = true;
	        $this->_outputJSON($res);
	    }else{
	        $res['msg'] = "更改失败";
	        $this->_outputJSON($res);
	    }
	}
	public function setslotmoney(){
	    $type = $this->input->post('type');
	    $money = $this->input->post('money');
	    $user_code = $this->input->post('user_code');
	    $st_code = $this->input->post('st_code');
	    $type = $type == 'cpc'?0:1;
	    if(!empty($st_code) &&!empty($st_code) && !empty($money)){
	        $sets = array('status'=>1);
	        $where = array('type'=>$type,'user_code'=>$user_code,'st_code'=>$st_code);
	        $status = $this->stprice_model->updateslotprice($sets,$where);
	        if(!$status){
	            $res['msg'] = "更改失败";
	            $this->_outputJSON($res);
	        }
	        $data['user_code'] = $user_code;
	        $data['st_code'] = $st_code;
	        $data['type'] = $type;
	        $data['code'] = md5($this->getCode().time().rand(0,10000));
	        $data['price'] = $money;
	        $data['status'] = 0;
	        $data['created_time'] = date('Y-m-d');
	        $result = $this->stprice_model->add($data);
	        if ($result === false) {
	            $res['msg'] = "更改失败";
	            $this->_outputJSON($res);
	        }
	        $res['status'] = true;
	        $this->_outputJSON($res);
	    }else{
	        $res['msg'] = "更改失败";
	        $this->_outputJSON($res);
	    }
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
}
