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
        $page = isset($_GET['p'])?$_GET['p']:1;   
        $filter = array();
        $search = array_intersect_key($input, $filter);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
        $offset =intval($page) > 0 ?intval($page-1)*$pagesize:0;
        $total = $this->finance_model->getCount("owner='".$this->user['user_code']."'");
        $info = $this->finance_model-> getLists($where = array('owner'=>$this->user['user_code']),$pagesize, $offset, $sort = 'created_time');
        $this->data['list'] = $info['list'];
        //分页
        if ($total > 0) {
 
           $this->data['pager'] = getPage($total,$pagesize,$page,$page_len=7,"/withdraw/index/lists");
            $this->data['pagesize'] = $pagesize;
        }
        $this->layout->view('/withdraw/lists', $this->data);
    }
    /**
     *
     */
    public function apply(){
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $where['owner'] = $this->user['user_code'];
        $accountInfo = $this->account_model->getInfo($where);
        if ($method == 'post'){
            $post = $this->input->post();
            if(bccomp($accountInfo['money'], $post['money']) === -1){
                ci_redirect('/withdraw/index/lists', 3, '提现金额大于账户金额');   
            }
            $arr['finance_code'] = $this->getCode();
            $arr['owner'] = $this->user['user_code'];
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
            }else{
                ci_redirect('/withdraw/index/lists', 3, '添加失败');                
            }
        }else{
            $this->data['accountinfo'] = $accountInfo;
            $this->layout->view('/withdraw/apply', $this->data);
        }
    }

}
