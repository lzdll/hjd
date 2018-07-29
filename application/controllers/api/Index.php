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
        $this->data['nav'] = array_merge($this->data['nav'], $nav);
    }

    /**
     * 客户数据首页
     */
    public function index()
    {
        $begin_time = date("Y-m-d H", strtotime("-1 hour"));
        $end_time = date("Y-m-d H");
        $ad_owner = $this->input->get_post('ad_owner');
        $st_owner = $this->input->get_post('st_owner');
        $ad_code = $this->input->get_post('ad_code');
        $st_code = $this->input->get_post('st_code');
        $where = ' `created_time`>= "'.$begin_time.'"  AND `created_time`< "'.$end_time.'"';
        if(!empty($ad_owner)){
            $where .= ' and ad_owner = "'.$ad_owner.'"';
        }
        if(!empty($st_owner)){
            $where .= ' and st_owner = "'.$st_owner.'"';
        }
        if(!empty($ad_code)){
            $where .= ' and  ad_code = "'.$ad_code.'"';
        }
        if(!empty($st_code)){
            $where .= ' and st_code = "'.$st_code.'"';
        }
        $mode = !empty($ad_owner)?0:!empty($st_owner)?1:2;
        $sql = 'SELECT sum(`slot_price`) slot_price,sum(`ad_price`) ad_price ,sum(`co_price`) co_price,if(`type`=0,if(ad_price>0,count(1),0),0) cpc
         ,if(`type`=1,if(ad_price>0,count(1),0),0) cpm ,if(`type`=0,count(1),0) total_cpc
          from wy_ad_order
         WHERE '.$where;
        $staticesInfo = $this->db->query($sql)->result_array();
        if($staticesInfo[0]['slot_price'] > 0){
            $data['ad_user_code'] = $ad_owner;
            $data['st_user_code'] = $st_owner;
            $data['ad_code'] = $ad_owner;
            $data['st_code'] = $ad_owner;
            $data['statistics_type'] = $ad_owner;
            $data['statistics_mode'] = 0;
            $data['co_price'] = $staticesInfo['co_price'];
            $data['ad_price'] = $staticesInfo['ad_price'];
            $data['slot_price'] = $staticesInfo['slot_price'];
            $data['cpc'] = $staticesInfo['cpc'];
            $data['cmp'] = $staticesInfo['cpm'];
            $data['total_cpc'] = $staticesInfo['total_cpc'];
            $data['create_time'] = date('Y-m-d H:i:s');
            $staticesInfo = $this->statistics_model->add($data);
            if($staticesInfo){
                echo '统计成功';
                #@todo添加统计每小时日志及结果
            }else{
                echo "统计失败";
                #@todo添加统计每小时日志及结果
            }
        }else{
            echo '暂无数据';die;
        }
    }


}

