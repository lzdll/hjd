<?php
/**
 * 后台用户账号
 *
 * @package models.admin_model
 * @since 1.0
 */
class House_city_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
    public $tableName   = 'house_citys';
    public $primaryKey  = 'id';



    /**
     * 构造方法
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    
    /**
     * 日志记录
     */
    function addLog($data)
    {
        $this->db->set($data)->insert('admin_log');
    }

    /**
     * 根据id获取到用户名
     */
    public function getAll()
    {
        $data = array();
        $result = $this->findAll();
        foreach ($result as $v)
        {
            $data[$v['city_en']] = $v;
        }
        return $data;
    }

    /**
     * 根据id获取到用户名
     * 临时 获取city_code对应的city_en
     */
    public function getAllCityEn()
    {
        $data = array();
        $result = $this->findAll();
        foreach ($result as $v)
        {
            $data[$v['city_code']] = $v['city_en'];
        }
        return $data;
    }
    
    /**
     * 根据id获取
     */
    public function getAllByRights($rights = array())
    {
        $data = array();
        // if(empty($userRights))
        // {
            // return array();
        // }
        $rights = explode(',', $rights);
        $result = $this->findAll();
        foreach ($result as $k=>$v)
        {
            if (in_array($v['city_en'], $rights))
            {
                $v['checked'] = 1;
            }
            $data[$v['city_en']] = $v;
        }
        return $data;
    }
    
    /**
     * 获取用户权限城市
     */
    public function getUserCity($userCitys = array())
    {
        $result = $this->findAll(array(), 0, 0, '`city_en` asc');
        //var_dump($result);die;
        // $result = $this->findAll();
        if(!empty($userCitys)){
            $userCitys = explode(',', $userCitys);
            foreach ($result as $k=>$v)
            {
                if (!in_array($v['city_en'], $userCitys))
                {
                    unset($result[$k]);
                }
            }
        }
        return $result;
        
    }
}
