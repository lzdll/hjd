<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller
{

    /**
     * 构造方法
     *
     * @return mixed
     */
    public function __construct()
    {
        parent::__construct();
        $this->_initNav();
        $this->load->library('session');
        $this->load->library('Ucloud/Proxy');
        $this->load->model('adprice_model');
        $this->load->model('advertiser_model');
        $this->load->model('company_model');
        $this->load->model('advert_model');
        $this->load->model('account_model');
        $this->load->model('slot_model');
        //$this->load->model('plugin_building_model');
    }

    /**
     * 初始化导航信息
     */
    private function _initNav()
    {
        $method = $this->router->method;
        $nav = array();
        $this->data['nav'] = array_merge($this->data['nav'], $nav);
    }

    /**
     * 广告主数据首页
     */
    public function index()
    {
        $info = $this->advert_model->getAdMasterCountInfo($this->user['code']);
        $info['totalmoney'] = number_format( $info['totalmoney']/100,2,'.','');
        $info['account']['quota'] = number_format( $info['account']['quota']/100,2,'.','');
        $this->data['countinfo'] = $info['account'];
        $this->data['totalmoney'] = $info['totalmoney'];
        //广告推广量
        $begin_time = $this->input->get('begin_time');
        $end_time = $this->input->get('end_time');
        if(empty($begin_time)){
            $begin_time = date('Y-m-d', strtotime('-7 days'));
        }
        if(empty($end_time)){
            $end_time = date('Y-m-d', time());
        }
        $adInfo = $this->slot_model->getExtensionStatices($this->user['code'],'',$begin_time,$end_time);
        $recharge = $this->account_model->getFinanceInfo($this->user['code'],'',$begin_time,$end_time);
        $datedata = $this->getDateSection($begin_time, $end_time);
        $sectionCount = count(explode(',', $datedata));
        $staticesCpc = $staticesCpm = $staticesAdPrice = $staticesadRechage =array();
        if(!empty($adInfo)){
            foreach ($adInfo as $key =>$val){
                $staticesCpc[] = $val['cpc'] ;
                $staticesCpm[] = $val['cpm'] ;
                $staticesAdPrice[] = $val['ad_price'] ;
                $staticesadRechage[] = $val['ad_price'] ;
            }
        }
        if(!empty($recharge)){
            foreach ($recharge as $key =>$val){
                $staticesAdRechage[] = $val['money'] ;
            }
        }
        if(count($staticesCpm) < $sectionCount){
            $max = ($sectionCount-count($staticesCpm));
            for ($i=0;$i<$max;$i++){
                $staticesCpc[] = 0;
                $staticesCpm[] = 0;
                $staticesAdPrice[] = 0;
            }
        }
        $this->data['avg_price'] = $adInfo['avg_price']>0?number_format($adInfo['avg_price'],2,'.',''):"0.00";
        $this->data['staticesCpc'] = implode(',',$staticesCpc);
        $this->data['staticesCpm'] = implode(',',$staticesCpm);
        $this->data['staticesAdPrice'] = implode(',',$staticesAdPrice);
        $this->data['staticesAdRechage'] = implode(',',$staticesAdRechage);
        $this->data['date'] = $this->getDateTime();
//        var_dump($info);die;
        $this->layout->view('/ad/ad_index', $this->data);
    }

    /**
     * 数据列表
     */
    public function lists()
    {
        $page=intval($_GET['p'])?intval($_GET['p']):1;
   
        $pagesize = isset($input['pagesize']) && (int)$input['pagesize'] > 0 ? (int)$input['pagesize'] : 10;
        $offset =intval($page) > 0 ?intval($page-1)*$pagesize:0;
        $info = $this->advertiser_model-> adlist($this->user['code'],$limit = $pagesize, $offset = $offset);
        foreach ( $info as $key => &$item) {
            $item['price'] = number_format((floor($item['price']/100)).".".($item['price']%100),2,'.','');
            $item['ad_sumprice'] = number_format((floor($item['ad_sumprice']/100)).".".($item['ad_sumprice']%100),2,'.','');
            $item['cpccpm'] = $item['cpc'] + $item['cpm'];
            $item['pv'] = $item['totalcpc'] + $item['totalcpm'];
            $item['pv'] = $item['totalcpc'] + $item['totalcpm'];
            if( ($item['audit_status'] == 0 ||  $item['audit_status'] == 3) ){
                if($item['status'] == 2){
                    $item['status'] = "下线";
                    $item['statusac'] = "";
                }else{
                    $item['status'] = "撤下";
                    $item['statusac'] = "aduseroper active";
                }
            }else{
                if($item['status'] == 0){
                    $item['status'] = "已上线";
                    $item['statusac'] = "";
                }else{
                    $item['statusac'] = "aduseroper2 active";
                    $item['status'] = "发布";
                }
            }
            if($item['audit_status'] == 0) $item['active'] = "active";
           $item['audit_status'] = $item['audit_status'] == 0?"未审核":($item['audit_status'] == 1?"通过审核":"未过审核");
        }
//      var_dump($info); die;

        $total = count($info);
        $this->data['list'] = $info;
        $this->data['count'] = $total;

        //分页
        if ($total > 0) {
            $this->data['pager'] = getPage($total,$pagesize,$page,$page_len=7,"/ad/index/lists");
        }

        $this->layout->view('/ad/list', $this->data);
    }


    public function add()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $company = $this->company_model->getInfo($where = array("owner"=>$this->user['code']));
        if($company['status'] ==1){
            ci_redirect('/ad/index/lists', 3, '已封号,请联系平台');
        }
        if($company['audit_status'] == 1 || empty($company)){
            ci_redirect('/ad/index/lists', 3, '资质审核未过');
        }else if($company['audit_status'] == 0){
            ci_redirect('/ad/index/lists', 3, '资质未审核');
        }
        if ($method == 'get')
        {
            $this->layout->view('/ad/add', $this->data);
        }
        if($method == 'post'){
//            var_dump($_REQUEST);die;
            if(count($_FILES )>1){
                foreach($_FILES as $fileinfo){
                    if($fileinfo['size'] < 1024000 && ($fileinfo['type'] =="image/png" || $fileinfo['type']=="image/jpeg" ) ){
                        $status = true;
                    }else{
                        ci_redirect('/ad/index/add', 3, '图片格式或大小不对');
                    }
                }
            }else{
                ci_redirect('/ad/index/add', 3, '请上传图片');
            }
            //判断上传文件类型为png或jpg且大小不超过1024000B
            if($status)
            {

                $filename1 =date('Y/m/d')."/img/".time().rand(0,1000).$_FILES["file1"]["name"];
                $filename1 =iconv("UTF-8","gb2312",$filename1);
                $filename2 =date('Y/m/d')."/img/".time().rand(0,1000).$_FILES["file2"]["name"];
                $filename2 =iconv("UTF-8","gb2312",$filename2);
                $filename3 =date('Y/m/d')."/img/".time().rand(0,1000).$_FILES["file3"]["name"];
                $filename3 =iconv("UTF-8","gb2312",$filename3);
             $upload_file_url1 = $this->proxy->UploadFiles($filename1,$_FILES["file1"]["tmp_name"]);
             $upload_file_url2 = $this->proxy->UploadFiles($filename2,$_FILES["file2"]["tmp_name"]);
             $upload_file_url3 = $this->proxy->UploadFiles($filename3,$_FILES["file3"]["tmp_name"]);
                if(!$upload_file_url1 || !$upload_file_url2 || !$upload_file_url3){
                    ci_redirect('/ad/index/add', 3, '图片上传失败');
                }
            }
            //测试阶段可用
            $upload_file_url = '/2018/07/21/img/1532151910bg_lq.png';

            if ( $form = $this->input->post() )
            {
                if($form['platform'] == '01'){
                    $platform = "H5";
                    $link = $form['link1'];
                }
                elseif($form['platform'] == '02'){
                    $platform = "android";
                    $link = $form['link2'];
                }
                else{
                  $platform = "wechat";
                    $link = $form['link3'];
            }
                $data['code'] = md5($this->user['code'].time().rand(0,10000));
                $data['owner'] = $this->user['code'];
                $data['name'] = trim($form['title']);
                $data['info'] = $form['contact'];
                $data['icon'] = "http://osv.ufile.ucloud.com.cn/".$upload_file_url1;
                $data['image'] = "http://osv.ufile.ucloud.com.cn/".$upload_file_url2;
                $data['banner'] ="http://osv.ufile.ucloud.com.cn/".$upload_file_url3;
                $data['platform'] = $platform;
                $data['link'] = $link;
                $data['status'] = 1;
                $data['audit_status'] = 0;
                $data['created_time'] = date('Y-m-d H:i:s');
                $data['updated_time'] = date('Y-m-d H:i:s');
                $price['user_code'] = $this->user['code'];
                $price['ad_code'] = $data['code'];
                $price['type'] = 0;
                $price['code'] = md5($this->user['code'].time().rand(0,10000));
                $price['price'] = $form['price'] * 100;
                $price['status'] = 0;
                $price['created_time'] = date('Y-m-d H:i:s');
                $res1 = $this->advertiser_model->add($data);
                $res2 = $this->adprice_model->add($price);
                if($res1 && $res2){
                    ci_redirect('/ad/index/lists', 3, '添加成功');
                }else{
                    ci_redirect('/ad/index/add', 3, '添加失败');
                }
            }
        }
    }
    /**
     * 图片上传
     */
    public function  setimg(){
        $targetFolder = date('Y/m/d')."/img/"; // Relative to the root
        if (!empty($_FILES)) {
            $tempFile = $_FILES['file']['tmp_name'];
            $newname =$this->user['code']."_".time();//图片名字
            $fileTypes = array('jpg','jpeg','gif','png','pdf'); // 文件类型
            $fileParts = pathinfo($_FILES['file']['name']);
            $size = getimagesize($tempFile);
            $width = $size[0];
            $height = $size[1];
            if($width>100 || $height>100){
                unlink($tempFile);
                $arr = array('status' => 0,'type' => $type,'msg' => "图片的宽高不符要求!" );
                echo json_encode($arr);
                exit;
            }
            $filename = rtrim($targetFolder). $newname.'.'.$fileParts['extension'];//图片路径
            sleep(2);
            if (in_array($fileParts['extension'],$fileTypes)) {
                $filename =iconv("UTF-8","gb2312",$filename);
                $upload_file_url = $this->proxy->UploadFiles($filename,$_FILES["file"]["tmp_name"]);
                $upload_file_url = 'http://osv.ufile.ucloud.com.cn/'.$upload_file_url;
                $imgInfo['name']=$filename;
                $imgInfo['url'] =$upload_file_url;
                $imgInfo['status'] = 1;
                echo json_encode($imgInfo,true);
            }else{
                $arr = array('status' =>0,'type' => $type,'msg' => "上传文件不符合要求!" );
                echo json_encode($arr);
                exit;
            }
        }
    }
    public function details(){
        $info = $this->advertiser_model->getInfoIds($_REQUEST['id'],$this->user['code']);
        $info['price'] = number_format((floor( $info['price']/100)).".".( $info['price']%100),2,'.','');

        switch($info['platform']){
            case "H5":
                $info['cheack1'] = "checked";
                $info['cheack2'] = "";
                $info['cheack3'] = "";
                $info['linkname'] = "推广链接：";
                break;
            case "ios":
                $info['cheack1'] = "";
                $info['cheack3'] = "checked";
                $info['cheack3'] = "";
                $info['linkname'] = "下载推广地址：";
                break;
            case "android":
                $info['cheack1'] = "";
                $info['cheack2'] = "checked";
                $info['cheack3'] = "";
                $info['linkname'] = "下载推广地址：";
                break;
            case "wechat":
                $info['cheack1'] = "";
                $info['cheack2'] = "";
                $info['cheack3'] = "checked";
                $info['linkname'] = "小程序路径：";
                break;
            default;

        }
        $this->data['info'] = $info;
        $this->layout->view('/ad/detail', $this->data);
    }
    public function edit()
    {
            $type = $_POST['type'];
            $id = $_POST['id'];
        $price = $_POST['price'] * 100;
            if ($type == "delete")
            {
                //删除广告
               $res = $this->advertiser_model->edit($id,2);
                echo json_encode($res);exit;
            }
            if($type == 'publish'){
                //发布广告
                $res = $this->advertiser_model->edit($id,0);
                echo json_encode($res);exit;
            }
            if($type == 'price'){
                $res = $this->advertiser_model->edit($id,"",$price);
                echo json_encode($res);exit;
            }
            else
            {
                $res['msg'] = '编辑失败';
                echo json_encode($res);exit;
            }
            

    }
    
    public function detail()
    {
        $id = (int)$this->input->get('id');
        $info = $this->ad_model->findByPk($id);
        //print_r($info);die;
        if ($info)
        {
            $info['city'] = $this->_getCityName($info['city']);
            //var_dump($info);die;
            $this->data['info'] = $info;
            $this->layout->view('/ad/detail', $this->data);
        }
        else
            ci_redirect('/ad/', 3, 'ID错误或信息不存在');
    }


   public function editquota(){
       $owner = $this->user['code'];
//       var_dump($owner);
//       var_dump(trim($_POST['quota']));die;
       $res = $this->account_model->edit($owner,trim($_POST['quota'])*100);
       if($res==1){
           $res= true;
           echo json_encode($res);exit;
       }
       else
       {
           ci_redirect('/ad/index/index', 3, '修改成功');
       }
   }

    private function getDateSection($startdate, $enddate){

        $stimestamp = strtotime($startdate);
        $etimestamp = strtotime($enddate);
        // 计算日期段内有多少天
        $days = ($etimestamp-$stimestamp)/86400+1;
        // 保存每天日期
        $str = '';
        for($i=0; $i<$days; $i++){
            $str .= "'".date('n.j', $stimestamp+(86400*$i))."',";
        }
        return mb_substr($str, 0,-1);
    }
    private function getDateTime(){
        $date['today']['begin_date'] = date("Y-m-d");
        $date['today']['end_date'] = date("Y-m-d",strtotime("+1 day"));
        $date['yesterday']['begin_date'] = date("Y-m-d",strtotime("-1 day"));
        $date['yesterday']['end_date'] = date("Y-m-d");
        $date['week']['begin_date'] = date("Y-m-d",strtotime("-1 week"));
        $date['week']['end_date'] = date("Y-m-d");
        $date['month']['begin_date'] = date("Y-m-01");
        $date['month']['end_date'] = date("Y-m-d");

        return $date;
    }
        
}

