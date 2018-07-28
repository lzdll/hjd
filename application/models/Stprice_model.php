<?php
class Stprice_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
    public $tableName   = 'slot_price';
    public $primaryKey  = 'id';

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
    
    function updateslotprice($sets,$where){
        return $this->updateAll($sets, $where);
    }
}