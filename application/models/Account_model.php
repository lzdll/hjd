<?php
/**
 * 后台用户账号
 *
 * @package models.account_model
 * @since 1.0
 */
class Account_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
    public $tableName   = 'account';
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
}
