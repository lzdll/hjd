<?php
/**
 * 
 * 财务中心 model
 * @package models.audit
 * @since 1.0
 */
class Audit_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
    public $tableName = 'finance';
	public $wy_user = 'user';
	public $wy_invoice = 'invoice';
    public $primaryKey = 'id';

    /**
     * 构造方法
     *
     * @return void
     */
    public function __construct()
    {
		$this->tablename = $this->db->dbprefix.$this->tableName;
		$this->_wy_user = $this->db->dbprefix.$this->wy_user;
		$this->wy_invoice = $this->db->dbprefix.$this->wy_invoice;
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
			$sql = "select *  from ".$this->tablename." where $where AND id>0 order by id desc limit $offset,$limit";
	   }else{
			$sql = "select *  from ".$this->tablename." where $where AND id>0 order by id desc";
	   }
       $row = $this->db->query($sql)->result_array();
	   return $row;
    }
	//获取用户编码
	public function getUserCode($where = array(), $limit = 0, $offset = 0, $sort = NULL)
    {
	   if(isset($limit)){
			$sql = "select id,user_code code from ".$this->_wy_user." where $where AND id>0 order by id desc limit $offset,$limit";
	   }else{
			$sql = "select id,user_code code  from ".$this->_wy_user." where $where AND id>0 order by id desc";
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
     * 发票列表
     *
     * @param array $where
     * @return array
     */
	public function findInvoice($where = array(), $limit = 0, $offset = 0, $sort = NULL)
    {
	   if(isset($limit)){
			$sql = "select *,invoice_code as code  from ".$this->wy_invoice." where $where AND id>0 order by id desc limit $offset,$limit";
	   }else{
			$sql = "select *,invoice_code as code  from ".$this->wy_invoice." where $where AND id>0 order by id desc";
	   }
       $row = $this->db->query($sql)->result_array();
	   return $row;
    }

	public function getInvoiceCount($where)
    {
        $sql = "select count(1) as total from ".$this->wy_invoice." where $where";
        $row = $this->db->query($sql)->row();
        return (int)$row->total;
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

 