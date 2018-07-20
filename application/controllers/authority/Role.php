<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 角色
 */
class Role extends MY_Controller 
{

    /**
     * 构造方法
     *
     * @return mixed
     */
    public function __construct()
    {
        parent::__construct();
        $this->_initNav();
        $this->load->model('role_model');
    }

    /**
     * 初始化导航信息
     */
    private function _initNav()
    {
        $method = $this->router->method;
        $nav = array();
        if ( $method == 'index' ) // 角色列表
        {
            $nav[] = array('name' => '角色列表', 'url' => '');
        }
        else if ( $method == 'add' ) // 角色添加
        {
            $nav[] = array('name' => '角色添加', 'url' => '');
        }
        else if ( $method == 'edit' ) // 角色添加
        {
            $nav[] = array('name' => '角色编辑', 'url' => '');
        }
        else if ( $method == 'rights' ) // 角色添加
        {
            $nav[] = array('name' => '权限设置', 'url' => '');
        }
        $this->data['nav'] = array_merge($this->data['nav'], $nav);
    }

    /**
     * 角色列表
     */
	public function index()
	{
        $data       = $this->input->get();
        $filters    = array();// 默认数据
        $valid      = array('name' => '', 'ctime' => '');
        $validData  = $this->_getValidParam($data, $valid);
        $where      = $this->_getConditions($validData);
        $urlParam   = $this->_generalUrl($validData);

        $filters['default'] = $validData;
        // $filters['city']['list'] = $this->_getUserCitys();

        $page = intval($data['page']) > 0 ? intval($data['page']) : 1;
        $data['page'] = $page;
        $offset = ($page-1) * $this->limit;
        $rs = $this->role_model->getList($where, $this->limit, $offset);
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

		$this->layout->view('/authority/role/list', $this->data);
	} 

    /**
     * 角色添加
     */
    public function add()
    {
        if ( $form = $this->input->post() )
        {
            if ( !$rs = $this->_save() )
            {
                ci_redirect('/authority/role/add', 3, '添加失败');
            }
            ci_redirect('/authority/role/index', 3, '添加成功');
            exit;
        }
		$this->layout->view('/authority/role/add', $this->data);
    }

    /**
     * 角色修改
     */
    public function edit()
    {
        if ( $form = $this->input->post() )
        {
            if ( !$rs = $this->_save() )
            {
                ci_redirect('/authority/role/add', 3, '修改失败');
            }
            ci_redirect('/authority/role/index', 3, '修改成功');
            exit;
        }
        if ( !$id = $this->input->get('id') )
        {
            ci_redirect('/authority/role/index', 3, '参数错误');
        }
        if ( !$info = $this->role_model->findByPk($id) )
        {
            ci_redirect('/authority/role/index', 3, '数据错误');
        }
        $this->data['info'] = $info;
		$this->layout->view('/authority/role/edit', $this->data);
    }

    /**
     * 角色删除
     */
    public function del()
    {
        if ( !$id = $this->input->get('id') )
        {
            ci_redirect('/authority/role/index', 3, '参数错误');
        }

        if (!$rs = $this->role_model->deleteByPk($id))
        {
            ci_redirect('/authority/role/index', 3, '删除失败');
        }
        ci_redirect('/authority/role/index', 3, '删除成功');
    }

    /**
     * 角色权限
     */
    public function rights()
    {
        if ( $form = $this->input->post() )
        {
            $rs = $this->_saveRights();
            $this->_outputJSON($rs);
            exit;
        }
        if ( !$id = $this->input->get('id') )
        {
            ci_redirect('/authority/role/index', 3, '参数错误');
        }
        if ( !$info = $this->role_model->findByPk($id) )
        {
            ci_redirect('/authority/role/index', 3, '数据错误');
        }
		print_r($info);
        $info['operate_rights_arr'] = explode(',', $info['operate_rights']);
        $this->data['info'] = $info;
        $this->data['rights'] = $this->config->item('rights');
		$this->layout->view('/authority/role/rights', $this->data);
    }

    /**
     * 权限保存
     */
    private function _saveRights()
    {
        $post = $this->input->post();
        $id = intval($post['id']);
        $keys = implode(',', $post['key']);
        $ref = array('status' => false, 'msg' => '');
        if ( empty($id) )
        {
            $ref['msg'] = '参数错误'; 
            return $ref;
        }
        $data = array(
            'operate_rights' => $keys,
            'utime' => time(), 
            'admin_id' => $this->user['uid'],
        );
        if ( !$rs = $this->role_model->edit($id, $data ) )
        {
            $ref['msg'] = '保存失败'; 
            return $ref;
        }
        $ref['status'] = true;
        return $ref;
    }

    protected function _save()
    {
        if ( $form = $this->input->post() )
        {
            $id = intval($form['id']);
            $data['name'] = trim($form['name']);
            $data['admin_id'] = $this->user['uid'];
            $data['utime'] = time();
            if ( !$id )
            {
                $data['ctime'] = time();
                if ( !$rs = $this->role_model->add($data) )
                {
                    return false;    
                }
                return true;
            }
            if ( !$rs = $this->role_model->edit($id, $data) )
            {
                return false;    
            }
            return true;
        }
    }

    protected function _getFilterDataMaps($data)
    {
        return $data;
    }

    protected function _getConditions($data)
    {
        $where = array();
        foreach ($data as $k=>$v)
        {
            if ( $k == 'name' ) // 名称
            {
                $where['admins_role.name like'] = "%{$data[$k]}%";
            }
            else if ( $k == 'ctime' ) // 角色创建时间
            {
                $where['admins_role.ctime >='] = (int) strtotime($data[$k]);
            }
        }
        return $where;
    }
}
