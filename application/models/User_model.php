<?php
/**
 * 后台用户账号
 *
 * @package models.admin_model
 * @since 1.0
 */
class User_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
    public $tableName   = 'user';
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
     * 根据条件获取信息
     */
    function getInfo($data)
    {
        return $this->findByAttributes($data);
    }
    /**
     * 更新登陆时间
     */
    public function updateLogin($id)
    {
        $this->updateAll(array('login_time'=>time()), array('passport_id'=>$id));
    }
    /**
     * 添加
     */
    function add($data)
    {
        return $this->insertData($data);
    }
    /**
     * 编辑
     */
    function edit($id,$data)
    {
        return $this->updateByPk($id,$data);
        
    }
    /**
     * 获取用户信息 in 前台列表展示
     */
    function getInfoIds($where)
    {
        $this->db->from($this->tableName)->where_in('id',$where);
        $result = $this->db->get()->result_array();
        $user = array();
        if ($result){
            foreach ($result as $v)
            {
                $user[$v['id']] = $v['real_name'];
            }
        }
        return $user;
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
    public function getNameById($uid)
    {
    	if(empty($uid))
		{
			return false;
		}
		$result = $this->findByPk($uid);
		return $result;
    }
    
    /**
     * 删除
     */
    function deleteAdmin($id)
    {
    	$this->deleteByPk($id);
    }

}
