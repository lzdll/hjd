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
		$this->load->library('Ucloud/Proxy');
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

	public function lists()
	{
        $data  = $this->input->get();
        $valid      = array();
        $validData  = $this->_getValidParam($data, $valid);
		$page=intval(trim($_GET['p']))?intval(trim($_GET['p'])):1;
        $urlParam   = $this->_generalUrl($validData);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
		$offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
		$where ='1 = 1 ANd id>0 AND subject=1';
        $total = $this->audit_model->getCount($where);
        $list = $this->audit_model->findAlls($where,$pagesize,$offset);
		$page=getPage($total,$pagesize,$page,$page_len=7,"/finance/index/lists");
		$this->data['list'] = $list;
        $this->data['total'] = $total;
        $this->data['search'] = $search;
        $this->data['pagesize'] = $pagesize;
		//分页
        if ($total > 0) {
            $this->data['page'] = $page;
        }
		$this->layout->view('/finance/list', $this->data);
	} 
	public function invoice()
	{
        $data  = $this->input->get();
        $valid      = array();
        $validData  = $this->_getValidParam($data, $valid);
		$page=intval(trim($_GET['p']))?intval(trim($_GET['p'])):1;
        $urlParam   = $this->_generalUrl($validData);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] :10;
		$offset =intval($page) > 0 ?intval($page-1)*$pagesize:0;
		$where = $this->audit_model->conditions($search);
        $total = $this->audit_model->getInvoiceCount($where);
        $list = $this->audit_model->findInvoice($where,$pagesize,$offset);

		$page=getPage($total,$pagesize,$page,$page_len=7,"/finance/index/invoice");
		$this->data['list'] = $list;
        $this->data['total'] = $total;
        $this->data['search'] = $search;
        $this->data['pagesize'] = $pagesize;
		//分页
        if ($total > 0) {
            $this->data['page'] = $page;
        }
		$this->layout->view('/finance/invoice', $this->data);
	} 

	public function add_invoice(){
		$input = array_merge($this->input->get(), $this->input->post());
		if($input){
			$targetFolder = date('Y/m/d')."/img/"; // Relative to the root
			$newname =$this->user['user_code']."_".time();//图片名字
			$fileParts = pathinfo($_FILES['file']['name']);
			$filename = rtrim($targetFolder). $newname.'.'.$fileParts['extension'];//图片路径
			$filename =iconv("UTF-8","gb2312",$filename);
			$upload_file_url = $this->proxy->UploadFiles($filename,$_FILES["file"]["tmp_name"]);
			$upload_file_url = 'http://osv.ufile.ucloud.com.cn/'.$upload_file_url;
			$id=$input['id'];
			$update['status'] = 1;
			$update['img'] = $upload_file_url;
			$rUp =$this->db->where(array('id'=>$id))->update($this->db->dbprefix.'invoice', $update);
			if($rUp){
				 ci_redirect('/finance/index/invoice', 3, '添加成功');
			}else{
				 ci_redirect('/finance/index/invoice', 3, '添加失败');
			}
		}
	
	}
	public function present()
	{
        $data  = $this->input->get();
        $valid      = array();
        $validData  = $this->_getValidParam($data, $valid);
        $urlParam   = $this->_generalUrl($validData);
		$page=intval(trim($_GET['p']))?intval(trim($_GET['p'])):1;
        $urlParam   = $this->_generalUrl($validData);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] :10;
		$offset =intval($page) > 0 ?intval($page-1)*$pagesize:0;
		$where ='1 = 1 ANd id>0 AND subject=0';
        $total = $this->audit_model->getCount($where);
        $list = $this->audit_model->findAlls($where,$pagesize,$offset);
		$page=getPage($total,$pagesize,$page,$page_len=7,"/finance/index/present");
		$this->data['list'] = $list;
        $this->data['total'] = $total;
        $this->data['search'] = $search;
        $this->data['pagesize'] = $pagesize;
		//分页
        if ($total > 0) {
            $this->data['page'] = $page;
        }
		$this->layout->view('/finance/present', $this->data);
	} 

    /**
     * 添加
     */
    public function add()
    {
        $input = array_merge($this->input->get(), $this->input->post());
		if($input){
			//判断充值用户是否存在
			$sql="select * from wy_account where owner='".$input['owner']."'";
		    $query =$this->db->query($sql)->result_array();
			if(!$query){
				 ci_redirect('/finance/index/add', 3, '广告主不存在,请确认');
				 exit;
			}
		    $update['finance_code'] = $this->getCode();
			$update['operator'] = $this->user['user_code'];
			$update['owner'] = $input['owner'];
			$update['money'] =$input['money'];//转化分
			$update['subject']=1;
            $update['bank'] = $input['bank'];
            $update['cardid'] = $input['cardid'];
            $update['tradid'] = $input['tradid'];
			$update['status'] = $input['status']?$input['status']:0;
			$update['comment'] = $input['comment'];
            $update['created_time'] = date("Y-m-d H:i:s");
            $update_info = $this->audit_model->add($update);
            if ($update_info) {
				//更新用户账号金额
				$updates['money']=$query[0]['money']+$input['money'];
				$updates['updated_time']=date("Y-m-d H:i:s");
				$res =$this->db->where(array('id'=>$query[0]['id']))->update('wy_account', $updates);
                ci_redirect('/finance/index/lists', 3, '添加成功');
            }
            exit;
		}
		$list = $this->audit_model->getUserCode($where=' 1=1 AND type!=2',$pagesize,$offset);
		$this->data['list'] = $list;
		$this->layout->view('/finance/add', $this->data);
    }
	public function listrecord(){
        $page = isset($_GET['p'])?$_GET['p']:1;
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
        $offset =intval($page) > 0 ?intval($page-1)*$pagesize:0;
        $info = $this->audit_model->getList(
            $where = array(
                'owner'=>$this->user['user_code'],
                'subject'=>1,
            ),
            $limit = $pagesize, $offset = $offset, $sort = 'created_time');
        foreach ( $info['list']as &$item) {
            $item['created_time'] = date('Y-m-d',strtotime($item['created_time']));
            $item['money'] = number_format($item['money'],2,'.','');
            switch($item['status']){
                case 0: $item['status'] = '充值成功';
                    break;
                case 1: $item['status'] = '未充值';
                    break;
                default:
            }
        }
        $total = $info['cnt'];
        $this->data['list'] = $info['list'];
        //分页
        if ($total > 0) {
            $this->data['pager'] = getPage($total,$pagesize,$page,$page_len=7,"/finance/index/listrecord");

        }
        $this->layout->view('/finance/listrecord', $this->data);
    }
    public function adinvoice(){
        $page = isset($_GET['p'])?$_GET['p']:1;
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
        $offset =intval($page) > 0 ?intval($page-1)*$pagesize:0;
        $info = $this->invoice_model-> getList($where = array('owner'=>$this->user['user_code']),$limit = $pagesize, $offset = $offset, $sort = 'created_time');
        foreach ( $info['list']as &$item) {
            $item['created_time'] = date('Y-m-d',strtotime($item['created_time']));
            $item['money'] =number_format((floor($item['money'])).".".($item['money']%100),2,'.','');
        }
        $total = $info['cnt'];
        $this->data['list'] = $info['list'];
        //分页
        if ($total > 0) {
            $this->data['pager'] = getPage($total,$pagesize,$page,$page_len=7,"/finance/index/adinvoice");
            
        }
        $this->layout->view('/finance/adinvoice', $this->data);
    }
    /**
     *
     */
    public function add_adinvoice(){
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if ($method == 'post'){
            $post = $this->input->post();
            $arr['invoice_code'] = $this->getCode();
            $arr['owner'] = $this->user['user_code'];
            $arr['title'] = $post['title'];
            $arr['taxid'] = $post['invoiceid'];
            $arr['money'] = $post['amount']* 100;//转为分
            $arr['comment'] = $post['contact'];
            $arr['status'] = 0;
            $arr['created_time'] = date('Y-m-d H:i:s',time());
            $arr['updated_time'] = date('Y-m-d H:i:s',time());
            $res = $this->invoice_model->add($arr);
            if($res){
                ci_redirect('/finance/index/adinvoice', 3, '添加成功');
            }else{
                ci_redirect('/finance/index/adinvoice', 2, '添加失败');
            }

        }else{
            $this->layout->view('/finance/add_adinvoice', $this->data);
        }
    }
	/**
     * 财务备注
     */
	public function unexecuted(){
		$data = $this->input->post();
        $res = array('status' => false, 'msg' => '');
        $update = array();
		$sql="select * from wy_finance where id=".$data['id']." limit 1";
		$query =$this->db->query($sql)->result_array();
		if(!$query[0]){
			$res['msg'] = "用户数据不存在";
            $this->_outputJSON($res);
		}
		$sql="select * from wy_account where owner='".$query[0]['owner']."' limit 1";
		$query2 =$this->db->query($sql)->result_array();
		if(!$query2[0]){
			$res['msg'] = "流量主不存在";
            $this->_outputJSON($res);
		}
        if ($data) {//存在更新
			$update['operator']=$this->user['user_code'];
			$update['comment']=$data['opearea'];
			$update['status']=0;
			$update['updated_time']=date("Y-m-d H:i:s");
			$rUp =$this->db->where(array('id'=>$data['id']))->update('wy_finance', $update);
			//更新用户账号金额
			$updates['money']=$query2[0]['money']-$query[0]['money'];
			$updates['updated_time']=date("Y-m-d H:i:s");
			$res =$this->db->where(array('id'=>$query2[0]['id']))->update('wy_account', $updates);
        }
        if ($rUp === false) {
            $res['msg'] = "更改失败";
            $this->_outputJSON($res);
        }
        $res['status'] = true;
        $this->_outputJSON($res);
	}

}
