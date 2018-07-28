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
		$this->load->library('Ucloud/Proxy');
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
        $data  = $this->input->get();
        $valid      = array();
        $validData  = $this->_getValidParam($data, $valid);
		$page=intval(trim($_GET['p']))?intval(trim($_GET['p'])):1;
        $urlParam   = $this->_generalUrl($validData);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
		$offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
		$where ='1 = 1 ANd id>0';
        $total = $this->wsdk_model->getCount($where);
        $list = $this->wsdk_model->findAlls($where,$pagesize,$offset);
		$page=getPage($total,$pagesize,$page,$page_len=7,"/sdk/index/lists");
		$this->data['list'] = $list;
        $this->data['total'] = $total;
        $this->data['search'] = $search;
        $this->data['pagesize'] = $pagesize;
		 //分页
        if ($total > 0) {
            $this->data['page'] = $page;
        }
		$this->layout->view('/sdk/list', $this->data);
	} 

	 /**
     * 初始化导航信息
     */
	public function cancel(){
		$data = $this->input->post();
        $res = array('status' => false, 'msg' => '');
        $id = (int) $data['id'];
        $status = $data['status'];
        $update = array();
		$where ="1 = 1 ANd id>0 and id=$id";
        $info = $this->wsdk_model->getCount($where);
        if (!$info) {
            $res['msg'] = '更新数据不存在';
            $this->_outputJSON($res);
        }
        $update['status']=$status;
		$update['updated_time']=date("Y-m-d H:i:s");
		$rUp =$this->db->where(array('id'=>$id))->update('wy_wsdk', $update);
        if ($rUp === false) {
            $res['msg'] = "更改失败";
            $this->_outputJSON($res);
        }
        $res['status'] = true;
        $this->_outputJSON($res);
	}

	/**
     * 添加
     */
    public function add()
    {
        $input = array_merge($this->input->get(), $this->input->post());
		if($input){
			$update['code'] = strtoupper(md5($this->getCode().time()));
			$update['operator'] = $this->user['code'];
			$update['name'] = $input['name'];
			$update['url'] = $input['url'];
            $update['sappid'] = $input['sappid'];
            $update['appid'] = $input['appid'];
			$update['app_secret'] = $input['app_secret'];
			$update['icon'] = $input['imgsrc'];
			$update['status']=0;
            $update['created_time'] = date("Y-m-d H:i:s");
            $update_info = $this->wsdk_model->add($update);
            if ($update_info) {
                ci_redirect('/sdk/index/lists', 3, '添加成功');
            }
            exit;
		}
		$this->layout->view('/sdk/add', $this->data);
    }
	/**
     * 图片上传
	 * 2018/7/22 liuliming
     */
	public function  setimg(){
		$targetFolder = date('Y/m/d')."/img/"; // Relative to the root
		if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];
			$newname =$this->user['code']."_".time();//图片名字
			$fileTypes = array('jpg','jpeg','gif','png','pdf'); // 文件类型
			$fileParts = pathinfo($_FILES['file']['name']);
			$size = getimagesize($tempFile);
			$width = $size[0];
			$height = $size[1];
			if($width>100 || $height>100){
					unlink($tempFile);
					$arr = array('status' => 0,'type' => $type,'msg' => "图片的宽高不符要求!" );
					echo json_encode($arr);
					exit;
			}	
			$filename = rtrim($targetFolder). $newname.'.'.$fileParts['extension'];//图片路径
			sleep(2);
			if (in_array($fileParts['extension'],$fileTypes)) {
				$filename =iconv("UTF-8","gb2312",$filename);
				$upload_file_url = $this->proxy->UploadFiles($filename,$_FILES["file"]["tmp_name"]);
				$upload_file_url = 'http://osv.ufile.ucloud.com.cn/'.$upload_file_url;
				$imgInfo['name']=$filename;
				$imgInfo['url'] =$upload_file_url;
				$imgInfo['status'] = 1;
				echo json_encode($imgInfo,true);
			}else{
				$arr = array('status' =>0,'type' => $type,'msg' => "上传文件不符合要求!" );
				echo json_encode($arr);
				exit;
			}
		}
	}
	

}
