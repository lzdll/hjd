<?php
/**
 * 
 * 财务中心 model
 * @package models.audit
 * @since 1.0
 */
class Finance_model extends MY_Model
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
			$sql = "select id,code  from ".$this->_wy_user." where $where AND id>0 order by id desc limit $offset,$limit";
	   }else{
			$sql = "select id,code  from ".$this->_wy_user." where $where AND id>0 order by id desc";
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
	/**
     * 发票列表
     *
     * @param array $where
     * @return array
     */
	public function findInvoice($where = array(), $limit = 0, $offset = 0, $sort = NULL)
    {
	   if(isset($limit)){
			$sql = "select *  from ".$this->wy_invoice." where $where AND id>0 order by id desc limit $offset,$limit";
	   }else{
			$sql = "select *  from ".$this->wy_invoice." where $where AND id>0 order by id desc";
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
    /**
     * @desc 获取列表数据
     * @param array $where
     * @param int $limit
     * @param int $offset
     * @param null $sort
     * @return mixed
     */
    public function getLists($where = array(),$limit = 0, $offset = 0, $sort = NULL)
    {
        $this->db->where($where);
        $this->db->from($this->tableName);
        //在order、group或limit前查询总数
        $db = clone($this->db);
        $count = $db->count_all_results();
        $this->db->order_by('updated_time','DESC');
        if($sort !== NULL) {
            $this->db->order_by($sort);
        }
        if($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        
        return array('list'=>$query->result_array(),'cnt'=>$count);
    }
}

 