<?php

/**
 * 请求url
 *
 * @param string $getUrl
 * @param array  $data
 * @param array  $header
 * @param int   $timeOut 超时时间
 */

function curl_get($getUrl, $data = array(), array $header = array(), $timeOut = 5,$host) {
    if (false == empty($data)) {
        $data = is_array($data) ? http_build_query($data) : $data;
        $getUrl .= (strpos($getUrl, '?') !== false ? '&' : '?') . $data;
    }
    //echo $getUrl;die;
    $ch = curl_init();
    foreach ($header as $name => $value) {
        $h[] = $name . ': ' . $value;
    }
    $h[] = 'Expect: ';

  

    curl_setopt($ch, CURLOPT_HTTPHEADER, $h);

    curl_setopt($ch, CURLOPT_URL, $getUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
    if(isset($host)){
        curl_setopt($ch,CURLOPT_HTTPHEADER,$host);
    }
    $result = curl_exec($ch);
    curl_close($ch);

    return trim($result);
}

/**
 * post请求
 *
 * @param string $postUrl 请求的网址
 * @param array  $data    发送过去的数据
 * @param array  $header  header请求头
 * @param int    $timeOut 超时时间
 */
function curl_post($postUrl, $data = array(), $header = array(), $timeOut = 5) {

    $ch = curl_init();

  
    curl_setopt($ch, CURLOPT_URL, $postUrl);
    curl_setopt($ch, CURLOPT_POST, true);

    foreach ($header as $name => $value) {
        $h[] = $name . ': ' . $value;
    }
    $h[] = 'Expect: ';

 

    curl_setopt($ch, CURLOPT_HTTPHEADER, $h);  //防止在访问https时出错
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    curl_close($ch);
    return trim($result);
}

/**
 * 得到客户端的ip
 *
 * @param string $default
 * @return string
 */
function get_remote_ip($default = '127.0.0.1') {
    $ip = false;
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) {
            array_unshift($ips, $ip);
            $ip = FALSE;
        }
       
    }
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}


/**
 * 跳转
 * @param string $jumpUrl
 * @return mixed
 */
function jump($jumpUrl) {
    $url = 'https';
    ($_SERVER['HTTPS'] != 'on') && $url = 'http';
    header('location: ' . $url . '://' . $_SERVER['SERVER_NAME'] . '/' . $jumpUrl);
    exit();
}


function decode($json) {
    $value = false;
    if (!is_string($json))
        return false;

    $value = json_decode($json, true);
    return $value;
}

function encode($value) {
    $json = json_encode($value);
    return $json;
}

/**
 * 获取当前页面的URL
 * @return string
 */
function cur_page_url() {
    $pageURL = 'http';

    if (@$_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";

    $this_page = $_SERVER["REQUEST_URI"];

    if (strpos($this_page, "?") !== false)
        $this_page = reset(explode("?", $this_page));

    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $this_page;
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $this_page;
    }
    return $pageURL;
}

/**
 * 根据给定的查询字段，自动获取GET参数，并拼接成数组和字符串两种where条件
 *
 * @param $query_field
 * @return array
 */
function where($query_field) {
    $where = array();
    $param_str = '';
    $ci_obj = & get_instance();
    foreach ($query_field as $key => $val) {
        $where_get = $ci_obj->input->get($key);
        if (!empty($where_get) || $where_get === "0") {
            $param_str .= '&' . ($key . '=' . $ci_obj->input->get($key));
            if ($val == 'like')
                $where[$key . ' LIKE'] = '%' . $ci_obj->input->get($key) . '%';
            else
                $where[$key] = $ci_obj->input->get($key);
        }
    }
    return array($where, $param_str);
}

/**
 * @param $param_str
 * @param $count
 * @param $limit
 * @return array
 */
 function page($param_str, $count, $limit) {
    //分页
    $ci_obj = & get_instance();
    
    $ci_obj->load->library('pagination');
    // $ci_obj->pagination->page_query_string = true;
    $config['base_url']     = cur_page_url() . '?' . $param_str;
    $config['total_rows']   = $count;
    $config['per_page']     = $limit;
    $config['use_page_numbers'] = 5;
    $config['next_link']    = '下一页';
    $config['prev_link']    = '上一页';
    $config['full_tag_open'] = '';
    $config['full_tag_close'] = '';
    $config['num_tag_open'] = '';
    $config['num_tag_close'] = '';
    $config['prev_tag_open'] = '';
    $config['prev_tag_close'] = '';
    $config['next_tag_open'] = '';
    $config['next_tag_close'] = '';
    $config['last_tag_open'] = '';
    $config['last_tag_close'] = '';
    $config['cur_tag_open'] = '<a class="on" href="#">'; //“当前页”链接的打开标签。
    $config['cur_tag_close'] = '</a>'; //“当前页”链接的关闭标签。
    $config['page_query_string'] = true; 
    $config['query_string_segment'] = 'page'; //分页参数
    $config['last_class']   =  "class = 'noBor'";
    $config['first_link']   = '首页';
    $config['last_link']    = '末页';
    $config['num_links'] = 2;
    $ci_obj->pagination->initialize($config);
    $offset = $ci_obj->input->get('page') ? $ci_obj->input->get('page') : 1;
    return array(
        'count'     => $count,
        'nowpage'   => $offset,
        'page'      => ceil($count/$limit),
        'links'     => str_replace("?&amp;", '?', $ci_obj->pagination->create_links())
    );
}

