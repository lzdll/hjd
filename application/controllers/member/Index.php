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
        $this->load->model('company_model');
        $this->load->model('advertiser_model');

        //$this->load->model('plugin_building_model');
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
        //判断上传文件类型为png或jpg且大小不超过1024000B
        if($this->input->post()){
            $form = $this->input->post();
            if($form['type'] == 1){
                    unset($_FILES['imgsrc5']);
                    unset($_FILES['imgsrc4']);

            }else{
                unset($_FILES['imgsrc1']);
                unset($_FILES['imgsrc2']);
                unset($_FILES['imgsrc3']);
            }
            foreach($_FILES as $key => $fileinfo){
                if($fileinfo['size'] < 1024000 && ($fileinfo['type'] =="image/png" || $fileinfo['type']=="image/jpeg" ) ){
                    $status = true;
                }else{
                    ci_redirect('/member/index/lists', 40, '图片格式或大小不对');
                }
            }


            $data['type'] = trim($form['type']);
            $data['code'] = md5($this->user['code'].time().rand(0,10000));
            $data['owner'] = $this->user['code'];
            if($form['type'] == 1 && $status){
                $data['name'] = trim($form['name']);
                $filename1 =date('Y/m/d')."/img/".time().rand(0,1000).$_FILES["imgsrc1"]["name"];
                $filename1 =iconv("UTF-8","gb2312",$filename1);
                $filename2 =date('Y/m/d')."/img/".time().rand(0,1000).$_FILES["imgsrc2"]["name"];
                $filename2 =iconv("UTF-8","gb2312",$filename2);
                $filename3 =date('Y/m/d')."/img/".time().rand(0,1000).$_FILES["imgsrc3"]["name"];
                $filename3 =iconv("UTF-8","gb2312",$filename3);
                $upload_file_url1 = $this->proxy->UploadFiles($filename1,$_FILES["imgsrc1"]["tmp_name"]);
                $upload_file_url2 = $this->proxy->UploadFiles($filename2,$_FILES["imgsrc2"]["tmp_name"]);
                $upload_file_url3 = $this->proxy->UploadFiles($filename3,$_FILES["imgsrc3"]["tmp_name"]);
                if(!$upload_file_url1 || !$upload_file_url2 || !$upload_file_url3){
                    ci_redirect('/member/index/lists', 3, '图片上传失败');
                }
                $data['bs_license_img'] = "http://osv.ufile.ucloud.com.cn/".$upload_file_url1;
                $data['id_card_img_1'] = "http://osv.ufile.ucloud.com.cn/".$upload_file_url2;
                $data['id_card_img_2'] = "http://osv.ufile.ucloud.com.cn/".$upload_file_url3;
            }else if($form['type'] == 2 && $status){
                $data['name'] = "";
                $filename4 =date('Y/m/d')."/img/".time().rand(0,1000).$_FILES["imgsrc4"]["name"];
                $filename4 =iconv("UTF-8","gb2312",$filename4);
                $filename5 =date('Y/m/d')."/img/".time().rand(0,1000).$_FILES["imgsrc5"]["name"];
                $filename5 =iconv("UTF-8","gb2312",$filename5);
                $upload_file_url4 = $this->proxy->UploadFiles($filename4,$_FILES["imgsrc4"]["tmp_name"]);
                $upload_file_url5 = $this->proxy->UploadFiles($filename5,$_FILES["imgsrc5"]["tmp_name"]);
                if( !$upload_file_url4 || !$upload_file_url5){
                    ci_redirect('/member/index/lists', 3, '图片上传失败');
                }
                $data['bs_license_img'] = "http://osv.ufile.ucloud.com.cn/";
                $data['id_card_img_1'] = "http://osv.ufile.ucloud.com.cn/".$upload_file_url4;
                $data['id_card_img_2'] = "http://osv.ufile.ucloud.com.cn/".$upload_file_url5;
            }else{
                ci_redirect('/member/index/lists', 3, '图片格式或大小不对');
            }
            $data['status'] = 0;
            $data['audit_status'] = 0;
            $data['created_time'] = date('Y-m-d H:i:s');
            $data['updated_time'] = date('Y-m-d H:i:s');
            $res = $this->company_model->add($data);
            if(!$res) {
                ci_redirect('/member/index/lists', 3, '提交失败');
            }
            ci_redirect('/ad/index/index');
        }
        $this->data['user'] = $this->user;
        $this->data['company'] = $this->company_model->getInfo($where = array("owner"=>$this->user['code']));
        if(!empty( $this->data['company'])){
            if($this->data['company']['type'] == 1){
                $this->data['compaycheack'] = "checked";
                $this->data['personcheack'] = "";
                $this->data['compaystyle'] = "on";
                $this->data['personstyle'] = "";
            }else{
                $this->data['compaycheack'] = "";
                $this->data['personcheack'] = "checked";
                $this->data['compaystyle'] = "";
                $this->data['personstyle'] = "on";
            }
            $this->layout->view('/member/list2', $this->data);
        }else{
            $this->layout->view('/member/list', $this->data);

        }
	}

public function edit()
	{
        //$data  = $this->input->get();
        //$valid      = array();
        //$validData  = $this->_getValidParam($data, $valid);
        //$urlParam   = $this->_generalUrl($validData);
        //$page = intval($data['page']) > 0 ? intval($data['page']) : 1;
        //$data['page'] = $page;
        //$offset = ($page-1) * $this->limit;
        //$rs = $this->Reward_model->getList(array(),$this->limit, $offset);
       //// var_dump($rs);die;
        //if ($data['_debug'] == '1')
        //{
            //var_dump($this->db->last_query());
        //}

        //$filters['config'] = $this->config->item('reward');
        
        //$this->data = array_merge($this->data,array(
            //'list'      => $rs['list'],
            //'page'      => page($urlParam,$rs['cnt'],$this->limit),
            //'filters'   => $filters,
        //));
		$this->layout->view('/member/edit', $this->data);
	} 
	

}
