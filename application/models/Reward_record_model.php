<?php

/**
 */
class Reward_record_model extends MY_Model {

    /**
     * @var string $tableName 表名
     */
    public $tableName = 'reward_record';
    public $primaryKey = 'id';

    /**
     * 构造方法
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @desc 获取列表数据
     * @param array $where
     * @param int $limit
     * @param int $offset
     * @param null $sort
     * @return mixed
     */
    public function getList($where = array(), $limit = 0, $offset = 0, $sort = NULL) {
        $this->db->where($where);
        $this->db->from($this->tableName);
        //在order、group或limit前查询总数
        $db = clone($this->db);
        $count = $db->select_sum('quoat')->get()->row_array();
        $this->db->order_by('updatetime', 'DESC');
        if ($sort !== NULL) {
            $this->db->order_by($sort);
        }
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();

        return array('list' => $query->result_array(), 'cnt' => $count['quoat']);
    }

    /**
     * @desc 获取列表数据
     * @param array $where
     * @param int $limit
     * @param int $offset
     * @param null $sort
     * @return mixed
     */
    public function getListToZygw($where = array(), $limit = 0, $offset = 0, $sort = NULL, $count = 0) {
        $this->db->where($where);
        $this->_condition($where);
        $this->db->select('a.cid,a.phone,b.username,b.mobile,a.createtime,b.id,b.create_time,b.status,b.hid');
        $this->db->from('laike_customer_id as a');
        $this->db->join('laike_zygw as b', 'a.zid = b.id', 'left');
        //$this->db->group_by("a.cid");
        $this->db->order_by('a.createtime', 'DESC');
        if ($sort !== NULL) {
            $this->db->order_by($sort);
        }
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        $db = clone $this->db;
        $query = $this->db->get();
        if ($count == 0) {
            $list = $query->result_array();
        }
        $total = $db->count_all_results();

        return array('list' => $list, 'total' => $total);
    }

    public function getCount($where) {
        $where = $this->_condition($where) ? $this->_condition($where) : 1;
        $sql = "SELECT COUNT(1) AS total FROM (SELECT COUNT(*) AS `total` FROM (`laike_customer_id`, `laike_customer_id` as `a`) LEFT JOIN `laike_customer` as `b` ON `a`.`cid` = `b`.`cid` WHERE {$where} GROUP BY `a`.`cid`) t";
        $row = $this->db->query($sql)->row();
        return (int) $row->total;
    }

    private function _where($where) {
        $_where = array();
        foreach ($where as $k => $v) {
            if (!empty($v)) {
                array_push($_where, "{$k}='{$v}'");
            }
        }
        $_where && $_where = implode(' AND ', $_where);
        return $_where;
    }

    private function _like($like) {
        $_like = array();
        foreach ($like as $k => $v) {
            array_push($_like, "{$k} LIKE '%{$v}%'");
        }

        $_like && $_like = implode(' AND ', $_like);
        return $_like;
    }

    private function _between($time = array()) {
        $between = '';
        if (!empty($time)) {
            $begin = isset($time['begin']) && !empty($time['begin']) ? strtotime($time['begin']) : 0;
            $end = isset($time['end']) && !empty($time['end']) ? strtotime($time['end']) : time();
            if ($begin > $end) {
                $begin = strtotime($time['end']);
                $end = strtotime($time['begin']);
            }
        } else {
            $begin = strtotime("-{$time['date']} day");
            $end = time();
        }

        if ($begin <= 0)
            $between = "a.createtime <= {$end}";
        else
            $between = "a.createtime between {$begin} and {$end}";

        return $between;
    }

    public function findByPk($pk, $where = array()) {
        return parent::findByPk($pk, $where); // TODO: Change the autogenerated stub
    }

    /**
     * @desc 获取用户工单列表数据
     * @param array $where
     * @param int $limit
     * @param int $offset
     * @param null $sort
     * @return mixed
     */
    public function getWorkByCustomer($cid = 0, $limit = 0, $offset = 0, $sort = NULL) {
        $where['b.cid'] = $cid;
        $this->db->from('laike_customer_id as a');
        $this->db->join('laike_worktable as b', 'a.cid = b.cid', 'left');
        $this->db->where($where);
        $this->db->order_by('b.ordertime', 'DESC');
        if ($sort !== NULL) {
            $this->db->order_by($sort);
        }
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();

        return $query->result_array();
    }

    /**
     * Find Record By Attributes
     *
     * @param array $where
     * @return array
     */
    public function findOne($where = array()) {
        $this->db->from($this->tableName);
        if ($where['zid']) {
            $this->db->where(array('zid' => $where['zid']));
        }
        if ($where['type']) {
            $this->db->where(array('type' => $where['type']));
        }
        if ($where['status'] || $where['status']==0) {
            $this->db->where(array('status' => $where['status']));
        }
        if ($where['city_en']) {
            $this->db->where(array('city_en' => $where['city_en']));
        }
        if ($where['starttime']) {
            $this->db->where('createtime>=', $where['starttime']);
        }
        if ($where['endtime']) {
            $this->db->where('createtime<=', $where['endtime']);
        }
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCounts($where = array()) {
        $this->db->select_sum('quoat');
        $this->db->from($this->tableName);
        if ($where['type']) {
            $this->db->where(array('type' => $where['type']));
        }
        if ($where['city_en']) {
            $this->db->where(array('city_en' => $where['city_en']));
        }
        if ($where['zid']) {
            $this->db->where(array('zid' => $where['zid']));
        }
        $this->db->where('status!=', 2);
        if ($where['starttime']) {
            $this->db->where('createtime>=', $where['starttime']);
        }
        if ($where['endtime']) {
            $this->db->where('createtime<=', $where['endtime']);
        }
        $query = $this->db->get();       
        return $query->result_array();
    }

    public function insertData($data = array()) {
        return parent::insertData($data);
    }

    public function updateByPk($pk, $attributes, $where = array()) {
        return parent::updateByPk($pk, $attributes, $where); // TODO: Change the autogenerated stub
    }

}
