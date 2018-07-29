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
        $this->load->model('user_model');

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
        $code =$this->input->get('user_code');
        if(!empty($code)){
            //用于运营查看广告主或者流量主
            $user_code = $this->input->get('user_code');
            $urole =$this->input->get('type'); //0:广告主 1: 流量主
        }
	   else{
           $urole = $this->user['type']; //0:广告主 1: 流量主
           $user_code = $this->user['user_code'];
       }
        if($urole == 0){
            $this->data['tips']  = "提交公司资质后才可投放广告";
            $this->data['companytype'] = "公司企业广告主";
            $this->data['perosntype'] = "个人广告主";
        }else{
            $this->data['tips'] = "提交公司资质审核通过后可上线广告，获取收益";
            $this->data['companytype'] = "公司企业流量主";
            $this->data['perosntype'] = "个人流量主";
        }
        //判断上传文件类型为png或jpg且大小不超过1024000B
        if($this->input->post()){
            $form = $this->input->post();
            $user['phone'] = $form['phone'];
            $user['email'] = $form['email'];
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
                    ci_redirect('/member/index/lists', 3, '图片格式或大小不对');
                }
            }


            $data['type'] = trim($form['type']);
            $data['company_code'] = $this->getCode();
            $data['owner'] = $this->user['user_code'];
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
            }else if($form['type'] == 0 && $status){
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
            $res2 = $this->user_model->edit($this->user['uid'],$user);
            if(!$res || !$res2) {
                ci_redirect('/member/index/lists', 3, '提交失败');
            }
            unset($this->user['phone']);
            unset($this->user['email']);
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['email'] = $user['email'];
            ci_redirect('/ad/index/index');
        }
        if(!empty($user_code) && isset($user_code)){
            $userinfo = $this->user_model->getInfo($where = array("user_code"=>$user_code));
            $this->data['user'] = $userinfo['user_code'];
            $this->data['phone'] = $userinfo['phone'];
            $this->data['email'] = $userinfo['email'];
        }else{
            $this->data['user'] = $this->user;
            $this->data['phone'] = $_SESSION['phone'];
            $this->data['email'] = $_SESSION['email'];
        }
        $this->data['company'] = $this->company_model->getInfo($where = array("owner"=>$user_code));
        //平台审核
        if($this->data['company']['audit_status'] ==0 && $this->user['type'] == 2){
            $id = $this->data['company']['id'];
            $this->data['button']  = " <button class='layui-btn addbtn'><a href='/member/index/pass?id=$id&user_code=$code' >通过审核</a></button>";
        }
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
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if($method == "post"){
            $form = $this->input->post();
            $uid = $this->user['id'];
            $data = array(
                "password" => gen_pwd(trim($form['repwd'])),
                "updated_time" => date('Y-m-d H:i:s',time())
            );
            $res = $this->user_model->edit($uid,$data);
            if($res){
                ci_redirect('/sign/logout', 3, '修改成功，请重新登录');
            }else{
                ci_redirect('member/index/edit', 3, '修改失败，请重新提交');
            }
        }
		$this->layout->view('/member/edit', $this->data);
	}
    public function pass()
    {
        $id = $this->input->get('id');
        $user_code = $this->input->get('user_code');
            $data = array(
                "audit_status" => 2,
                "updated_time" => date('Y-m-d H:i:s',time())
            );
            $res = $this->company_model->edit($id,$data);
            if($res){
                ci_redirect('/member/index/lists?user_code='.$user_code, 3, '修改成功');
            }else{
                ci_redirect('/member/index/listsuser_code='.$user_code, 3, '修改失败，请重新提交');
            }
    }

}
