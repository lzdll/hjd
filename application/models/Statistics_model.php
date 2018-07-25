<?php
/**
 * 任务
 *
 * @package models.task_model
 * @since 1.0
 */
class Statistics_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
    public $tableName = 'statistics';
    public $primaryKey = 'id';

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
     * 添加
     */
    function add($data)
    {
        return $this->insertData($data);
    }
}

