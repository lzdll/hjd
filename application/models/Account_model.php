<?php
/**
 * 后台用户账号
 *
 * @package models.account_model
 * @since 1.0
 */
class Account_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
    public $tableName   = 'account';
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
    function getInfo($data)
    {
        return $this->findByAttributes($data);
    }

    function getTodayProfit($ucode){
        $begin_time = date('Y-m-d');
        $end_time = date('Y-m-d',strtotime('+1 day'));
        $data = $this->db->query("SELECT id,code,name,cpc,cpm,cpc/(cpc+cpm) rate, totalcpc,st_price FROM ( SELECT
            c.id,c.`code`,c.`name`,IF(b.type=0,IF(b.st_price>0,COUNT(1),0),0) cpc,IF(b.type=1,IF(b.st_price>0,COUNT(1),0),0) cpm,IF(b.type=0,COUNT(1),0) totalcpc,IF(b.st_price>0,SUM(b.st_price),0) st_price
            FROM
            	`wy_slot` AS `c`
            LEFT JOIN `wy_ad_order` AS `b` ON `c`.`owner` = `b`.`st_owner`
            WHERE
            	`c`.`owner` = '".$ucode."'
                AND `c`.`created_time` >='".$begin_time."'
                 AND `c`.`created_time` <'".$end_time."'
            ) t ")->result_array();
        return $data;
    }
    function getFinanceInfo($user_code,$begin_time,$end_time){
        $where = ' a.owner = "'.$user_code.'" and a.created_time >= "'.$begin_time.'" and a.created_time < "'.$end_time.'" ';
        $sql = "select sum(a.money), DATE_FORMAT(b.created_time,'%Y-%m-%d') d  money from wy_finance WHERE  '{$where}' AND a.`status` = 0 GROUP BY d";
    }

    /**
     * 编辑
     */
    function edit($owner,$quota)
    {
        $sql = "update wy_account set quota = {$quota} WHERE owner = '{$owner}'";
        $res = $this->db->query($sql)->result_array();
        return $res;
    }
}
