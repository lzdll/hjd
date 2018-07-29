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
	public $wy_account = 'wy_account';
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
			$sql = "select a.*,a.user_code as code,b.credit from ".$this->wy_user." AS a LEFT JOIN wy_account as b on a.user_code= b.owner where {$where} order by a.id desc limit $offset,$limit";
	   }else{
			$sql = "select *,a.user_code code from wy_user AS a LEFT JOIN wy_account as b on a.user_code= b.owner where {$where} order by a.id desc order by a.id desc";
	   }
       $row = $this->db->query($sql)->result_array();
	   return $row;
    }
	public function getCount($where)
    {
        $sql = "select count(1) as total from ".$this->wy_user." where $where";
        $row = $this->db->query($sql)->row();
        return (int)$row->total;
    }
	//获取流量主广告数
	public function getAdCount($where){
		$sql = "select count(1) as total from ".$this->wy_ad." where $where limit 1";
        $row = $this->db->query($sql)->row();
        return (int)$row->total;
	}
	//充值总额 余额总额
	public function getAccount($where){
		$sql = "select sum(total_money) as total_money,sum(money) as money from ".$this->wy_account." where $where limit 1";
        $row = $this->db->query($sql)->result_array();
        return $row[0];
	
	}
	//充值总额 余额总额
	public function getAccountId($where){
		$sql = "select *,account_code code from ".$this->wy_account." where $where limit 1";
        $row = $this->db->query($sql)->result_array();
        return $row[0];
	
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

	//获取充值次数 金额
	public function getFinaCount($data)
    {
		$where=' 1=1';
		if($data['code']){
			$where=" owner='".$data['code']."'";			
		}
        $sql = "SELECT cz_money,tx_money,total FROM ( 
				SELECT
				IF(subject=0,SUM(money),0) tx_money,
				IF(subject=1,SUM(money),0) cz_money,
			COUNT(1) as total
				FROM
				wy_finance
				WHERE ".$where." limit 1
           ) t";
        $row = $this->db->query($sql)->result_array();
		return $row[0];
    }
	//所有广告统计
	 public function getExtensionStatices($user_code,$begin_time,$end_time){
        $where = ' 1=1 and `c`.`owner` ="'.$user_code.'" AND b.created_time >= "'.$begin_time.'" and b.created_time < "'.$end_time.'" ';
		$sql="SELECT id,`code`,cpc,cpm,totalcpc,totalAd,IF (st_price>0,st_price,0) st_price ,FORMAT((st_price/cpc),2) avg_price FROM(
            SELECT c.id,c.`slot_code` as code,
            	COUNT(distinct(b.ad_code)) totalAd,
                IF (b.type = 0,IF (b.slot_price > 0, COUNT(1), 0), 0) cpc,
                IF (b.type = 1,IF (b.slot_price > 0, COUNT(1), 0), 0) cpm,
                COUNT(type) totalcpc,
            	SUM(b.slot_price) st_price,
                DATE_FORMAT(b.created_time,'%Y-%m-%d') d
            FROM `wy_slot` AS `c`
            LEFT JOIN `wy_ad_order` AS `b` ON `c`.`owner` = `b`.`slot_owner`
            WHERE
            	".$where."
            GROUP BY d
            ) t";
		$data = $this->db->query($sql)->result_array();
        return $data;
    }
	//获取交易流水
	public function getAdprice($user_code,$begin_time,$end_time){
		$where = ' ad_price > 0 AND ad_owner="'.$user_code.'" and created_time >= "'.$begin_time.'" and created_time < "'.$end_time.'" ';
		$sql="SELECT adprice,coprice,d FROM ( 
				SELECT
				IF(ad_price > 0, SUM(ad_price), 0)  adprice, 
				IF(co_price > 0, SUM(co_price), 0) coprice,
			DATE_FORMAT(created_time,'%Y-%m-%d') d
				FROM
				`wy_ad_order`
				WHERE ".$where."
            GROUP BY d ) t";
		$row = $this->db->query($sql)->result_array();
	    return $row;
	}

  //根据user_code 获取广告列表
  public function findAdAlls($data = array(), $limit = 0, $offset = 0, $sort = NULL)
    {
	  $where ="1=1";
	  if($data['user_code']){
			$where .=" AND `c`.`owner`= '".$data['user_code']."'";
	  }
	  $sql = "SELECT c.id, c.`ad_code` as code,c.`name`,c.owner,c.ws_code,
        c.appid,c.status ,c.audit_status ,
        IF(b.type=0,IF(b.slot_price>0,COUNT(1),0),0) cpc,
        IF(b.type=1,IF(b.slot_price>0,COUNT(1),0),0) cpm,
        IF(b.type=0,COUNT(1),0) totalcpc,
        IF(b.slot_price>0,SUM(b.slot_price),0) st_price,
        IF(b.ad_price>0,SUM(b.ad_price),0) ad_price 
        FROM 
        `wy_ad` AS `c` LEFT JOIN `wy_ad_order` AS `b` ON `c`.`ad_code` = `b`.`ad_code` 
        WHERE ".$where." GROUP BY
	`c`.`ad_code` ORDER BY c.created_time DESC ";
       $row = $this->db->query($sql)->result_array();
	   return $row;
    }
}

 