<?php
class Adprice_model extends MY_Model
{
    /**
     * @var string $tableName 表名
     */
    public $tableName   = 'ad_price';
    public $primaryKey  = 'id';

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
    function edit($id,$data)
    {
        return $this->updateByPk($id,$data);

    }
    /**
     * 获取信息 in 列表展示
     */
    function getInfoIds($where)
    {
        $this->db->from($this->tableName)->where_in('id',$where);
        $result = $this->db->get()->result_array();
//        $user = array();
//        if ($result){
//            foreach ($result as $v)
//            {
//                $user[$v['id']] = $v['real_name'];
//            }
//        }
        return $result;
    }
    /**
     * 删除
     */
    function deleteAdmin($id)
    {
        $this->deleteByPk($id,array('type'=>1));
    }

    /**
     * @desc 获取列表数据
     * @param array $where
     * @param int $limit
     * @param int $offset
     * @param null $sort
     * @return mixed
     */
    public function getList($where = array(),$limit = 0, $offset = 0, $sort = NULL)
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