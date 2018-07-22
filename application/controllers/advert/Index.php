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
            $update['price']=$data['cmp_price']*100;
			$update['status']=0;
			$update['created_time']=date("Y-m-d H:i:s");
			$rUp =$this->db->where(array('user_code'=>$data['owner'],'ad_code'=>$data['code'],'type'=>1))->update('wy_ad_price', $update);
        }else{//不存在 插入
			$update['user_code']=$data['owner'];
			$update['ad_code']=$data['code'];
			$update['type']=1;
			$update['code']=get_code($data['owner']);
			$update['price']=$data['cmp_price']*100;
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

}
