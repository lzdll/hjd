<?php
/**
 * 角色
 *
 * @package models.slot_model
 * @since 1.0
 */
class Company_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
    public $tableName   = 'company';
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
    function getRowByAttr($data)
    {
        return $this->findByAttributes($data);
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
    function edit($id, $data)
    {
        unset($data['id']);
        $rUp =$this->db->where(array('id'=>$id))->update($this->tableName, $data);
        return $rUp;
    }

	 /**
     * 根据条件获取信息
     */
    function getInfo($data)
    {
        return $this->findByAttributes($data);
    }
}
