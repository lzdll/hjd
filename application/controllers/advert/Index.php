<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {
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
        $this->load->model('advert_model');
		$this->load->model('wsdk_model');
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
		$filter = array();
        $search = array_intersect_key($input, $filter);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
		$offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
		//获取广告数量总数
		$advert_num = $this->advert_model->getAdCount($where);
		//获取消耗金额
		$consume = $this->advert_model->getConsume($where);
        $where = $this->advert_model->conditions($where);
        $total = $this->advert_model->getCount($where);
        $list = $this->advert_model->findAlls($where,$pagesize,$offset);
		foreach($list as $key=>$val){
			//获取CPM
			$cpm = $this->advert_model->getCpm($val);
			$list[$key]['cmp_price'] = $cpm['cmp_price']?$cpm['cmp_price']/100:0;
			$sdk_info = $this->advert_model->getBaingInfo(array('code'=>$val['code']));
			$list[$key]['sdk_name'] = $sdk_info[0]['name']?$sdk_info[0]['name']:'';
			

		}
        $this->data['list'] = $list;
        $this->data['total'] = $total;
        $this->data['advert_num'] = $advert_num;
		$this->data['consume'] = $consume;
        $this->data['pagesize'] = $pagesize;
        //分页
        if ($total > 0) {
            $query_str = http_build_query($search);
            $this->data['pager'] = page($query_str, $total, $pagesize);
        }
		$this->layout->view('/advert/list', $this->data);
	} 
	
	/**
     * 修改千人展示价
     */
	public function editcmp(){
		$data = $this->input->post();
        $res = array('status' => false, 'msg' => '');
        $update = array();
		$cpm = $this->advert_model->getCpm($data);
        if ($cpm) {//存在更新
            $update['price']=$data['cmp_price'];
			$update['status']=0;
			$update['created_time']=date("Y-m-d H:i:s");
			$rUp =$this->db->where(array('user_code'=>$data['owner'],'ad_code'=>$data['code'],'type'=>1))->update('wy_ad_price', $update);
        }else{//不存在 插入
			$update['user_code']=$data['owner'];
			$update['ad_code']=$data['code'];
			$update['type']=1;
			$update['code']=get_code($data['owner']);
			$update['price']=$data['cmp_price'];
			$update['status']=0;
			$update['created_time']=date("Y-m-d H:i:s");
			$rUp =$this->db->insert('wy_ad_price', $update);
		}
        if ($rUp === false) {
            $res['msg'] = "更改失败";
            $this->_outputJSON($res);
        }
        $res['status'] = true;
        $this->_outputJSON($res);
	}

	public function binding()
	{
        if ($post = $this->input->post()){
            $sdk_code_arr = explode(',',$post['sdk_code']);
			foreach($post['sdk_code'] as $val){
				$update['ad_code']=$post['ad_code'];
				$update['type']=1;
				$update['sdk_code']=trim($val);
				$update['status']=1;
				$update['create_time']=date("Y-m-d H:i:s");
				$rUp =$this->db->insert('wy_ad_record', $update);
			}
            if($rUp){
                ci_redirect('/advert/index/lists', 3, '添加成功');
            }
			exit;
        }
        $data  = $this->input->get();
        $valid      = array();
        $validData  = $this->_getValidParam($data, $valid);
        $urlParam   = $this->_generalUrl($validData);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
		$offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
		$where ='1 = 1 ANd id>0';
        $total = $this->wsdk_model->getCount($where);
        $list = $this->wsdk_model->findAlls($where,$pagesize,$offset);
		$this->data['list'] = $list;
        $this->data['total'] = $total;
        $this->data['search'] = $search;
        $this->data['pagesize'] = $pagesize;
		$this->data['ad_code'] = $data['code'];
		//分页
        if ($total > 0) {
            $query_str = http_build_query($search);
            $this->data['pager'] = page($query_str, $total, $pagesize);
        }
		$this->layout->view('/advert/binding', $this->data);
	} 
	
	/**
     * 操作状态
     */
	public function online(){
		$data = $this->input->post();
        $res = array('status' => false, 'msg' => '');
        $id = (int) $data['id'];
        $status = $data['status'];
        $update = array();
        if (!$id) {
            $res['msg'] = '更新数据不存在';
            $this->_outputJSON($res);
        }
        $update['status']=1;
		$update['updated_time']=date("Y-m-d H:i:s");
		$res =$this->db->where(array('id'=>$id))->update('wy_ad', $update);
        if ($res === false) {
            $res['msg'] = "更改失败";
            $this->_outputJSON($res);
        }
        $res['status'] = true;
        $this->_outputJSON($res);
	}

	//广告详情
	public function details()
	{
        $input = array_merge($this->input->get(), $this->input->post());
		//获取消耗金额
        $list = $this->advert_model->findOne($input);
		$id = (int)$this->input->get('id');
		$begin_time = $this->input->get('begin_time');
        $end_time = $this->input->get('end_time');
        $info = $this->advert_model->findByPk($id);
	
        if(empty($begin_time)){
            $begin_time = date('Y-m-d', strtotime('-7 days'));
        }
        if(empty($end_time)){
            $end_time = date('Y-m-d', time());
        }
        if ($info)
        {
            $stInfo = $this->advert_model->getExtensionStatices($info['code'],$id,$begin_time,$end_time);
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
		}
        else
            ci_redirect('/advert/details', 3, 'ID错误或信息不存在');

        $this->data['list'] = $list[0];
		$this->data['id'] = $id;
		$this->data['code'] = $input['code'];
        $this->data['info'] = $info;
		$this->data['avgamount'] = $avgamount;
        $this->data['statices'] = $stInfo;
        $this->data['section'] = $datedata;
        $this->data['st_price'] = $st_price;
        $this->data['staticesCpc'] = implode(',',$staticesCpc);
        $this->data['staticesCpm'] = implode(',',$staticesCpm);
        $this->data['date'] = $this->getDateTime();
		$this->layout->view('/advert/details', $this->data);
	} 

	//广告详情
	public function adopt()
	{
        $input = array_merge($this->input->get(), $this->input->post());
        $list = $this->advert_model->getOnead($input);
		$price_list = $this->advert_model->getOnePrice($input);
		//判断cmp价格
		foreach($price_list as $val){
			if($val['type'] == 1){
				$list['cmp_price'] = $val['price']?$val['price']/100:0;
			}else if($val['type'] == 0){
				$list['price'] = $val['price']?$val['price']/100:0;
			}
		}
        $this->data['list'] = $list;
		$this->layout->view('/advert/adopt', $this->data);
	} 

	//广告审核
	public function adopts()
	{
        $data = array_merge($this->input->get(), $this->input->post());
		$id = (int) $data['id'];
		if(!$id){
			ci_redirect('/advert/index/lists', 3, '参数不对');
			exit;
		}
        $update = array();
        $update['audit_status']=1;
		$update['updated_time']=date("Y-m-d H:i:s");
		$res =$this->db->where(array('id'=>$id))->update('wy_ad', $update);
        if($res){
                ci_redirect('/advert/index/lists', 3, '通过审核');
        }
		exit;
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
