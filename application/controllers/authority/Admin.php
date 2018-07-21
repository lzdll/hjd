<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

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
        $this->load->model('admins_model');
        $this->load->model('user_model');
    }

    /**
     * 初始化导航信息
     */
    private function _initNav()
    {
        $method = $this->router->method;
        $nav = array();
        if ( $method == 'index' ) // 列表
        {
            $nav[] = array('name' => '用户列表', 'url' => '');
        }
        else if ( $method == 'add' ) // 添加
        {
            $nav[] = array('name' => '用户添加', 'url' => '');
        }
        else if ( $method == 'edit' ) // 添加
        {
            $nav[] = array('name' => '用户编辑', 'url' => '');
        }
        $this->data['nav'] = array_merge($this->data['nav'], $nav);
    }

	public function index()
	{
        $data       = $this->input->get();
        $filters    = array();// 默认数据
        $valid      = array('id'=>'', 'email' => '', 'truename' => '', );
        $validData  = $this->_getValidParam($data, $valid);
        $where      = $this->_getConditions($validData);
        $urlParam   = $this->_generalUrl($validData);

        $filters['default'] = $validData;
        $page = intval($data['page']) > 0 ? intval($data['page']) : 1;
        $data['page'] = $page;
        $offset = ($page-1) * $this->limit;
        $rs = $this->user_model->getList($where, $this->limit, $offset);
        if ($data['_debug'] == '1')
        {
            var_dump($this->db->last_query());
        }
        $rs['list'] = $this->_getFilterDataMaps($rs['list']);
        $this->data = array_merge($this->data,array(
            'list'      => $rs['list'],
            'page'      => page($urlParam,$rs['cnt'],$this->limit),
            'filters'   => $filters,
        ));
		$this->layout->view('/authority/admin/list', $this->data);
	} 

    /**
     * 添加
     */
    public function add()
    {
        if ( $form = $this->input->post() )
        {
            if ( !$rs = $this->_save() )
            {
                ci_redirect('/authority/admin/add', 3, '添加失败');
            }
            ci_redirect('/authority/admin/index', 3, '添加成功');
            exit;
        }
        $this->load->model('role_model');
        $roles = $this->role_model->findAll();
        $this->data['role'] = $roles;
        $this->data['citys'] = $citys;
        $this->data['user_citys'] = array();
		$this->layout->view('/authority/admin/add', $this->data);
    }

    /**
     * 删除
     */
    public function del()
    {
        if ( !$id = $this->input->get('id') )
        {
            ci_redirect('/authority/admin/index', 3, '参数错误');
        }

        if (!$rs = $this->user_model->deleteByPk($id))
        {
            ci_redirect('/authority/admin/index', 3, '删除失败');
        }
        ci_redirect('/authority/admin/index', 3, '删除成功');
    }

    /**
     * 修改
     */
    public function edit()
    {

        if ( $form = $this->input->post() )
        {
            if ( !$rs = $this->_save() )
            {
                ci_redirect('/authority/admin/add', 3, '修改失败');
            }
            ci_redirect('/authority/admin/index', 3, '修改成功');
            exit;
        }
        if ( !$id = $this->input->get('id') )
        {
            ci_redirect('/authority/admin/index', 3, '参数错误');
        }
        if ( !$info = $this->user_model->findByPk($id) )
        {
            ci_redirect('/authority/admin/index', 3, '数据错误');
        }
        $this->load->model('role_model');
        $roles = $this->role_model->findAll();
        $this->data['role'] = $roles;
        $this->data['info'] = $info;
		$this->layout->view('/authority/admin/edit', $this->data);
    }

protected function _save()
    {
        if ( $form = $this->input->post() )
        {
            $id = intval($form['id']);
            $this->load->model('role_model');
            if (!$roleInfo = $this->role_model->findByPk($form['role']))
            {
                return false;
            }
			//修改
            if ($id)
            {
				$rs = $this->user_model->edit($id, $data);
            }else{
				if($form['role'] == 1){
					$type = 2;
				}else if($form['role'] == 2){
					$type = 0;
				}else if($form['role'] == 3){
					$type = 1;
				}
				$data['type'] = $type;
				$data['code'] = strtoupper(uniqid());
				$data['login_name'] = $form['login_name'];
				$data['password'] = gen_pwd($form['password']);
				$data['status'] = $form['status'];	
				$data['role_id'] = $form['role'];
				$data['email'] = $form['email'];
				
				$data['created_time'] = time();
				$rs = $this->user_model->add($data) ;
			}
            return true;
        }
    }
    protected function _getConditions($data)
    {
        $where = array();
        if ( isset($data['id']) && $data['id'] ) 
        {
            $where['user.id ='] = "{$data['id']}";
        }
        if ( isset($data['email']) && $data['email'] ) 
        {
            $where['user.email like'] = "%{$data['email']}%";
        }
        if ( isset($data['truename']) && $data['truename'] ) 
        {
            $where['user.truename like'] = "%{$data['truename']}%";
        }
     
        return $where;
    }

    protected function _getFilterDataMaps($data)
    {
        return $data;
    }
}
