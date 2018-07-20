<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MY_Controller {

    /**
     * 构造方法
     *
     * @return mixed
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admins_model');
    }

	public function index()
	{
        exit('aaa');
	} 

    /**
     * 管理员登录名验证
     */
    public function checkLoginName()
    {
        $data = array('status' => false, 'msg' => '');
        if(!$loginName = $this->input->get('login_name'))
        {
            $data['msg'] = '登录名不能为空';
            $this->_outputJSON($data);
        }
        if ($info = $this->admins_model->findByAttributes(array('login_name'=>trim($loginName))))
        {
            $data['msg'] = '登录名重复';
            $this->_outputJSON($data);
        }
        $data['status'] = true;
        $this->_outputJSON($data);
    }
    
   
}
