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
    function edit($id,$status)
    {
        $data=array(
        'status'=> $status,
        'updated_time'=>date("Y-m-d H:i:s",time()),
    );
        $this->db->where('id',$id);
        return $this->updateByPk($id,$data);

    }
    /**
     * 获取信息 in 列表展示
     */
    function getInfoIds($id,$ucode)
    {
        $sql = "select a.platform,a.`name`,a.info,a.image,a.banner,a.icon,a.link,a.appid,a.ws_code,a.`status`,a.audit_status,b.type,b.price from wy_ad AS a LEFT JOIN wy_ad_price AS b ON a.code = b.ad_code WHERE a.id={$id} AND b.type=0 AND a.owner='{$ucode}'";
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
                                c.id,c.`code`,c.`name`,c.`status`,c.`audit_status`,d.price,
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
                    LEFT JOIN `wy_ad_price` AS `d` ON `c`.`code` = `d`.`ad_code`
                    WHERE
                        `c`.`owner` = '".$ucode."'
                    GROUP BY
                        `c`.`code`
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

}
