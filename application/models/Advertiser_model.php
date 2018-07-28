<?php
class Advertiser_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
    public $tableName   = 'ad';
    public $wy_ad_price = 'ad_price';
    public $wy_ad_order = 'ad_order';
    public $primaryKey  = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->wy_ad_price = $this->db->dbprefix.$this->wy_ad_price;
        $this->wy_ad_order = $this->db->dbprefix.$this->wy_ad_order;
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
    function edit($id,$status,$price)
    {
        if($price>0){
            $sql = "update wy_ad a LEFT JOIN wy_ad_price b ON a.ad_code = b.ad_code set b.price = {$price} WHERE a.id = {$id}";
            $res = $this->db->query($sql);
            return $res;
        }else{
            $data=array(
                'status'=> $status,
                'updated_time'=>date("Y-m-d H:i:s",time()),
            );
            $this->db->where('id',$id);
            return $this->updateByPk($id,$data);
        }


    }
    /**
     * 获取信息 in 列表展示
     */
    function getInfoIds($id,$ucode)
    {
        $sql = "select a.platform,a.`name`,a.info,a.image,a.banner,a.icon,a.link,a.appid,a.ws_code,a.`status`,a.audit_status,b.type,b.price from wy_ad AS a LEFT JOIN wy_ad_price AS b ON a.ad_code = b.ad_code WHERE a.id={$id} AND b.type=0 AND a.owner='{$ucode}'";
        $result = $this->db->query($sql)->row_array();
        return $result;
    }
    /**
     * 删除
     */
    function deleteById($id)
    {
//        $sql = "delete from wy_ad where id = $id";
//        return $res = $this->query($sql);
        return $res = $this->deleteAll($where=array('id'=>$id));
    }

    /**
     * 广告列表
     *
     * @param array $where
     * @return array
     */
    public function adlist($ucode,$limit = 0, $offset = 0)
    {
        if(isset($limit)){
            $sql =
                "SELECT
                        id,CODE,cpc,cpm,(totalcpc + totalcpm) / (cpc + cpm) rate,totalcpc,totalcpm,ad_sumprice,status,audit_status,`name`,price
                    FROM
                        (
                            SELECT
                                c.id,c.`ad_code` as code,c.`name`,c.`status`,c.`audit_status`,d.price,
                            IF (
                                b.type = 0,

                            IF (b.ad_price > 0, COUNT(1), 0),
                            0
                            ) cpc,

                        IF (
                            b.type = 1,

                        IF (b.ad_price > 0, COUNT(1), 0),
                        0
                        ) cpm,

                    IF (b.type = 0, COUNT(1), 0) totalcpc,
                    IF (b.type = 1, COUNT(1), 0) totalcpm,

                    IF (
                        b.ad_price > 0,
                        SUM(b.ad_price),
                        0
                    ) ad_sumprice
                    FROM
                        `wy_ad` AS `c`
                    LEFT JOIN `wy_ad_order` AS `b` ON `c`.`owner` = `b`.`ad_owner`
                    LEFT JOIN `wy_ad_price` AS `d` ON `c`.`ad_code` = `d`.`ad_code`
                    WHERE
                        `c`.`owner` = '".$ucode."'
                    GROUP BY
                        `c`.`ad_code`
                    ORDER BY c.created_time desc
                        ) t
                    LIMIT $offset,
                     $limit";
        }else{
            $sql = "select *  from ".$this->wy_invoice." where $where AND id>0 order by id desc";
        }
        $row = $this->db->query($sql)->result_array();
        return $row;
    }

    /**
     * 广告推广量统计
     * @param $user_code
     * @param $st_id
     * @param $begin_time
     * @param $end_time
     * @return mixed
     */
    public function getExtensionStatices($user_code ,$ad_id,$begin_time,$end_time){
        $where = ' c.owner = "'.$user_code.'" and b.created_time >= "'.$begin_time.'" and b.created_time < "'.$end_time.'" ';
        if(!empty($ad_id) && $ad_id > 0){
            $where .= ' and c.id= '.$ad_id ;
        }
        $data = $this->db->query("SELECT id,`code`,cpc,cpm,totalcpc,totalAd,IF (ad_price>0,ad_price,0) st_price ,FORMAT((ad_price/cpc),2) avg_price FROM(
            SELECT c.id,c.`code`,
            	COUNT(distinct(b.ad_code)) totalAd,
                IF (b.type = 0,IF (b.ad_price > 0, COUNT(1), 0), 0) cpc,
                IF (b.type = 1,IF (b.ad_price > 0, COUNT(1), 0), 0) cpm,
                COUNT(type) totalcpc,
            	SUM(b.ad_price) ad_price,
                DATE_FORMAT(b.created_time,'%Y-%m-%d') d
            FROM `wy_ad` AS `c`
            LEFT JOIN `wy_ad_order` AS `b` ON `c`.`owner` = `b`.`ad_owner`
            WHERE
            	".$where."
            GROUP BY d
            ) t")->result_array();
        return $data;
    }

}
