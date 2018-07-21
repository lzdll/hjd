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
        return $this->updateByPk($id,$data);
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
    
    public function getDataByOwner($where,$limit = 0, $offset = 0, $sort = NULL)
    {
        $this->db->select('c.code,c.id, if(b.type=1,if(b.st_price > 0 ,sum(b.st_code),0),0) cmp,if(b.type=0,if(b.st_price > 0 ,sum(b.st_code),0),0) cpc,sum(b.st_code) ,b.st_code,sum(b.st_price) st_price');
        $this->db->from('wy_user as a');
        $this->db->join('wy_slot as c', 'a.code = c.owner','left');
        $this->db->join('wy_ad_order as b', 'a.code = b.st_owner','left');
        $this->db->where($where);
        $this->db->group_by('b.st_code');
        if($sort !== NULL) {
            $this->db->order_by($sort);
        }
        if($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        return $query->result_array();
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
    
    public function getExtensionStatices($user_code ,$begin_time,$end_time){
        
        $where = 'a.code = "'.$user_code.'" and b.created_time >= "'.$begin_time.'" and b.created_time < "'.$end_time.'"';
            
        $this->db->select('c.code,c.id, 
            if(b.type=1,if(b.st_price > 0 ,sum(b.st_code),0),0) cmp,
            if(b.type=0,if(b.st_price > 0 ,sum(b.st_code),0),0) cpc,
            sum(b.st_code) ,
            b.st_code,
            sum(b.st_price) st_price,date_format(b.created_time,"%Y-%m-%d") created_time'
        );
        $this->db->from('wy_user as a');
        $this->db->join('wy_slot as c', 'a.code = c.owner','left');
        $this->db->join('wy_ad_order as b', 'a.code = b.st_owner','left');
        $this->db->where($where);
        $this->db->group_by('created_time');
        $query = $this->db->get();
        return $query->result_array();
    }
}