/**
 * @brief 跳转
 * @param type $url
 * @param type $time
 * @param type $msg
 */
function ci_redirect($url, $time = 0, $msg = '') {
	//多行URL地址支持
    $url        = str_replace(array("\n", "\r"), '', $url);
    if(empty($msg)){
        $msg    = "系统将在{$time}秒之后自动跳转到{$url}！";
    }
    if(!headers_sent()){
        // redirect
        if (0 === $time) {
            header('Location: ' . $url);
        }else{
            header('Content-type: text/html; charset=utf-8');
            header("refresh:{$time};url={$url}");

            $html='<!DOCTYPE html><html lang="zh"><head><meta charset="UTF-8">';
            $html.='<title>Document</title>';
            $html.='</head><body>';
            $html.='<style type="text/css">';
            $html.='::selection { background-color: #E13300; color: white; }::-moz-selection { background-color: #E13300; color: white; }';
            $html.='body {background-color: #fff;font: 13px/20px normal Helvetica, Arial, sans-serif;color: #4F5155; padding-top:100px}';
            $html.='a {color: #003399;background-color: transparent;font-weight: normal;}';
            $html.='h1 {color: #444;background-color: transparent;border-bottom: 1px solid #D0D0D0;font-size: 19px;font-weight: normal; ' .
                    'margin: 0 0 14px 0;padding: 14px 15px 10px 15px;}';
            $html.='code {font-family: Consolas, Monaco, Courier New, Courier, monospace;font-size: 12px;background-color: #f9f9f9;' .
                    'border: 1px solid #D0D0D0;color: #002166;display: block;	margin: 14px 0 14px 0;padding: 12px 10px 12px 10px;}';
            $html.='#container {  margin: 40px auto;border: 1px solid #D0D0D0;box-shadow: 0 0 8px #D0D0D0;text-align:center;width:400px;}';
            $html.='p {margin: 12px 15px 12px 15px;}';
            $html.='.jumpurl {color: #444;background-color: transparent;font-size: 14px;font-weight: normal;margin: 10px 20px 14px;'.
                'text-decoration: none;}';
            $html.='</style>';
            $html.= "<div id='container'>";
            $msg = $msg ? $msg : '操作完成';
            $html.= "<h1>{$msg}</h1>";
            $html.= '<p><a id="rTime" href="'.$url.'">系统将在'.$time.'秒后自动跳转</a></p>';
            $html.= "</div>";
            $html.='<script>var curTime = '.($time-1).';var time = document.getElementById("rTime");';
            $html.='var timer = setInterval(function(){time.innerHTML = "系统将在"+';
            $html.='curTime-- + "秒后自动跳转";if(curTime === 0){clearInterval(timer);return;}},1000)';
            $html.='</script>';
            $html.='</body></html>'; 
            echo $html;
        }
        exit();
    }else{
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if($time != 0){
            $str .= $msg;
        }
        exit($str);
    }
}

/**
 * 检测请求是否为ajax请求
 * @return bool
 */
function checkAjaxRequest()
{
    $header = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) : '';
    return $header == 'xmlhttprequest';
}


/**
 * 统一返回格式
 *
 * @param bool $status
 * @param string $msg   code_description   =>   2001_数据库连接错误
 * @param array $data
 * @param string $callback
 * @param string $type  | json | arr| obj
 * @return json|jsonp
 */
function my_return($status = true, $msg = '', $data = array(), $callback = '', $type = 'json') {
    if (strpos($msg, MSG_SEPARATE) !== false) {
        $msg = explode(MSG_SEPARATE, trim($msg));
        list($code, $desc) = $msg;
    } else {
        $desc = $msg;
    }

    $return = array(
        'status' => $status,
        'code' => $code,
        'msg' => $desc,
        'data' => $data
    );

    $json = json_encode($return);

    if (!empty($callback)) {
        return $callback . '(' . $json . ')';
    } else if ($type == 'json') {
        die($json);
    } else if ($type == 'arr') {
        return $return;
    } else if ($type == 'obj') {
        return false;
    }
}

/**
 * 验证手机号
 * @param string $mobile
 * @return bool
 */
