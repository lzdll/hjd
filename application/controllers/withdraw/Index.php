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
        $this->load->model('audit_model');
		$this->load->model('invoice_model');
		$this->load->model('finance_model');
		$this->load->model('account_model');
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
            $nav[] = array('name' => '财务', 'url' => '');
        }
        $this->data['nav'] = array_merge($this->data['nav'], $nav);
    }
	
    public function lists(){
        $input = array_merge($this->input->get(), $this->input->post());
        $filter = array();
        $search = array_intersect_key($input, $filter);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
        $offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
        $total = $this->finance_model->getCount("owner='".$this->user['code']."'");
        $info = $this->finance_model-> getLists($where = array('owner'=>$this->user['code']),$pagesize, $offset, $sort = 'created_time');
        $this->data['list'] = $info['list'];
        //分页
        if ($total > 0) {
            $query_str = http_build_query($search);
            $this->data['search'] = $search;
            $this->data['pager'] = page($query_str, $total, $pagesize);
            $this->data['pagesize'] = $pagesize;
        }
        $this->layout->view('/withdraw/lists', $this->data);
    }
    /**
     *
     */
    public function apply(){
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if ($method == 'post'){
            $post = $this->input->post();
            $arr['code'] = md5($this->user['code'].time().rand(0,10000));
            $arr['owner'] = $this->user['code'];
            $arr['subject'] = 0;
            $arr['money'] = $post['money'];
            $arr['bank'] = $post['bank_name'];
            $arr['cardid'] = $post['bank_card'];
            $arr['tradid'] = 'W'.date('YmdHis').rand(100000,999999);
            $arr['comment'] = $post['remarks'];
            $arr['status'] = 0;
            $arr['created_time'] = date('Y-m-d H:i:s');
            $arr['updated_time'] = date('Y-m-d H:i:s');
            $res = $this->finance_model->add($arr);
            if($res){
                ci_redirect('/withdraw/index/lists', 3, '添加成功');
            }
        }else{
            $where['owner'] = $this->user['code'];
            $accountInfo = $this->account_model->getInfo($where);
            $this->data['accountinfo'] = $accountInfo;
            $this->layout->view('/withdraw/apply', $this->data);
        }
    }

}
