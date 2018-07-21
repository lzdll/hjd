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
       
        //$this->load->model('plugin_building_model');
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
            $nav[] = array('name' => '专车奖励分配管理', 'url' => '');
        }
        else if ( $method == 'record' ) 
        {
            $nav[] = array('name' => '专车奖励单数分配', 'url' => '');
        }
        else if ( $method == 'recorddetail' ) 
        {
            $nav[] = array('name' => '系统奖励明细', 'url' => '');
        }
      
        $this->data['nav'] = array_merge($this->data['nav'], $nav);
    }

	public function lists()
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
		$this->layout->view('/sdk/list', $this->data);
	} 
	

}
