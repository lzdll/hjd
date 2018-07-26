<?php
/**
 *
 *编码查询
 *
 * @since 1.0
 */
class Code_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
    public $tableName   = 'code';
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
     * 生成8位唯一编码
     */
    function getCode()
    {
        $str = '';
        $strPool = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        for($i=0;$i<=7;$i++)
        {
            $rand = rand(0,61);
            $str .= $strPool[$rand];
        }
        $sql = "select count(1) AS counts from wy_code WHERE code ='{$str}'";
        $res = $this->db->query($sql)->row_array();
        if($res['counts'] == 0){
           self::add(array('code'=>$str));
            return $str;
        }else{
            self::getCode();
        }
    }

    function add($data)
    {
        return $this->insertData($data);
    }


}
