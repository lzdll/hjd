<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
    private $redis_house_key = "admin_info_";
    /**
     * 构造方法
     *
     * @return mixed
     */
    public function __construct()
    {
        parent::__construct();
       
       
     
    }

    
    
	public function index()
    {
		print_r($this->session->get_userdata);
        $this->data['nav'] = array_merge($this->data['nav'], array(
            array('name' => '欢迎页', 'url' => '')
        ));
        $homelist = array(); 
        $this->data['time_type'] =$params['time_type'];
        $this->data['time'] =$params;
        $this->layout->view('/home/index', $this->data);
    }

}
