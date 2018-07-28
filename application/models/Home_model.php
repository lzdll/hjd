<?php
/**
 * Home_model model
 * @package models.audit
 * @since 1.0
 */
class Home_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
	public $wy_user = 'user';
	public $wy_ad = 'ad';
	public $wy_ad_price = 'ad_price';
    public $primaryKey = 'id';
	public $tableName   = 'ad';

    /**
     * 构造方法
     *
     * @return void
     */
    public function __construct()
    {
		$this->wy_user = $this->db->dbprefix.$this->wy_user;
		$this->wy_ad = $this->db->dbprefix.$this->wy_ad;
		$this->wy_ad_price = $this->db->dbprefix.$this->wy_ad_price;
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
	//获取上周点击冠军
    public function getOne($where = array(), $limit = 1)
    {
	   $sql = "SELECT c.id,c.`ad_code` as code,c.`name`,
                IF (b.type = 0,IF (b.slot_price > 0, COUNT(1), 0),0) cpc,
                IF (b.type = 1,IF (b.slot_price > 0, COUNT(1), 0),0) cpm,
                IF (b.type = 0, COUNT(1), 0) totalcpc,
                IF (b.slot_price > 0,
                SUM(b.slot_price),0) st_price,
                IF (b.ad_price > 0,SUM(b.ad_price),0) ad_price 
        FROM`wy_ad` AS `c` LEFT JOIN 
        `wy_ad_order` AS `b` ON `c`.`ad_code` = `b`.`ad_code` 
        WHERE 1 = 1 AND c.id > 0 GROUP BY `c`.`ad_code`
		ORDER BY b.slot_price DESC LIMIT 1";
       $row = $this->db->query($sql)->result_array();
	   return $row;
    }

		//获取上周点击冠军
    public function getOtherList($where = array(), $limit = 1)
    {
	   $sql = "SELECT cpc,cpm,cpc/(cpc+cpm) rate,ad_price,totalcpc,st_price FROM ( 
				SELECT
				IF(type=0,IF(slot_price>0,COUNT(1),0),0) cpc,
				IF(type=1,IF(slot_price>0,COUNT(1),0),0) cpm,
				IF(ad_price>0,SUM(ad_price),0) ad_price,
				IF(type=0,COUNT(1),0) totalcpc,
				IF(slot_price>0,SUM(slot_price),0) st_price
				FROM
				wy_ad_order
				WHERE
				created_time > CURDATE() AND created_time < ADDDATE(created_time,INTERVAL 1 DAY)
				) t";
       $row = $this->db->query($sql)->result_array();
	   return $row;
    }

	//流量池金主
    public function getMower($where = array(), $limit = 1)
    {
	   $star_time = date("Y-m-d")." 00:00:00";
	   $end_time = date("Y-m-d")." 23:59:59";
	   $sql = "SELECT SUM(money) as day_money FROM wy_finance 
            WHERE  subject=1 AND created_time > '".$star_time."' 
            AND created_time < '".$end_time."'";
       $row = $this->db->query($sql)->result_array();
	   return $row;
    }

	//所有广告统计
	 public function getExtensionStatices($begin_time,$end_time){
        $where = ' 1=1 and b.created_time >= "'.$begin_time.'" and b.created_time < "'.$end_time.'" ';
		$data = $this->db->query("SELECT id,`code`,cpc,cpm,totalcpc,totalAd,
                    IF (st_price>0,st_price,0) st_price ,
                    FORMAT((st_price/cpc),2) avg_price FROM(
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
            ) t")->result_array();
        return $data;
    }

	public function getFinance($begin_time,$end_time){
		$where = ' 1=1 and created_time >= "'.$begin_time.'" and created_time < "'.$end_time.'" ';
		$sql="SELECT money1,money2,d FROM ( 
				SELECT
				IF(subject=0,SUM(money),0) money1,
				IF(subject=1,SUM(money),0) money2,
			DATE_FORMAT(created_time,'%Y-%m-%d') d
				FROM
				wy_finance
				WHERE ".$where."
            GROUP BY d ) t";
		$row = $this->db->query($sql)->result_array();
	    return $row;
	}
	//获取交易流水
	public function getAdprice($begin_time,$end_time){
		$where = ' ad_price > 0 and created_time >= "'.$begin_time.'" and created_time < "'.$end_time.'" ';
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
	//用户画像
	public function getUsersex($begin_time,$end_time){
		$where = ' 1=1 and created_time >= "'.$begin_time.'" and created_time < "'.$end_time.'" ';
		$sql="select 
				COUNT(case when sex = 0 then sex end  ) as maleCount,
				COUNT(case when sex = 1 then sex end ) as femaleCount,
				COUNT(case when sex = 2 then sex end ) as otherCount,
				COUNT(case when sex IN(0,1,2) then sex end) as allCount,
				FORMAT(COUNT(case when sex = 0 then sex end  )/COUNT(case when sex IN(0,1,2) then sex end),2) as maleRate,
				FORMAT(COUNT(case when sex = 1 then sex end )/COUNT(case when sex IN(0,1,2) then sex end),2) as femaleRate,
				FORMAT(COUNT(case when sex = 2 then sex end )/COUNT(case when sex IN(0,1,2) then sex end),2) as otherRate
				from  wy_ad_order ";
		$row = $this->db->query($sql)->result_array();
	    return $row;
	}

	
}

 