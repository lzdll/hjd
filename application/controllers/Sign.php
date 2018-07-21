<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sign extends CI_Controller {


   
    /**
     * 构造方法
     *
     * @return mixed
     */

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('admins_model');
        $this->load->model('user_model');
		$this->load->model('role_model');
    }


     
	/**
     * 登陆
     */
    public function index()
    {
        $this->login();
    }

    /**
     * 登陆
     */
    public function login()
    {
       

         if ( $form = $this->input->post() )
         {
             if ( empty($form['login_name']) || empty($form['password']) )
             {
                 ci_redirect('/sign/login', 5, '参数错误');
             }

             $where = array('login_name'=>$form['login_name']);
             if (!$info = $this->user_model->findByAttributes($where))
             {
                 ci_redirect('/sign/login', 5, '此用户不存在');
             }
			 $getarr = array('id'=>$info['role_id'],'type'=>$info['type']);
			 $role_list = $this->role_model->getInfo($getarr);
             if( gen_pwd(trim($form['password'])) != $info['password'] )
             {
                 ci_redirect('/sign/login', 5, '密码错误');
             }
			 $info['operate_rights'] = $role_list['operate_rights'];//赋值权限
             $this->session->uid = $info['id'];
             $this->session->username = $info['login_name'];
             foreach ($info as $k=>$v)
             {
                 $this->session->$k = $v; 
             }
             ci_redirect('/home/');
         }
 		$this->load->view('/sign/login');


    }

    /**
     * 登出
     */
    public function logout()
    {
         $this->session->sess_destroy();
         ci_redirect('/sign/login');
        foreach ($_COOKIE as $key => $value) {
            setcookie($key,'',time()-60, '/');
        }

        ci_redirect($this->logout, 3, '正在退出..');
    }

    public function sync_leju_user()
    {
        if($_GET['debug'] == 1){
            var_dump($_SERVER['SERVER_ADDR'],$_SERVER);
            $res = $this->user_model->findAll();
            var_dump($res);die;
        }

        $form = $this->input->post();
        if(empty($form['keys']) || empty($form['datas'])){
            echo json_encode(array('result'=>false,'msg'=>'缺少必要参数'));exit;
        }
        $userinfo = json_decode($form['datas'],true);


        //校验数据的来源
        $new_key = $this->get_cms_key($userinfo, $userinfo['passport_name']);
        unset($userinfo['id']);
        if($form['keys'] != $new_key){
            echo json_encode(array('result'=>false,'msg'=>'数据无效')); exit;
        }else{
            //判断是添加还是更新
            $tempinfo = $this->user_model->getInfo(array('passport_id'=>$userinfo['passport_id']));
            if($tempinfo){
                //更新
                $this->user_model->updateAll($userinfo, array('passport_id'=>$userinfo['passport_id']));
            }else{
                //新增
                $this->user_model->add($userinfo);
            }
            echo json_encode(array('result'=>true)); exit;
        }

    }

    /**
     * 生成加密key
     * @param array|string $data 数据
     * @param string $key
     * @return string
     */
    private function get_cms_key($data,$key)
    {
        $string = '';
        if(is_array($data))
        {
            foreach ($data as $v)
            {
                $string .= $v;
            }
        }
        else
        {
            $string = $data;
        }

        return md5($key.$string.$key);
    }
}
