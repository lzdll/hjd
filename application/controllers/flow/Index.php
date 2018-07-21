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
            $nav[] = array('name' => '流量主', 'url' => '');
        }
        $this->data['nav'] = array_merge($this->data['nav'], $nav);
    }

	public function lists()
	{
        $this->data['nav'] = array_merge($this->data['nav'], array(
            array('name' => '意见反馈', 'url' => '')
        ));
        $input = array_merge($this->input->get(), $this->input->post());
		$filter = array();
        $search = array_intersect_key($input, $filter);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
		$offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
		//获取流量主 条件
        $where = $this->flow_model->conditions(array('type'=>1,'role_id'=>3));
        $total = $this->flow_model->getCount($where);
        $list = $this->flow_model->findAlls($where,$pagesize,$offset);
		foreach($list as $key=>$val){
			//获取广告数量
			$ad_where = "owner='".$val['code']."'";
			$ad_total = $this->flow_model->getAdCount($ad_where);
			$list[$key]['ad_total'] = $ad_total?$ad_total:0;
		}
        $this->data['list'] = $list;
        $this->data['total'] = $total;
        $this->data['search'] = $search;
        $this->data['pagesize'] = $pagesize;
        //分页
        if ($total > 0) {
            $query_str = http_build_query($search);
            $this->data['pager'] = page($query_str, $total, $pagesize);
        }
		$this->layout->view('/flow/list', $this->data);
	} 
	public function details()
	{
        $this->data['nav'] = array_merge($this->data['nav'], array(
            array('name' => '意见反馈', 'url' => '')
        ));
        $input = array_merge($this->input->get(), $this->input->post());
		$filter = array();
        $search = array_intersect_key($input, $filter);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
		$offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
		//获取流量主 条件
        $where = $this->flow_model->conditions(array('type'=>1,'role_id'=>3));
        $total = $this->flow_model->getCount($where);
        $list = $this->flow_model->findAlls($where,$pagesize,$offset);
		foreach($list as $key=>$val){
			//获取广告数量
			$ad_where = "owner='".$val['code']."'";
			$ad_total = $this->flow_model->getAdCount($ad_where);
			$list[$key]['ad_total'] = $ad_total?$ad_total:0;
		}
        $this->data['list'] = $list;
        $this->data['total'] = $total;
        $this->data['search'] = $search;
        $this->data['pagesize'] = $pagesize;
        //分页
        if ($total > 0) {
            $query_str = http_build_query($search);
            $this->data['pager'] = page($query_str, $total, $pagesize);
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
	

}
