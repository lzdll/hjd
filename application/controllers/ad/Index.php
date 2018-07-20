<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller
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
        $this->load->model('customer_id_model');
        $this->load->model('customer_model');
        $this->load->model('customersm_model');
        $this->load->model('sys_poster_model');
        $this->load->model('user_model');
        $this->load->model('ad_model');
        $this->load->model('ad_city_model');

        $this->load->model('house_city_model');
        //city list
        $citylist = $this->house_city_model->getUserCity();
        $_citylist = array();
        foreach ($citylist as $city)
        {
            $_citylist[$city['city_en']] = $city;
        }
        $this->data['citylist'] = $_citylist;

        $config = $this->config->item('ad');
        $this->data['config'] = $config;
    }

    /**
     * 初始化导航信息
     */
    private function _initNav()
    {
        $method = $this->router->method;
        $nav = array();
        if ($method == 'index') // 列表
        {
            $nav[] = array('name' => '系统消息管理', 'url' => '');
        } else if ($method == 'lists') // 添加
        {
            $nav[] = array('name' => '广告列表', 'url' => '');
        } else if ($method == 'add') // 添加
        {
            $nav[] = array('name' => '添加广告', 'url' => '');
        }
        else if ( $method == 'edit' ) // 添加
        {
            $nav[] = array('name' => '编辑广告', 'url' => '');
        }
        $this->data['nav'] = array_merge($this->data['nav'], $nav);
    }

    /**
     * 客户数据首页
     */
    public function index()
    {
        $this->lists();
    }

    /**
     * 客户数据列表
     */
    public function lists()
    {
        //error_reporting(E_ALL);
        $input = array_merge($this->input->get(), $this->input->post());
        $filter = array('date' => '', 'begin' => '', 'end' => '', 'operator_name' => '','city'=>'','type'=>'','place'=>'','status'=>'');
        $search = array_intersect_key($input, $filter);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
        $offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
        $where = $this->condition($search);
        $total = $this->ad_model->getCount($where);
        $list = $this->ad_model->findAlls($where,$pagesize,$offset);
        //var_dump($total);die;
        if ($total) {
            foreach ($list as $key => $item) {
                $list[$key]['city'] = $this->_getCityName($item['city']);
                $list[$key]['operate_time'] = ($item['pub_time']>$item['down_time'])?$item['pub_time']:$item['down_time'];
            }
        }
        //var_dump($search);die;
        $this->data['list'] = $list;
        $this->data['total'] = $total;
        $this->data['search'] = $search;
        $this->data['pagesize'] = $pagesize;

        //分页
        if ($total > 0) {
            $query_str = http_build_query($search);
            $this->data['pager'] = page($query_str, $total, $pagesize);
        }
        $from = $this->config->item('customer');
        $this->data['from'] = $from['source'];

        $this->layout->view('/ad/list', $this->data);
    }
    
    private function  _getCityName($city_str){
        $temp_arr = explode(',',$city_str);
        $arr = array();
        foreach ($temp_arr as $v){
            $arr[] =  isset($this->data['citylist'][$v]) ? $this->data['citylist'][$v]['city_cn'] : '-';
        }
        //var_dump($arr);die;
        return implode(',',$arr);
    }
    
    //组建where查询
    public function condition($data)
    {
        //var_dump($data);die;
        $where ='1 = 1 and a.status >=0 and b.aid IS NOT NULL  ';
        $where1 = '1=1 ';
        if (!empty($data))
        {
            if($data['date']){
                $begin = strtotime("-{$data['date']} day");
                $end = time();
                $where.=" AND a.comment_time >=$begin and a.comment_time <=$end";
            }else if($data['begin'] && $data['end']){
                $begin = isset($data['begin']) && !empty($data['begin']) ? strtotime($data['begin']) : 0;
                $end = isset($data['end']) && !empty($data['end']) ? strtotime($data['end'].'23:59:59') : time();
                $where.=" AND a.create_time >=$begin and a.create_time <=$end";
            }
            if($data['city']){
                $where1.=" AND city ='".$data['city']."'";
            }else{
                if (!empty($this->user['city_rights'])) {
                    $citys = explode(',', $this->user['city_rights']);
                    $citys = "'" . implode("','", $citys) . "'";
                    //$where["zygw.city_en in ({$citys}) AND "] = "1";
                    $where1.=" AND city in ({$citys}) ";
                    // $where['city'] = "`city` in ('$citys')";
                } 
            }
            if($data['type']){
                $where.=" AND a.type =".$data['type'];
            }
            if($data['place']){
                $where.=" AND a.place =".$data['place'];
            }
            if($data['operator_name']){
                $where.=" AND a.operator_name REGEXP '".$data['operator_name']."'";
            }
            if(isset($data['status']) && $data['status']!=''){
                $where.=" AND a.status =".$data['status'];
            }
            
        }
        return array('a'=>$where,'b'=>$where1);
    }

    
    public function add()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if ($method == 'get')
        {
            $citys = $this->house_city_model->findAll();
            $this->data['citys'] = $citys;
            $this->layout->view('/ad/add', $this->data);
        }
        
        if ($method == 'post')
        {
            $res = array('status'=>false, 'msg'=>'');
            $post = $this->input->post();
            
            if (isset($post['card']) && !empty($post['card']))
            {
                $post['pic_url'] = $post['card'];
                unset($post['card']);
            }
            if (isset($post['logo']) && !empty($post['logo']))
            {
                $post['choice_pic'] = $post['logo'];
                unset($post['logo']);
            }
            if (isset($post['openAd']) && !empty($post['openAd']))
            {
                $post['pic_url_x'] = $post['openAd'];
                unset($post['openAd']);
            }
            $filter = array('link'=>'','title'=>'','type'=>'','place'=>'','valid_start'=>'','valid_end'=>'','citys'=>'','is_choice'=>'','pic_url'=>'','choice_pic'=>'','pic_url_x'=>'');
            $data = array_intersect_key($post,$filter);
            
            $time = time();
            $extra = array('create_time'=>$time,'update_time'=>0,'pub_time'=>0,'down_time'=>0,'status'=>1,'operator_id'=>$this->user['uid'],'operator_name'=>$this->user['truename']);
            $data = array_merge($data,$extra);
            $data['city'] = $data['citys'];
            unset($data['citys']);
            $data['valid_start'] = strtotime($data['valid_start']);
            $data['valid_end'] = strtotime($data['valid_end'].' 23:59:59');
            //var_dump($this->ad_model->insertData($data));die;
            if ($insert_id = $this->ad_model->save($data))
            {
                //插入ad_city表
                $temp_city = explode(',',$data['city']);
                foreach ($temp_city as $v){
                    $this->ad_city_model->insertData(array('aid'=>$insert_id,'city'=>$v));
                }
                $res['status'] = true;
                $this->_outputJSON($res);
            }
            else
            {
                $res['msg'] = '添加失败';
                $this->_outputJSON($res);
            }
            
        }
    }
    
    public function edit()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if ($method == 'get')
        {
            if (!$id = $this->input->get('id')) {
                ci_redirect('/ad/index/lists', 3, '参数错误');
            }
            if (!$info = $this->ad_model->findByPk($id)) {
                ci_redirect('/ad/index/lists', 3, '数据错误');
            }
            //var_dump($info);die;
            $citys = $this->house_city_model->findAll();
            $this->data['citys'] = $citys;
            $this->data['info'] = $info;
            $this->data['user_citys'] = explode(',', $info['city']);
            $this->layout->view('/ad/edit', $this->data);
        }
        
        if ($method == 'post')
        {
            $res = array('status'=>false, 'msg'=>'');
            $post = $this->input->post();
            if(!$post['id']){
                $res['msg'] = '参数错误';
                $this->_outputJSON($res);
            }
            if(!$info = $this->ad_model->findByPk($post['id'])){
                $res['msg'] = '数据错误';
                $this->_outputJSON($res);
            }
            if (isset($post['card']) && !empty($post['card']))
            {
                $post['pic_url'] = $post['card'];
                unset($post['card']);
            }
            if (isset($post['logo']) && !empty($post['logo']))
            {
                $post['choice_pic'] = $post['logo'];
                unset($post['logo']);
            }
            if (isset($post['openAd']) && !empty($post['openAd']))
            {
                $post['pic_url_x'] = $post['openAd'];
                unset($post['openAd']);
            }
            $filter = array('link'=>'','title'=>'','type'=>'','place'=>'','valid_start'=>'','valid_end'=>'','citys'=>'','is_choice'=>'','pic_url'=>'','choice_pic'=>'','pic_url_x'=>'');
            $data = array_intersect_key($post,$filter);
            
            $time = time();
            $extra = array('update_time'=>$time,'operator_id'=>$this->user['uid'],'operator_name'=>$this->user['truename']);
            $data = array_merge($data,$extra);
            $data['city'] = $data['citys'];
            unset($data['citys']);
            $data['valid_start'] = strtotime($data['valid_start']);
            $data['valid_end'] = strtotime($data['valid_end'].' 23:59:59');
            //var_dump($this->ad_model->insertData($data));die;
            if ($this->ad_model->edit($post['id'],$data))
            {
                //插入ad_city表
                $this->ad_city_model->deleteAll(array('aid'=>$post['id']));
                $temp_city = explode(',',$data['city']);
                foreach ($temp_city as $v){
                    $this->ad_city_model->insertData(array('aid'=>$post['id'],'city'=>$v));
                }
                $res['status'] = true;
                $this->_outputJSON($res);
            }
            else
            {
                $res['msg'] = '编辑失败';
                $this->_outputJSON($res);
            }
            
        }
    }
    
    public function detail()
    {
        $id = (int)$this->input->get('id');
        $info = $this->ad_model->findByPk($id);
        //print_r($info);die;
        if ($info)
        {
            $info['city'] = $this->_getCityName($info['city']);
            //var_dump($info);die;
            $this->data['info'] = $info;
            $this->layout->view('/ad/detail', $this->data);
        }
        else
            ci_redirect('/ad/', 3, 'ID错误或信息不存在');
    }
    
    /**
     * 验证发布
     */
    public function verifypub()
    {
        $id = $this->input->get_post('id');
        $result = array('status'=>false,'msg'=>'操作失败','code'=>1000);
        $info = $this->ad_model->findByPk($id);
        $citys = array();
        if ($info)
        {
            if ($info['status'] != 1)//当状态不是未发布（1）不允许发布
            {
                $result = array('status'=>false,'msg'=>'非法操作','code'=>1001);
            }
            else
            {
                $result['status'] = true;
                $result['code'] = 2001;
                $result['msg'] = "确认要发布吗？";
            }
        }
        
        $this->_outputJSON($result);
    }
    
    /**
     * 发布消息
     */
    public function pub()
    {
        $id = $this->input->get_post('id');
        $result = array('status'=>false,'msg'=>'操作失败');
        if ($info = $this->ad_model->findByPk($id))
        {
            $time = time();
            if($time>$info['valid_end']){
                $result['msg'] = '有效期过期，请修改后发布';
                $this->_outputJSON($result);
            }
            if($time<$info['valid_start']){
                $msg= "广告将于".date("Y年m月d日",$info['valid_start'])."展示";
                $status = 5;
            }else{
                $msg= '广告发布成功';
                $status = 2;
            }
            $this->ad_model->updateByPk($id,array('status'=>$status,'pub_time'=>$time,'operator_id'=>$this->user['uid'],'operator_name'=>$this->user['truename']));
            $result['status'] = true; 
            $result['msg'] = $msg;
        }
        $this->_outputJSON($result);
    }

    public function del()
    {
        $id = (int)$this->input->get_post('id');
        $result = array('status'=>false,'msg'=>'操作失败');
        if ($info = $this->ad_model->findByPk($id))
        {
            if ($info['status'] != 1)
            {
                $result['msg'] = '只有未发布状态才可以删除';
            }
            else
            {
                $data['status'] = -1;
                $data['operator_id'] = $this->user['uid'];
                $data['operator_name'] = $this->user['truename'];
                if ($this->ad_model->updateByPk($info['id'],$data))
                {
                    $result['msg'] = '删除成功';
                    $result['status'] = true;
                }
                else
                {
                    $result['msg'] = '删除失败';
                }
            }
            
        }
        else
        {
            $result['msg'] = '数据不存在';
        }
        
        $this->_outputJSON($result);
    }
    
    public function down()
    {
        $id = (int)$this->input->get_post('id');
        $result = array('status'=>false,'msg'=>'操作失败');
        if ($info = $this->ad_model->findByPk($id))
        {
            if (($info['status'] == 2) || ($info['status'] == 5))
            {
                
                $data['status'] = 3;
                $data['operator_id'] = $this->user['uid'];
                $data['operator_name'] = $this->user['truename'];
                $data['down_time'] = time();
                if ($this->ad_model->updateByPk($info['id'],$data))
                {
                    $result['msg'] = '下架成功';
                    $result['status'] = true;
                }
                else
                {
                    $result['msg'] = '下架失败';
                }
            }
            else
            {
                $result['msg'] = '只有已发布/未开始状态才可以下架';
            }
            
        }
        else
        {
            $result['msg'] = '数据不存在';
        }
        
        $this->_outputJSON($result);
    }
    
    /**
     * 置业顾问排序操作
     */
    public function upsort() {
        $data = $this->input->post();
        $res = array('status' => false, 'msg' => '');
        $id = (int) $data['id'];
        $sort = $data['new_sort'];
        if (!$zygwInfo = $this->ad_model->findByPk($id)) {
            $res['msg'] = '广告不存在';
            $this->_outputJSON($res);
        }

        if ($sort >= 1000 || $sort < 0) {
            $res['msg'] = '请输入0-999之间的排序';
            $this->_outputJSON($res);
        }
        
        if ($zygwInfo['sort'] == $sort) {
            $res['status'] = true;
            $this->_outputJSON($res);
            exit;
        }
        $r = $this->ad_model->updateByPk($id, array('sort' => $sort));
        if($r){
            $res['status'] = true;
        }    
        $this->_outputJSON($res);
    }
    
}

