<?php
/**
 * 角色
 *
 * @package models.slot_model
 * @since 1.0
 */
class Slot_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
    public $tableName   = 'slot';
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
    
    /**
     * 
     */
    public function findAlls($where = array(), $limit = 0, $offset = 0, $sort = NULL)
    {
        return parent::findAll($where, $limit, $offset, $sort); 
    }
    public function getCount($where) {
        $where = $this->_where($where);
        $sql = "select count(1) as total from wy_slot where $where";
        $row = $this->db->query($sql)->row();
        return (int)$row->total;
    }
    
    public function getDataByOwner($ucode,$limit = 0, $offset = 0, $sort = NULL)
    {
        $data = $this->db->query("SELECT id,code,cpc,cpm,cpc/(cpc+cpm) rate, totalcpc,st_price FROM ( SELECT
            c.id,c.`code`,IF(b.type=0,IF(b.st_price>0,COUNT(1),0),0) cpc,IF(b.type=1,IF(b.st_price>0,COUNT(1),0),0) cpm,IF(b.type=0,COUNT(1),0) totalcpc,IF(b.st_price>0,SUM(b.st_price),0) st_price
            FROM
            	`wy_slot` AS `c`
            LEFT JOIN `wy_ad_order` AS `b` ON `c`.`owner` = `b`.`st_owner`
            WHERE
            	`c`.`owner` = '".$ucode."'
            GROUP BY
            	`c`.`code`
            ) t limit $offset,$limit")->result_array();;
        return $data;
    }
    /**
     * 根据id获取到用户名
     */
    public function getNameById($id)
    {
        if(empty($id))
        {
            return false;
        }
        $result = $this->findByPk($id);
        return $result;
    }
    
    private function _where($where) {
        $_where = array();
        foreach ($where as $k => $v) {
            if (!empty($v)) {
                array_push($_where, "{$k}='{$v}'");
            }
        }
        $_where && $_where = implode(' AND ', $_where);
        return $_where;
    }
    
    public function getExtensionStatices($user_code ,$st_id,$begin_time,$end_time){
        $where = ' c.owner = "'.$user_code.'" and b.created_time >= "'.$begin_time.'" and b.created_time < "'.$end_time.'" ';
        if(!empty($st_id) && $st_id > 0){
            $where .= ' and c.id= '.$st_id ;           
        }
        $data = $this->db->query("SELECT id,`code`,cpc,cpm,totalcpc,totalAd,IF (st_price>0,st_price,0) st_price ,FORMAT((st_price/cpc),2) avg_price FROM(
            SELECT c.id,c.`code`,
            	COUNT(distinct(b.ad_code)) totalAd,
                IF (b.type = 0,IF (b.st_price > 0, COUNT(1), 0), 0) cpc,
                IF (b.type = 1,IF (b.st_price > 0, COUNT(1), 0), 0) cpm,
                COUNT(type) totalcpc,
            	SUM(b.st_price) st_price,
                DATE_FORMAT(b.created_time,'%Y-%m-%d') d
            FROM `wy_slot` AS `c`
            LEFT JOIN `wy_ad_order` AS `b` ON `c`.`owner` = `b`.`st_owner`
            WHERE
            	".$where."
            GROUP BY d
            ) t")->result_array();
        return $data;
    }
    public function getProfitStatices($user_code,$begin_time,$end_time){
        
    }
}
