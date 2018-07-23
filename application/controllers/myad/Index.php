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
        $this->load->library('session');
        $this->load->library('Ucloud/Proxy');
        $this->load->model('slot_model');
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
        $begin_time = $this->input->get('begin_time');
        $end_time = $this->input->get('end_time');
        if(empty($begin_time)){
            $begin_time = date('Y-m-d', strtotime('-7 days'));
        }
        if(empty($end_time)){
            $end_time = date('Y-m-d', time());
        }
        //广告推广量统计
        $stInfo = $this->slot_model->getExtensionStatices($this->user['code'],'',$begin_time,$end_time);
        $datedata = $this->getDateSection($begin_time, $end_time);
        $sectionCount = count(explode(',', $datedata));
        $staticesCpc = $staticesCpm = array();
        if(!empty($stInfo)){
            foreach ($stInfo as $key =>$val){
                $staticesCpc[] = $val['cpc'] ;
                $staticesCpm[] = $val['cpm'] ;
            }
        }
        $st_total = $ad_total = $avgamount = $total_cpc = $st_price = 0;
        if(count($staticesCpm) < $sectionCount){
            $max = ($sectionCount-count($staticesCpm));
            for ($i=0;$i<$max;$i++){
                $staticesCpc[] = 0;
                $staticesCpm[] = 0;
            }
        }
        //收益统计
        $stProfit = $this->slot_model->getProfitStatices($this->user['code'],$begin_time,$end_time);
        $this->data['statices'] = $stInfo;
        $this->data['section'] = $datedata;
        $this->data['st_price'] = $st_price;
        $this->data['staticesCpc'] = implode(',',$staticesCpc);
        $this->data['staticesCpm'] = implode(',',$staticesCpm);
        $this->data['date'] = $this->getDateTime();
        $this->layout->view('/myad/index', $this->data);
    }

    /**
     * 客户数据列表
     */
    public function lists()
    {
        $input = array_merge($this->input->get(), $this->input->post());
        $filter = array();
        $search = array_intersect_key($input, $filter);
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 20;
        $offset =intval($input['page']) > 0 ?intval($input['page']-1)*$pagesize:0;
        $data['owner'] = $this->user['code'];
        $total = $this->slot_model->getCount($data);
        $list = $this->slot_model->getDataByOwner($this->user['code'],$pagesize,$offset);

        $this->data['list'] = $list;
        $this->data['total'] = $total;
        $this->data['pagesize'] = $pagesize;
        $this->data['search'] = $search;
        ////分页
        if ($total > 0) {
            $this->data['pager'] = page($search, $total, $pagesize);
        }
        $this->layout->view('/myad/list', $this->data);
    }

    public function add()
    {
        //判断上传文件类型为png或jpg且大小不超过1024000B
        if(($_FILES["file"]["type"]=="image/png"||$_FILES["file"]["type"]=="image/jpeg")&&$_FILES["file"]["size"]<1024000)
        {
            $filename =date('Y/m/d')."/img/".time().$_FILES["file"]["name"];
            $filename =iconv("UTF-8","gb2312",$filename);
            $upload_file_url = $this->proxy->UploadFiles($filename,$_FILES["file"]["tmp_name"]);
        }
        //测试阶段可用
        if ( $form = $this->input->post() )
        {
            $data['platform'] = trim($form['platform']);
            $data['code'] = md5($this->user['code'].rand(0,10000));
            $data['owner'] = $this->user['code'];
            $data['name'] = trim($form['title']);
            $data['info'] = $form['desc'];
            $data['icon'] = $upload_file_url;
            $data['status'] = 1;
            $data['callback'] = $form['callback'];
            $data['callback_status'] = $form['callback_status'];
            $data['secret'] = $form['secret'];
            $data['created_time'] = date('Y-m-d H:i:s');
            $data['updated_time'] = date('Y-m-d H:i:s');
            $res = array('status'=>false, 'msg'=>'');
            $this->_save($data);
            ci_redirect('/myad/index/lists');
        }
        $this->layout->view('/myad/add', $this->data);
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
    
    public function details()
    {
        $id = (int)$this->input->get('id');
        $begin_time = $this->input->get('begin_time');
        $end_time = $this->input->get('end_time');
        $info = $this->slot_model->findByPk($id);
        if(empty($begin_time)){
            $begin_time = date('Y-m-d', strtotime('-7 days'));
        }
        if(empty($end_time)){
            $end_time = date('Y-m-d', time());
        }
        if ($info)
        {
            $stInfo = $this->slot_model->getExtensionStatices($this->user['code'],$id,$begin_time,$end_time);
            $datedata = $this->getDateSection($begin_time, $end_time);
            $sectionCount = count(explode(',', $datedata));
            $staticesCpc = $staticesCpm = array();
            if(!empty($stInfo)){
                foreach ($stInfo as $key =>$val){
                    $staticesCpc[] = $val['cpc'] ;
                    $staticesCpm[] = $val['cpm'] ;
                }
            }
            $st_total = $ad_total = $avgamount = $total_cpc = $st_price = 0;
            if(count($staticesCpm) < $sectionCount){
                $max = ($sectionCount-count($staticesCpm));
                for ($i=0;$i<$max;$i++){
                    $staticesCpc[] = 0;
                    $staticesCpm[] = 0;
                    $st_total += $val['st_total'];
                    $ad_total += $val['ad_total'];
                    $avgamount += $val['avgamount'];
                    $total_cpc += $val['total_cpc'];
                    $st_price += $val['st_price'];
                }
            }
            $avgamount = sprintf("%.2f",$avgamount/$sectionCount);
            $this->data['info'] = $info;
            $this->data['statices'] = $stInfo;
            $this->data['section'] = $datedata;
            $this->data['st_price'] = $st_price;
            $this->data['staticesCpc'] = implode(',',$staticesCpc);
            $this->data['staticesCpm'] = implode(',',$staticesCpm);
            $this->data['date'] = $this->getDateTime();
            $this->layout->view('/myad/detail', $this->data);
        }
        else
            ci_redirect('/myad/index/lists', 3, 'ID错误或信息不存在');
    }
    
    public function intercalate()
    {
        $id = (int)$this->input->get('id');
        if ( $form = $this->input->post() )
        {
            $data['secretkey'] = $form['secretkey'];
            $data['serviceUrl'] = $form['serviceUrl'];
            $data['id'] = $form['id'];
            $res = array('status'=>false, 'msg'=>'');
            $this->_save($data);
            ci_redirect('/myad/index/lists');
        }else {
            $info = $this->slot_model->findByPk($id);
            if(!$info){
                ci_redirect('/myad/index/lists', 3, 'ID错误或信息不存在');
            }
            $this->data['info'] = $info;
            $this->data['id'] = $id;
            $this->layout->view('/myad/intercalate', $this->data);
        }
            
    }
    
    private function getDateSection($startdate, $enddate){
        
        $stimestamp = strtotime($startdate);
        $etimestamp = strtotime($enddate);
        // 计算日期段内有多少天
        $days = ($etimestamp-$stimestamp)/86400+1;
        // 保存每天日期
        $str = '';
        for($i=0; $i<$days; $i++){
            $str .= "'".date('n.j', $stimestamp+(86400*$i))."',";
        }
        
        return mb_substr($str, 0,-1);
    }
    private function getDateTime(){
        $date['today']['begin_date'] = date("Y-m-d");
        $date['today']['end_date'] = date("Y-m-d",strtotime("+1 day"));
        $date['yesterday']['begin_date'] = date("Y-m-d",strtotime("-1 day"));
        $date['yesterday']['end_date'] = date("Y-m-d");
        $date['week']['begin_date'] = date("Y-m-d",strtotime("-1 week"));
        $date['week']['end_date'] = date("Y-m-d");
        $date['month']['begin_date'] = date("Y-m-01");
        $date['month']['end_date'] = date("Y-m-d");
        
        return $date; 
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
    protected function _save($data){
        $id = intval($data['id']);
        if ( !$id )
        {
            if ( !$rs = $this->slot_model->add($data) )
            {
                return false;
            }
            return true;
        }
        if ( !$rs = $this->slot_model->edit($id, $data) )
        {
            return false;
        }
        return true;
    }
    
}

