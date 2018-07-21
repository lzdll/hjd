<?php
/**
 * 流量主 model
 * @package models.audit
 * @since 1.0
 */
class Flow_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
	public $wy_user = 'user';
	public $wy_ad = 'ad';
    public $primaryKey = 'id';

    /**
     * 构造方法
     *
     * @return void
     */
    public function __construct()
    {
		
		$this->wy_user = $this->db->dbprefix.$this->wy_user;
		$this->wy_ad = $this->db->dbprefix.$this->wy_ad;
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
			$sql = "select *  from ".$this->wy_user." where $where AND id>0 order by id desc limit $offset,$limit";
	   }else{
			$sql = "select *  from ".$this->wy_user." where $where AND id>0 order by id desc";
	   }
       $row = $this->db->query($sql)->result_array();
	   return $row;
    }
	public function getCount($where)
    {
        $sql = "select count(1) as total from ".$this->wy_user." where $where limit 1";
        $row = $this->db->query($sql)->row();
        return (int)$row->total;
    }
	//获取流量主广告数
	public function getAdCount($where){
		$sql = "select count(1) as total from ".$this->wy_ad." where $where limit 1";
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
		   if($data['type']){
				$where.=" AND type =".$data['type'];
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

 