function is_mobile($mobile = '') {

    preg_match("/^1[34578]\d{9}$/", $mobile, $match);
    if ($match == false) {
        return false;
    } else {
        return true;
    }
}

function is_email($email)
{
	$regExp = '/^[a-z0-9][a-z\.0-9-_]+@[a-z0-9_-]+(?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i';
	return preg_match($regExp, $email) ? true : false;
}

/**
 * 导出文件
 * @param array $fields 表头字段
 * @param array $result 数据列表 
 */
function export($filename ,$result, $fields)
{
	//获取展示内容
     $filename = iconv('utf-8','gbk',$filename);
     header('Content-type:application/vnd.ms-excel;charset=gbk');
     header("Content-Disposition:filename=" . $filename . ".csv");

    if($result && $fields)
    {
    	//处理标题
    	foreach($fields as $k => $f)
    	{
    		if($k == count($fields) - 1)
    		{
    			echo iconv('utf-8','gbk',$f);
    		}
    		else
    		{
    			echo iconv('utf-8','gbk',$f). ',';
    		}
    	}
    	echo "\r\n";
    	//处理内容
    	foreach($result as $key => $val)
    	{
    	    foreach($val as $vv)
    		{
    			//echo $t.",".$vv['area'].",".$vv['house_name'];
    			echo iconv('utf-8','gbk',$vv).",";
    		}	
    		echo "\r\n";
    	}
    }
    else
    {
    	echo iconv('utf-8','gbk',"no data");
    }
}

//检查远程文件是否存在
function  check_remote_file_exists($url) {
	$curl= curl_init($url);   
	curl_setopt($curl, CURLOPT_NOBODY, true);// 不取回数据  
	$result= curl_exec($curl);   // 发送请求     
	$found= false;    
	// 如果请求没有发送失败     
	if($result!== false) {         
		// 再检查http响应码是否为200         
		$statusCode= curl_getinfo($curl, CURLINFO_HTTP_CODE);           
		if($statusCode== 200) { $found= true; }
	}
	curl_close($curl);
	return  $found;
}

/**
 * @todo 将对象转换成数组，支持多维数组
 * @param object $obj
 * @return array
 */
function object_to_array($obj) {
    $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
    foreach ($_arr as $key => $val) {
        $val = (is_array($val) || is_object($val)) ? $this->object_to_array($val) : $val;
        $arr[$key] = $val;
    }
    return $arr;
}

/**
 * 获取当前时间的毫秒值
 */
function mtime()
{
    $time = explode ( " ", microtime () );
    $time = $time [1] . ($time [0] * 1000);
    $time2 = explode ( ".", $time );
    $time = $time2 [0];

    return $time;
}

/**
 * 提示信息
 * @param string $msg 提示信息
 * @param strung $url 跳转路径
 */
function msg_alert($msg, $url='')
{
    if(empty($url))
    {
        echo "<script>alert('{$msg}');</script>";
        exit;
    }
    
    echo "<script>alert('{$msg}');top.window.location='{$url}';</script>";
    exit;
}
    /*
     * [去除数组中空值的key]
     * @param  Array $data
     * @return Array $data
     * @author haoyan1@leju.com
     */

function rmTheArrayKey($data = array()) {

        foreach ($data as $_key => $_value) {
            if (!$_value) {
                unset($data[$_key]);
            }
        }

        return $data;
    }
/**
 * 生成密码
 */
function gen_pwd($pwd)
{
    return md5('money' . $pwd);    
}

/**
 * 生成code
 */
function get_code($string)
{
    return substr(strtoupper(md5($string)),0,8);  
}

/**
 * 时间转换
 * @param  string|integer|float  $num  时间日期
 * @return string
 */
function Sec2Time($time){
    if(is_numeric($time)){
		$value = array(
		  "years" => 0, "days" => 0, "hours" => 0,
		  "minutes" => 0, "seconds" => 0,
		);
		if($time >= 31556926){
		  $value["years"] = floor($time/31556926);
		  $time = ($time%31556926);
		}
		if($time >= 86400){
		  $value["days"] = floor($time/86400);
		  $time = ($time%86400);
		}
		if($time >= 3600){
		  $value["hours"] = floor($time/3600);
		  $time = ($time%3600);
		}
		if($time >= 60){
		  $value["minutes"] = floor($time/60);
		  $time = ($time%60);
		}
		$value["seconds"] = floor($time);
		if($value["days"]){
			$t= $value["days"] ."天";
		}
		if($value["hours"]){
			$t.= $value["hours"] ."小时";
		}
		if($value["minutes"]){
			$t.= $value["minutes"] ."分";
		}
		if($value["seconds"]){
			$t.= $value["seconds"] ."秒";
		}
		return $t;
     }else{
		return (bool) FALSE;
    }
 }
