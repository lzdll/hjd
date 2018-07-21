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
        //$this->load->library('plugin/zygw');
       
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
	    echo 123;
		exit;
        $data  = $this->input->get();
        $valid      = array();
        $validData  = $this->_getValidParam($data, $valid);
        $urlParam   = $this->_generalUrl($validData);
        $page = intval($data['page']) > 0 ? intval($data['page']) : 1;
        $data['page'] = $page;
        $offset = ($page-1) * $this->limit;
        $rs = $this->Reward_model->getList(array(),$this->limit, $offset);
       // var_dump($rs);die;
        if ($data['_debug'] == '1')
        {
            var_dump($this->db->last_query());
        }

        $filters['config'] = $this->config->item('reward');
        
        $this->data = array_merge($this->data,array(
            'list'      => $rs['list'],
            'page'      => page($urlParam,$rs['cnt'],$this->limit),
            'filters'   => $filters,
        ));
		$this->layout->view('/reward/index/list', $this->data);
	} 

	public function record()
	{
	    $data       = $this->input->get();
        $filters    = array();// 默认数据
        $valid      = array('date_start' => '', 'date_end' => '', 'id' => '', 'username' => '',
                        'mobile' => '', 'city_en' => '', 'hid' => '', 'status' => '',
                        'time_type'=>'');
        $validData  = $this->_getValidParam($data, $valid);
        $where      = $this->_getRewardConditions($validData);
        $urlParam   = $this->_generalUrl($validData);

        $filters['default'] = $validData;

        $page = intval($data['page']) > 0 ? intval($data['page']) : 1;
        $data['page'] = $page;
        $offset = ($page-1) * $this->limit;
        $rs = $this->zygw_model->getRewardList($where, $this->limit, $offset);
        if ($data['_debug'] == '1')
        {
            var_dump($this->db->last_query());
        }
        $rs['list'] = $this->_getReviewFilterDataMaps($rs['list'], $validData);
        // var_dump($rs['list']);

        $filters['config'] = $this->config->item('zygw');
        $this->load->model('house_city_model');
        $filters['citys'] = $this->house_city_model->getUserCity($this->user['city_rights']);

        $this->data = array_merge($this->data,array(
            'list'      => $rs['list'],
            'page'      => page($urlParam,$rs['cnt'],$this->limit),
            'filters'   => $filters,
        ));
		$this->layout->view('/reward/index/rewardlists', $this->data);
	}
	

	public function recorddetail()
	{
	    $data  = $this->input->get();
	    if ( !$id = $this->input->get('zid') )
	    {
	        ci_redirect('/zygw/index/lists', 3, '缺少参数');
	    }
	    if ( !$info['zygw'] = $this->zygw_model->findByPk($id) )
	    {
	        ci_redirect('/zygw/index/lists', 3, '数据错误');
	    }
	    $filters['config'] = $this->config->item('reward');
	    $where['zid'] = $id;
	    $where['status ='] = 1;
	    $info['detail'] = $this->reward_record_model->getList($where);
	    //$this->db->last_query();die;
	    //var_dump($res);die;
	    $this->data = array_merge($this->data,array(
	        'info' =>$info,
	        'filters' => $filters,
	    ));
	    //var_dump($this->data);die;
	    $this->layout->view('/reward/index/rewarddetail', $this->data);
	    
	}
	
	public function exportsreview()
	{
        $data       = $this->input->get();
        $filters    = array();// 默认数据
        $valid      = array('date_start' => '', 'date_end' => '', 'id' => '', 'username' => '',
                        'mobile' => '', 'role' => '', 'city_en' => '', 'hid' => '', 'status' => '',
                        'time_type'=>'');
        $validData  = $this->_getValidParam($data, $valid);
        $where      = $this->_getReviewConditions($validData);
        $urlParam   = $this->_generalUrl($validData);

        $filters['default'] = $validData;
        // var_dump($filters['default']);
        // $filters['city']['list'] = $this->_getUserCitys();

        $page = intval($data['page']) > 0 ? intval($data['page']) : 1;
        $data['page'] = $page;
        $offset = ($page-1) * $this->limit;
        $rs = $this->zygw_model->getReviewList($where, 99999, 0);
        if ($data['_debug'] == '1')
        {
            var_dump($this->db->last_query());
            exit;
        }
        $rs['list'] = $this->_getReviewFilterDataMaps($rs['list'], $validData);

        $filters['config'] = $this->config->item('zygw');
        $this->load->model('house_city_model');
        $filters['citys'] = $this->house_city_model->getUserCity($this->user['city_rights']);

        $filename = date('YmdHi') . '.csv';
        header('Content-type:application/vnd.ms-excel;charset=gbk');
        header("Content-Disposition:filename= {$filename}");
        $column = array(
            '置业顾问ID',
            '姓名',
            '手机',
            '分机号',
            '角色',
            '当前楼盘',
            '申请变更楼盘',
            '申请变更时间',
        );
        $col_title = implode(',', $column);
        echo iconv('utf-8', 'gbk', "{$col_title}");
		echo "\r\n";
		if($rs['list'])
		{
			foreach($rs['list'] as $k => $v)
			{
                echo iconv('utf-8','gbk',$v['id']).",";
                echo iconv('utf-8','gbk',$v['username']).",";
                echo iconv('utf-8','gbk',$v['mobile']).",";
                echo iconv('utf-8','gbk',$v['subphone']).",";
                echo iconv('utf-8','gbk',$filters['config']['role'][$v['role']]).",";
                $str = "\"";
                if ($v['buildingInfo'])
                {
                    $str .= ($v['buildingInfo']['city_cn'] ? $v['buildingInfo']['city_cn'] . "\r\n" : "");
                    $str .= ($v['buildingInfo']['hid'] ? $v['buildingInfo']['hid'] . "\r\n" : "");
                    $str .= ($v['buildingInfo']['name'] ? $v['buildingInfo']['name'] . "\r\n" : "");
                    $str .= ($v['buildingInfo']['info_400']['phone_text'] ? $v['buildingInfo']['info_400']['phone_text'] . "\r\n" : "");
                    $str .= ($v['buildingInfo']['salestate_af'] ? $v['buildingInfo']['salestate_af'] . "\r\n" : "");
                }
                $str.= "\"";
                echo iconv('utf-8','gbk',$str).",";
                $str = "\"";
                if ($v['buildingChange'])
                {
                    $str .= ($v['buildingChange']['city_cn'] ? $v['buildingChange']['city_cn'] . "\r\n" : "");
                    $str .= ($v['buildingChange']['hid'] ? $v['buildingChange']['hid'] . "\r\n" : "");
                    $str .= ($v['buildingChange']['name'] ? $v['buildingChange']['name'] . "\r\n" : "");
                    $str .= ($v['buildingChange']['info_400']['phone_text'] ? $v['buildingChange']['info_400']['phone_text'] . "\r\n" : "");
                    $str .= ($v['buildingChange']['salestate_af'] ? $v['buildingChange']['salestate_af'] . "\r\n" : "");
                }
                $str.= "\"";
                echo iconv('utf-8','gbk',$str).",";
                echo iconv('utf-8','gbk',date('Y-m-d H:i', $v['change_createtime'])).",";

				echo "\r\n";
			}
		}
		else
		{
			// return FALSE; // 暂时没有数据  js alert
		} 
	} 

	public function exports()
	{
        $data       = $this->input->get();
        $filters    = array();// 默认数据
        $valid      = array('date_start' => '', 'date_end' => '', 'id' => '', 'username' => '',
                        'mobile' => '', 'role' => '', 'city_en' => '', 'hid' => '', 'status' => '',
                        'time_type'=>'');
        $validData  = $this->_getValidParam($data, $valid);
        $where      = $this->_getConditions($validData);
        $urlParam   = $this->_generalUrl($validData);

        $filters['default'] = $validData;
        // var_dump($filters['default']);
        // $filters['city']['list'] = $this->_getUserCitys();

        $page = intval($data['page']) > 0 ? intval($data['page']) : 1;
        $data['page'] = $page;
        $offset = ($page-1) * $this->limit;
        $rs = $this->zygw_model->getList($where, 99999, 0);
        if ($data['_debug'] == '1')
        {
            var_dump($this->db->last_query());
            exit;
        }
        $rs['list'] = $this->_getFilterDataMaps($rs['list'], $validData);

        $filters['config'] = $this->config->item('zygw');
        $this->load->model('house_city_model');
        $filters['citys'] = $this->house_city_model->getUserCity($this->user['city_rights']);

        $filename = date('YmdHi') . '.csv';
        header('Content-type:application/vnd.ms-excel;charset=gbk');
        header("Content-Disposition:filename= {$filename}");
        $column = array(
            '置业顾问ID',
            '姓名',
            '手机',
            '角色',
            '楼盘信息',
            '工单',
            '活跃度',
            '投诉',
            '创建时间',
            '账号状态',
            '排序',
        );
        $col_title = implode(',', $column);
        echo iconv('utf-8', 'gbk', "{$col_title}");
		echo "\r\n";
		if($rs['list'])
		{
			foreach($rs['list'] as $k => $v)
			{
                echo iconv('utf-8','gbk',$v['id']).",";
                echo iconv('utf-8','gbk',$v['username']).",";
                echo iconv('utf-8','gbk',$v['mobile']).",";
                echo iconv('utf-8','gbk',$filters['config']['role'][$v['role']]).",";
                $str = "\"";
                if ($v['buildingInfo'])
                {
                    $str .= ($v['buildingInfo']['city_cn'] ? $v['buildingInfo']['city_cn'] . "\r\n" : "");
                    $str .= ($v['buildingInfo']['hid'] ? $v['buildingInfo']['hid'] . "\r\n" : "");
                    $str .= ($v['buildingInfo']['name'] ? $v['buildingInfo']['name'] . "\r\n" : "");
                    $str .= ($v['buildingInfo']['info_400']['phone_text'] ? $v['buildingInfo']['info_400']['phone_text'] . "\r\n" : "");
                    $str .= ($v['crm'] && is_array($v['crm']) ? $v['crm']['status'] . "\r\n" : "");
                    $str .= ($v['buildingInfo']['salestate_af'] ? $v['buildingInfo']['salestate_af'] . "\r\n" : "");
                }
                $str.= "\"";
                echo iconv('utf-8','gbk',$str).",";
                $str = "\"";
                $str .= "客户服务工单总数(" . ($v['workOrder']['total'] ? $v['workOrder']['total'] : 0) . ")\r\n";
                $str .= "完成任务工单总数(" . ($v['workOrder']['complete'] ? $v['workOrder']['complete'] : 0) . ")";
                $str.= "\"";
                echo iconv('utf-8','gbk',$str).",";
                $str = "\"";
                $str .= "添加客户(" . ($v['vitality']['customerAdd'] ? $v['vitality']['customerAdd'] : 0) . ")\r\n";
                $str .= "留言(" . ($v['vitality']['leaveMessage'] ? $v['vitality']['leaveMessage'] : 0) . ")";
                $str .= "海报(" . ($v['vitality']['poster'] ? $v['vitality']['poster'] : 0) . ")";
                $str.= "\"";
                echo iconv('utf-8','gbk',$str).",";
                echo iconv('utf-8','gbk',($v['comment']['comment'] ? $v['comment']['comment'] : 0)).",";
                echo iconv('utf-8','gbk',date('Y-m-d H:i', $v['create_time'])).",";
                echo iconv('utf-8','gbk',$filters['config']['status'][$v['status']]).",";
                echo iconv('utf-8','gbk',($v['sort']== 999 ? '' : $v['sort'])).",";

				echo "\r\n";
			}
		}
		else
		{
			// return FALSE; // 暂时没有数据  js alert
		} 
	} 

    /**
     * 添加
     */
    public function add()
    {
        if ( $form = $this->input->post() )
        {
            $res = array('status'=>false, 'msg'=>'');
            $this->_save();
            exit;
        }
        $this->load->model('house_city_model');
        $filters['citys'] = $this->house_city_model->getUserCity($this->user['city_rights']);
        $filters['config'] = $this->config->item('zygw');
        $this->data = array_merge($this->data,array(
            'filters'   => $filters,
        ));
		$this->layout->view('/zygw/index/add', $this->data);
    }

    /**
     * 编辑
     */
    public function edit()
    {
        if ( $form = $this->input->post() )
        {
            $res = array('status'=>false, 'msg'=>'');
            $this->_save();
            exit;
        }
        if ( !$id = $this->input->get('id') )
        {
            ci_redirect('/zygw/index/lists', 3, '参数错误');
        }
        if ( !$info = $this->zygw_model->findByPk($id) )
        {
            ci_redirect('/zygw/index/lists', 3, '数据错误');
        }
        $this->load->model('house_city_model');
        $filters['citys'] = $this->house_city_model->getUserCity($this->user['city_rights']);
        $filters['config'] = $this->config->item('zygw');
        $info['tags'] = explode(',', $info['tags']);
        //var_dump($info);die;
        $this->data = array_merge($this->data,array(
            'info' =>$info,
            'filters' => $filters,
        ));
		$this->layout->view('/zygw/index/edit', $this->data);
    }

    /**
     * 查看
     */
    public function info()
    {
        if ( !$id = $this->input->get('id') )
        {
            ci_redirect('/zygw/index/lists', 3, '参数错误');
        }
        if ( !$info = $this->zygw_model->findByPk($id) )
        {
            ci_redirect('/zygw/index/lists', 3, '数据错误');
        }
        if (!empty($info['city_en']) && !empty($info['hid']))
        {
            $info['buildingInfo'] = $this->_getBuidingInfo($info);
        }
        $this->load->model('house_city_model');
        $filters['cityInfo'] = $this->house_city_model->findByAttributes(array('city_en'=>$info['city_en']));
        $filters['config'] = $this->config->item('zygw');
        $param = array(
            'id' => $info['id'], 
            'date_start' => '19800101', 
            'date_end' => date('Ymd'),
            'hid' => $info['hid']
        );
        // 获取客户服务工单信息
        if ($info['hid'])
        {
            $info['workOrder'] = $this->_getWorkOrder($info, $param);
        }
        // 获取客户服务工单信息
        $info['vitality'] = $this->_getVitality($info, $param);

        $this->load->model('zygw_status_record_model');
        $this->load->model('zygw_info_record_model');
        $this->load->model('zygw_receive_record_model');
        // 获取账号状态记录
        $info['statusRecord'] = $this->zygw_status_record_model->findAll(array('zid'=>$info['id']));
        $info['infoRecord'] = $this->zygw_info_record_model->findAll(array('zid'=>$info['id']));
        $info['receiveRecord'] = $this->zygw_receive_record_model->findAll(array('zid'=>$info['id']));
        //应答率
        $info['response'] = $this->_getOperation($info);
        $this->data = array_merge($this->data,array(
            'info' =>$info,
            'filters' => $filters,
        ));
		$this->layout->view('/zygw/index/info', $this->data);
    }

    

    /**
     * 记录基本信息修改
     */
    protected function _insertInfoRecord($old = array(), $new = array())
    {
        // 核心信息（记录详细修改日志）：名片、城市、楼盘、角色、状态
        // 其他信息（统计记录为信息修改）：姓名、性别、生日、头像、自我评价、工作年限(记一条)
        // 变更楼盘 记录
        if ( empty($old) || empty($new) )
        {
            return false;
        }
        $insert = array();
        $other = array();
        $fieldsCore = array(
            'card' => '名片', 
            'city_en' => '城市', 
            'hid' => '楼盘', 
            'role' => '角色', 
            'status' => '状态'
        );
        $fieldsOther = array(
            'username' => '姓名', 
            'sex' => '性别',  
            'birthday' => '生日', 
            'logo' => '头像', 
            'pingjia' => '评价', 
            'years'  => '工作年限', 
        );
        $this->load->model('house_city_model');
        $config = $this->config->item('zygw');
        $citys = $this->house_city_model->getAll();
        if (isset($new['card']) && $new['card'] != $old['card'])
        {
            $insert[] = array(
                'zid' => $old['id'],
                'old' => $fieldsCore['card'] . ":" . $old['card'],
                'new' => $fieldsCore['card'] . ":" . $new['card'],
                'admin_id' => $this->user['uid'],
                'admin_name' => $this->user['username'],
                'ctime' => time(),
            );
        }
        if (isset($new['city_en']) && $new['city_en'] != $old['city_en'])
        {
            $insert[] = array(
                'zid' => $old['id'],
                'old' => $fieldsCore['city_en'] . ":" . $citys[$old['city_en']]['city_cn'],
                'new' => $fieldsCore['city_en'] . ":" . $citys[$new['city_en']]['city_cn'],
                'admin_id' => $this->user['uid'],
                'admin_name' => $this->user['username'],
                'ctime' => time(),
            );
        }
        if (isset($new['hid']) && $new['hid'] != $old['hid'])
        {
            $oldBuilding = $this->_getBuidingInfo($old);
            $newBuilding = $this->_getBuidingInfo($new);
            $insert[] = array(
                'zid' => $old['id'],
                'old' => $fieldsCore['name'] . ":" . $oldBuilding['name'],
                'new' => $fieldsCore['name'] . ":" . $newBuilding['name'],
                'admin_id' => $this->user['uid'],
                'admin_name' => $this->user['username'],
                'ctime' => time(),
            );
        }
        if (isset($new['role']) && $new['role'] != $old['role'])
        {
            $insert[] = array(
                'zid' => $old['id'],
                'old' => $fieldsCore['role'] . ":" . $config['role'][$old['role']],
                'new' => $fieldsCore['role'] . ":" . $config['role'][$new['role']],
                'admin_id' => $this->user['uid'],
                'admin_name' => $this->user['username'],
                'ctime' => time(),
            );
        }
        if (isset($new['status']) && $new['status'] != $old['status'])
        {
            $insert[] = array(
                'zid' => $old['id'],
                'old' => $fieldsCore['status'] . ":" . $config['status'][$old['status']],
                'new' => $fieldsCore['status'] . ":" . $config['status'][$new['status']],
                'admin_id' => $this->user['uid'],
                'admin_name' => $this->user['username'],
                'ctime' => time(),
            );
        }
        foreach ($fieldsOther as $k=>$v)
        {
            if($old[$k] != $new[$k])
            {
                $other[] = $v;
            }
        }
        if ($other)
        {
            $insert[] = array(
                'zid' => $old['id'],
                'old' => '',
                'new' => '信息修改:' . (implode(',', $other)),
                'admin_id' => $this->user['uid'],
                'admin_name' => $this->user['username'],
                'ctime' => time(),
            );
        }
        $insert && $this->db->insert_batch('zygw_info_record', $insert); 
        return true;
    }

    /**
     * 记录楼盘变更申请
     * @param array $old 旧信息
     * @param array $new 新信息
     * @param integer $type 1-楼盘变更通过 2-楼盘变更驳回
     */
    protected function _insertBuildingRecord($old = array(), $new = array(), $type = 2, $des = '')
    {
        if ( empty($old) || empty($new) )
        {
            return false;
        }
        $insert = array();
        // if ( $old['city_en'] != $new['city_en'] || $old['hid'] != $new['hid'] )
        if (isset($new['status']) && $new['status'] != $old['status'])
        {
            $oldBuilding = ($old['city_en'] && $old['hid'] 
                ? $this->plugin_building_model->getInfo($old['city_en'], $old['hid']) 
                : array());
            $newBuilding = ($new['city_en'] && $new['hid'] 
                ? $this->plugin_building_model->getInfo($new['city_en'], $new['hid']) 
                : array());
            $oldBuilding = current($oldBuilding);
            $newBuilding = current($newBuilding);
            $insert[] = array(
                'zid' => $old['id'],
                'type' => $type,
                'des' => $des,
                'old' => '楼盘:' . $oldBuilding['name'],
                'new' => '楼盘:' . $newBuilding['name'] . ($type == 3 ? '(驳回)' : ''),
                'admin_id' => $this->user['uid'],
                'admin_name' => $this->user['username'],
                'ctime' => time(),
            );
        }
        $insert && $this->db->insert_batch('zygw_info_record', $insert); 
        return true;
    }


    /**
     * 专车的奖励单数修改
     */
    public function upsort()
    {
        $data = $this->input->post();
        $res = array('status'=>false, 'msg'=>'');
        $id = (int) $data['id'];
        $sort = $data['new_sort'];
        if(empty($sort))$sort=0;
        if ($sort < 0 )
        {
            $res['msg'] = '奖励单数不能为负';
            $this->_outputJSON($res);
        }

        if (!$info = $this->Reward_model->findByPk($id))
        {
            $res['msg'] = '奖励规则不存在';
            $this->_outputJSON($res);
        }
        if ($info['reward'] == $sort)
        {
            $this->Reward_model->updateByPk($id, array('admin_id'=>$this->user['uid'],'admin_name'=>$this->user['truename'],'update_time'=>time()));
            $res['status'] = true;
            $this->_outputJSON($res);
            exit;
        }
        $r = $this->Reward_model->updateByPk($id, array('reward'=>$sort,'admin_id'=>$this->user['uid'],'admin_name'=>$this->user['truename'],'update_time'=>time()));
        $res['status'] = true;
        $this->_outputJSON($res);
    }
    
    /**
     * 专车的奖励规则修改
     */
    public function ruleupsort()
    {
        $data = $this->input->post();
        $res = array('status'=>false, 'msg'=>'');
        $id = (int) $data['id'];
        $sort = $data['new_sort'];
        if(empty($sort))$sort=0;
        if ($sort < 0 )
        {
            $res['msg'] = '奖励规则不能为负';
            $this->_outputJSON($res);
        }
    
        if (!$info = $this->Reward_model->findByPk($id))
        {
            $res['msg'] = '奖励规则不存在';
            $this->_outputJSON($res);
        }
        if ($info['rule'] == $sort)
        {
            $this->Reward_model->updateByPk($id, array('admin_id'=>$this->user['uid'],'admin_name'=>$this->user['truename'],'update_time'=>time()));
            $res['status'] = true;
            $this->_outputJSON($res);
            exit;
        }
        $r = $this->Reward_model->updateByPk($id, array('rule'=>$sort,'admin_id'=>$this->user['uid'],'admin_name'=>$this->user['truename'],'update_time'=>time()));
        if (!$r)
        {
            $res['msg'] = '更改失败';
            $this->_outputJSON($res);
        }
        $temp = $this->reward_record_model->findAll(array('type'=>2,'status'=>0,'count >='=>$sort));
        //检测
        $r = $this->reward_record_model->updateAll(array('quoat'=>$info['reward'],'status'=>1,'updatetime'=>time()),array('type'=>2,'status'=>0,'count >='=>$sort));
        foreach ($temp as $v){
            $zygw = $this->zygw_model->findByPk($v['zid']);
            $arrdata = array(
                'hid'=>$zygw['hid'],
                'city_en'=>$zygw['city_en'],
                'zid'=>$zygw['id'],
            );
            $arrdata['content'] = '您完成了专车确客的任务，获得看房专车独享名额'.$info['reward'].'个';
            $this->zygw->pushSysmsg($arrdata);
        }
       
        $res['status'] = true;
        $this->_outputJSON($res);
    }

    /**
     * 记录置业顾问状态变更
     */
    protected function _statusRecordInsert($type = '', $zid = '', $des = '')
    {
        if( $type === '' || $zid === '' )
        {
            return false;
        }
        $data = array(
            'zid' => $zid,
            'type' => $type,
            'des' => $des,
            'admin_id' => $this->user['uid'],
            'admin_name' => $this->user['username'],
            'ctime' => time(),
        );
        $this->load->model('zygw_status_record_model');
        $r = $this->zygw_status_record_model->add($data);
        // var_dump($r);
        return true;
    }

    /**
     * 楼盘变更通过操作
     */
    public function adopt()
    {
        $data = $this->input->post();
        $res = array('status'=>false, 'msg'=>'');
        $id = (int) $data['id'];
        $building = $data['building'];

        if (!$zygwInfo = $this->zygw_model->findByPk($id))
        {
            $res['msg'] = '置业顾问不存在';
            $this->_outputJSON($res);
        }
        $this->load->model('house_change_model');
        $this->load->model('zygw_poster_model');
        if (!$buildingInfo = $this->house_change_model->findByPk($building))
        {
            $res['msg'] = '楼盘数据错误';
            $this->_outputJSON($res);
        }
        if ( !$buildingInfo['city_en'] || !$buildingInfo['hid'] )
        {
            $res['msg'] = '楼盘数据错误';
            $this->_outputJSON($res);
        }
        $rUp = $this->zygw->upBuilding($zygwInfo['id']);
        if ( $rUp['status'] === false )
        {
            $res['msg'] = "更改失败". ($rUp['msg'] ? "（{$rUp['msg']}）" : '');
            $this->_outputJSON($res);
        }
        $this->zygw_model->updateByPk(
            $id, 
            array(
                'city_en'=>$buildingInfo['city_en'], 
                'hid'=>$buildingInfo['hid'],
                'house_id'=>$buildingInfo['house_id'],
            )
        );
        $this->house_change_model->updateByPk($buildingInfo['id'], array('status'=>1));
        $zygwInfo['id'] && $this->zygw_poster_model->deleteAll(array('zid'=>$zygwInfo['id']));
        $this->_insertBuildingRecord($zygwInfo, $buildingInfo, 2);
        $res['status'] = true;
        $this->_outputJSON($res);
    }

    /**
     * 楼盘变更驳回操作
     */
    public function reject()
    {
        $data = $this->input->post();
        $res = array('status'=>false, 'msg'=>'');
        $zygwId = (int) $data['zygw_id'];
        $buildingChangeId = $data['building_change_id'];
        $des = $data['des'];
        if (!$zygwInfo = $this->zygw_model->findByPk($zygwId))
        {
            $res['msg'] = '置业顾问不存在';
            $this->_outputJSON($res);
        }
        $this->load->model('house_change_model');
        if (!$buildingInfo = $this->house_change_model->findByPk($buildingChangeId))
        {
            $res['msg'] = '楼盘数据错误';
            $this->_outputJSON($res);
        }
        if ( !$buildingInfo['city_en'] || !$buildingInfo['hid'] )
        {
            $res['msg'] = '楼盘数据错误';
            $this->_outputJSON($res);
        }
        $this->house_change_model->updateByPk($buildingInfo['id'], array('status'=>2));
        $this->_insertBuildingRecord($zygwInfo, $buildingInfo, 3, $des);
        $res['status'] = true;
        $this->_outputJSON($res);
    }

	/**
     * 导入记录查看
     */
    public function importdetail()
    {
        if ( !$id = $this->input->get('id') )
        {
            ci_redirect('/zygw/index/import', 3, '参数错误');
        }
		$this->load->model('import_record_model');
        if ( !$info = $this->import_record_model->findByPk($id) )
        {
            ci_redirect('/zygw/index/import', 3, '数据错误');
        }
		
		$info['detail'] = json_decode($info['detail'], true);
		//var_dump($info);
        $this->data = array_merge($this->data,array(
            'info' =>$info,
        ));
		$this->layout->view('/zygw/index/importdetail', $this->data);
    }

    /**
     * 批量导入
     */
    public function import()
    {
        if(isset($_GET['_debug']) && $_GET['_debug'] == 1)
        {

            /* $filename = date('YmdHi') . '.csv';
            header('Content-type:application/vnd.ms-excel;charset=gbk');
            header("Content-Disposition:filename= {$filename}");
            $column = array(
                'city_en',
                'city_code',
                'city_cn',
            );
            $col_title = implode(',', $column);
            echo iconv('utf-8', 'gbk', "{$col_title}");
            echo "\r\n";
            $this->load->model('house_city_model');
            $cityAll = $this->house_city_model->getAll();
            foreach($cityAll as $k => $v)
            {
                echo iconv('utf-8','gbk',$v['city_en']).",";
                echo iconv('utf-8','gbk',$v['city_code']).",";
                echo iconv('utf-8','gbk',$v['city_cn']).",";
                echo "\r\n";
            } */

            exit; 
        }
        if ( $_FILES && $file = $_FILES['file_import'] )
        {
            ini_set('max_execution_time', '0');
            ini_set('max_input_time', '99999999');
            ini_set('memory_limit','500M');

            $res = array('status'=>false, 'msg'=>'');
			$data=array('A'=>'username','B'=>'mobile','C'=>'role','E'=>'city_en','F'=>'hid','H'=>'status');
			$tableName ='city2';//表名字
            $r = $this->_import($file['tmp_name'], $data, $tableName);
			if ( $r == 2)
			{
				ci_redirect('/zygw/index/import', 3, '请上传EXCEL文件');
				exit;
			}
			ci_redirect('/zygw/index/import', 3, '完成');
            exit;
        }
        $data       = $this->input->get();
        $filters    = array();// 默认数据
        $valid      = array('date_start' => '', 'date_end' => '');
        $validData  = $this->_getValidParam($data, $valid);
        $where      = $this->_getImportConditions($validData);
        $urlParam   = $this->_generalUrl($validData);

        $filters['default'] = $validData;

        $page = intval($data['page']) > 0 ? intval($data['page']) : 1;
        $data['page'] = $page;
        $offset = ($page-1) * $this->limit;
        $this->load->model('import_record_model');
        $rs = $this->import_record_model->getList($where, $this->limit, $offset, 'id desc');
        if ($data['_debug'] == '1')
        {
            var_dump($this->db->last_query());
        }
        //$rs['list'] = $this->_getReviewFilterDataMaps($rs['list'], $validData);

        $this->data = array_merge($this->data,array(
            'list'      => $rs['list'],
            'page'      => page($urlParam,$rs['cnt'],$this->limit),
            'filters'   => $filters,
        ));
		$this->layout->view('/zygw/index/import', $this->data);
    }

	

	
    protected function _getImportConditions(& $data)
    {
        $where = array();
        $filters = array('date_start', 'date_end'); // 跳过
		if (isset($data['date_start']) && $data['date_start']) {
            $where['ctime >'] = strtotime($data['date_start']);
        }
        if (isset($data['date_end']) && $data['date_end']) {
            $where['ctime <='] = strtotime($data['date_end']) +3600*24;
        }
        return $where;
    }

    /**
     * 审核列表
     */
    protected function _getRewardConditions(& $data)
    {
        $where = array();
        $filters = array('time_type', 'city_en', 'date_start', 'date_end', 'hid'); // 跳过
        foreach ($data as $k=>$v)
        {
            if ( $k == 'username' ) {
                $where['zygw.username like'] = "%{$v}%";
            } else if ( $k == 'status' ) {
                $v && $where['zygw.status ='] = $v;
            } else if ( in_array($k, $filters) ) {
                continue;
            } else {
                $where["zygw.{$k} ="] = $v;
            }
        }

        if (isset($data['city_en']) && $data['city_en']) {
            $where['zygw.city_en ='] = $data['city_en'];
        } else {
            if (!empty($this->user['city_rights'])) {
                $citys = explode(',', $this->user['city_rights']);
                $citys = "'" . implode("','", $citys) . "'";
                $where["zygw.city_en in ({$citys}) AND "] = "1";
                // $where['city'] = "`city` in ('$citys')";
            } else {
                $where['zygw.city_en ='] = '-1';// 无城市权限
            }
        }
        if (isset($data['hid']) && $data['hid']) {
            $where['zygw.hid='] = $data['hid'];
        }
        $where['reward_record.status ='] = 1;
        return $where;
    }

    protected function _getConditions(& $data)
    {
        $where = array();
        $filters = array('time_type', 'city_en', 'date_start', 'date_end'); // 跳过
        foreach ($data as $k=>$v)
        {
            if ( $k == 'username' ) {
                $where['zygw.username like'] = "%{$v}%";
            } else if ( $k == 'role' ) {
                $v && $where['zygw.role ='] = $v;
            } else if ( $k == 'status' ) {
                $v && $where['zygw.status ='] = $v;
            } else if ( in_array($k, $filters) ) {
                continue;
            } else {
                $where["zygw.{$k} ="] = $v;
            }
        }
        // echo 'data:' . var_export($data, true);
        if (isset($data['date_start']) && $data['date_start']) {
            $where['zygw.create_time >'] = strtotime($data['date_start']);
        } else {
            $data['date_start'] = date('Y-m-d', strtotime('-30 day'));// 默认前一天
            $where['zygw.create_time >'] = strtotime($data['date_start']);
        }

        if (isset($data['date_end']) && $data['date_end']) {
            $where['zygw.create_time <='] = strtotime($data['date_end']) +3600*24;
        } else {
            $data['date_end'] = date('Y-m-d', time());
            $where['zygw.create_time <='] = strtotime($data['date_end']) + 3600*24;
        }
        // var_dump($data['date_end']);
        // var_dump(date("Y-m-d H:i:s", strtotime($data['date_end'])));
        // var_dump(date("Y-m-d H:i:s", strtotime($data['date_end']) +3600*24));
        // echo 'data:' . var_export($data, true);

        if (isset($data['city_en']) && $data['city_en']) {
            $where['zygw.city_en ='] = $data['city_en'];
        } else {
            if (!empty($this->user['city_rights'])) {
                $citys = explode(',', $this->user['city_rights']);
                $citys = "'" . implode("','", $citys) . "'";
                $where["zygw.city_en in ({$citys}) AND "] = "1";
                // $where['city'] = "`city` in ('$citys')";
            } else {
                $where['zygw.city_en ='] = '-1';// 无城市权限
            }
        }
        //不展示删除的数据
        $where['zygw.status != '] = '6';
        return $where;
    }

    protected function _getReviewFilterDataMaps($data, $param)
    {
        // $buildingInfo = $this->plugin_building_model->getInfo('bj', '107923,1588');
        // var_dump($buildingInfo);
        foreach ($data as $k=>$v)
        {
            $data[$k]['buildingInfo'] = $this->_getBuidingInfo($v);
            $changeParam = array('city_en'=>$v['change_city_en'],'hid'=>$v['change_hid']);
            $data[$k]['buildingChange'] = $this->_getBuidingInfo($changeParam);
            //$data[$k]['mobile'] = $v['mobile'] ? substr_replace($v['mobile'],'****',3,4) : '';
        }
        // var_dump($data);
        return $data;
    }

   

    // 获取客户投诉
    protected function _getComment($data = array(), $param)
    {
        $return = array();
        if (empty($data))
        {
            return $return;
        }
        $start = $end = 0;
        if (isset($param['date_start']) && $param['date_start']) {
            $start = strtotime($param['date_start']);
        } else {
            $start = strtotime(date('Y-m-d', strtotime('-30 day')));// 默认前一天
        }
        if (isset($param['date_end']) && $param['date_end']) {
            $end = strtotime($param['date_end']) + 3600*24;
        } else {
            $end = strtotime(date('Y-m-d', time())) + 3600*24;
        }
        $sql = "SELECT count(*) AS t FROM laike_comment WHERE zid = ? AND type=2 AND comment_time > ? AND comment_time <= ?";
        $return['comment'] = $this->db->query($sql, array($data['id'], $start, $end))->row()->t;
        // var_dump($this->db->last_query());
        // var_dump($return);
        return $return;
    }

    // 获取客户服务工单信息
    protected function _getVitality($data = array(), $param)
    {
        $return = array();
        if (empty($data))
        {
            return $return;
        }
        $start = $end = 0;
        if (isset($param['date_start']) && $param['date_start']) {
            $start = strtotime($param['date_start']);
        } else {
            $start = strtotime(date('Y-m-d', strtotime('-30 day')));// 默认前一天
        }
        if (isset($param['date_end']) && $param['date_end']) {
            $end = strtotime($param['date_end']) + 3600*24;
        } else {
            $end = strtotime(date('Y-m-d', time())) + 3600*24;
        }
        $sql = "SELECT count(*) AS t FROM laike_customer WHERE zid = ? AND createtime > ? AND createtime <= ?";
        $return['customerAdd'] = $this->db->query($sql, array($data['id'], $start, $end))->row()->t;
        $sql = "SELECT count(*) AS t FROM laike_leave_message WHERE zid = ? AND createtime > ? AND createtime <= ?";
        $return['leaveMessage'] = $this->db->query($sql, array($data['id'], $start, $end))->row()->t;
        $sql = "SELECT count(*) AS t FROM laike_zygw_poster WHERE zid = ? AND create_time > ? AND create_time <= ?";
        $return['poster'] = $this->db->query($sql, array($data['id'], $start, $end))->row()->t;
        // var_dump($this->db->last_query());
        // var_dump($return);
        return $return;
    }
    
    // 获取客户服务工单信息(应答率)
    protected function _getOperation($data = array(), $param)
    {
        $return = array();
        if (empty($data))
        {
            return $return;
        }
        $start = $end = 0;
        if (isset($param['date_start']) && $param['date_start']) {
            $start = strtotime($param['date_start']);
        } else {
            $start = strtotime(date('Y-m-d', strtotime('-30 day')));// 默认前一天
        }
        if (isset($param['date_end']) && $param['date_end']) {
            $end = strtotime($param['date_end']) + 3600*24;
        } else {
            $end = strtotime(date('Y-m-d', time())) + 3600*24;
        }
        //应答率
        $sql = "SELECT count(*) AS t FROM laike_worktable WHERE order_zid = ? AND createtime > ? AND createtime <= ?";
        $bottom = $this->db->query($sql, array($data['id'], $start, $end))->row()->t;
        $sql = "SELECT count(*) AS t FROM laike_worktable WHERE zid = ? AND createtime > ? AND createtime <= ?";
        $top = $this->db->query($sql, array($data['id'], $start, $end))->row()->t;
        $return['response'] = round($top/$bottom);
        //专车奖励单数
//         $sql = "SELECT count(*) AS t FROM zygw_poster WHERE zid = ? AND create_time > ? AND create_time <= ?";
//         $return['poster'] = $this->db->query($sql, array($data['id'], $start, $end))->row()->t;
        // var_dump($this->db->last_query());
        // var_dump($return);
        return $return;
    }

    // 获取工单信息 (客户服务工单总数、完成任务工单总数)
    protected function _getWorkOrder($data = array(), $param)
    {
        $return = array();
        if (empty($data))
        {
            return $return;
        }
        $start = $end = 0;
        if (isset($param['date_start']) && $param['date_start']) {
            $start = strtotime($param['date_start']);
        } else {
            $start = strtotime(date('Y-m-d', strtotime('-30 day')));// 默认前一天
        }
        if (isset($param['date_end']) && $param['date_end']) {
            $end = strtotime($param['date_end']) + 3600*24;
        } else {
            $end = strtotime(date('Y-m-d', time())) + 3600*24;
        }
        $sql = "SELECT count(*) AS t FROM laike_worktable WHERE" .
            " ((zid = ? AND hid = ?) OR (zid = 0 AND hid = ?) " .
            "OR (order_zid = ?)) AND createtime > ? AND createtime <= ?";
        $return['total'] = $this->db
            ->query($sql, array($data['id'], $data['hid'], $data['hid'], $data['id'], $start, $end))->row()->t;
        // var_dump($this->db->last_query()); 
        // var_dump($return);
        // $sql = "SELECT count(*) AS t FROM laike_worktable WHERE order_zid = ? AND createtime > ? AND createtime <= ?";
        // $return['complete'] = $this->db->query($sql, array($data['id'], $start, $end))->row()->t;
        // 获取评价回复
        $sql = "SELECT count(*) AS t FROM laike_comment WHERE zid = ? AND status = 1 AND comment_time > ? AND comment_time <= ?";
        $comment = $this->db->query($sql, array($data['id'], $start, $end))->row()->t;
        // var_dump($this->db->last_query());
        // var_dump($customer);
        // 获取楼盘海报
        $sql = "SELECT count(*) AS t FROM laike_zygw_poster WHERE zid = ? AND create_time > ? AND create_time <= ?";
        $poster = $this->db->query($sql, array($data['id'], $start, $end))->row()->t;
        // var_dump($this->db->last_query());
        // var_dump($poster);
        // 获取添加新客户数量
        $sql = "SELECT count(*) AS t FROM laike_customer WHERE zid = ? AND createtime > ? AND createtime <= ?";
        $customer = $this->db->query($sql, array($data['id'], $start, $end))->row()->t;
        // var_dump($this->db->last_query());
        // var_dump($customer);
        // var_dump($return);
        $return['complete'] = $comment + $poster + $customer;
        return $return;
    }

    // 获取CRM信息
    protected function _getCrmInfo($data = array())
    {
        $return = array();
        if (empty($data))
        {
            return $return;
        }
        $this->load->model('plugin_crm_model');
        $return = $this->plugin_crm_model->getInfo($data['city_en'], $data['hid']); 
        // var_dump($return);
        return is_array($return) && !empty($return) ? current($return) : array();
    }

    // 获取楼盘信息
    protected function _getBuidingInfo($data = array())
    {
        $buildingInfo = array();
        if (empty($data))
        {
            return $buildingInfo;
        }
        $buildingInfo = $this->plugin_building_model->getInfo($data['city_en'], $data['hid']); 
        // var_dump($buildingInfo);
        return current($buildingInfo);
    }

    // 获取是否有变更楼盘
    protected function _getHouseChange($data = array())
    {
        $return = array();
        if (empty($data) || empty($data['id']))
        {
            return $return;
        }
        $this->load->model('house_change_model');
        return $this->house_change_model->getRowByAttr(array('zid'=>$data['id'], 'status'=>0));
    }

}
