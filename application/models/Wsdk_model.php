<?php
/**
 * 
 * 财务中心 model
 * @package models.audit
 * @since 1.0
 */
class Wsdk_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
    public $tableName = 'wsdk';
	

    /**
     * 构造方法
     *
     * @return void
     */
    public function __construct()
    {
		$this->tablename = $this->db->dbprefix.$this->tableName;
		
        parent::__construct();
    }
    /**
     * Find Record By Attributes
     *
     * @param array $where
     * @return array
     */
    public function findByAttributes($where = array(), $order = '')
    {
        return parent::findByAttributes($where, $order);
    }
    public function findAlls($where = array(), $limit = 0, $offset = 0, $sort = NULL)
    {
	   if(isset($limit)){
			$sql = "select * ,sdk_code code  from ".$this->tablename." where $where AND id>0 order by id desc limit $offset,$limit";
	   }else{
			$sql = "select * ,sdk_code code  from ".$this->tablename." where $where AND id>0 order by id desc";
	   }
       $row = $this->db->query($sql)->result_array();
	   return $row;
    }
	


	public function getCount($where)
    {
        $sql = "select count(1) as total from ".$this->tablename." where $where";
        $row = $this->db->query($sql)->row();
        return (int)$row->total;
    }
	//组建where查询
    public function conditions($data)
    {
		$where ='1 = 1 ANd id>0';
        if (!empty($data))
        {
		    //用户申请手机号
		   if($data['audit_name']){
				$where.=" AND proposer ='".$data['audit_name']."'";
		   }
        }
        return $where;
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
	
}

 