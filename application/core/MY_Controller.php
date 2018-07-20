<?php

class MY_Controller extends CI_Controller
{
    public $view = '';
    public $user = array();
    public $data = array();
    public $redis = null;
    public $rights = array(); // 操作权限、显示菜单
    public $limit = 10;// 列表每页条数




    /**
     * 构造方法
     *
     * @return mixed
     */
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->load->library('layout');
        $this->load->library('session');
        $this->load->model('user_model');
        /* CI框架 cache redis配置方法
         * $this->load->driver('cache');
        $this->redis = $this->cache->redis; */
        $this->load->library('predis');
        $this->redis = & $this->predis;
        $this->config->load('web');

        $filters = array( // 白名单
            'api/',
        );
        if (in_array($this->router->directory, $filters))
        {
            return true;
        }
        $this->init();
        if ( !$this->isLogin() )
        {
		
            ci_redirect('/sign/login');
        }

    }

    /**
     * 初始化信息
     */
    public function init()
    {
        $this->user = $this->session->get_userdata();

        $this->data['user'] = $this->user;      // 用户信息
        $this->data['nav'] = array(             // 面包屑导航
            // array('name'=>'首页', 'url' =>'/'),
        );

        $this->initUrls();
        $this->initRights();
        $this->isHaveRights();
    }

    /**
     * 是否有权限
     */
    public function isHaveRights()
    {
        $filters = array( // 白名单
            '/home/index',
            '/sys/poster/verifypub',
            '/task/index/detail',
        );
        $url = rtrim($this->data['c_url'], '/');
        if (in_array($url, $filters) || in_array($url, $this->rights))
        {
            return true;
        }
        if ($this->_isAjaxRequest())
        {
            $res = array('status' => false,'msg' => '没有权限');
            $this->_outputJSON($res);
            return false;
        }

        ci_redirect('/home/index', 3, '没有权限');
    }

    /**
     * 设置路径
     */
    public function initUrls()
    {
        $d = strtolower($this->router->directory);
        $c = strtolower($this->router->class);
        $m = strtolower($this->router->method);
        $url = '/';
        $d && $url .= "{$d}";
        $c && $url .= "{$c}";
        $m && $url .= "/{$m}";
        $this->data['c_url_d'] = '/' . $d;
        $this->data['c_url_c'] = $c;
        $this->data['c_url_m'] = $m;
        $this->data['c_url'] = $url;
    }

    /**
     * 获取左侧菜单
     * 权限
     */
    public function initRights()
    {
        $this->config->load('rights');
        $menu = $this->config->item('rights');
        $userRights = explode(',', $this->user['operate_rights']);
        foreach ($menu as $k=>$v)
        {
            if (!in_array($k, $userRights))
            {
                unset($menu[$k]);
                continue;
            }
            $this->rights[$k] = $v['url'];
            foreach ($v['child'] as $kk=>$vv)
            {
                if (!in_array($kk, $userRights))
                {
                    unset($menu[$k]['child'][$kk]);
                    continue;
                }
                $this->rights[$kk] = $vv['url'];
                foreach ($vv['child'] as $kkk=>$vvv)
                {
                    if (!in_array($kkk, $userRights))
                    {
                        unset($menu[$k]['child'][$kk]['child'][$kkk]);
                        continue;
                    }
                    $this->rights[$kkk] = $vvv['url'];
                }
            }
        }
        $this->data['menu'] = $menu; // 左侧菜单
        return $menu;
    }

    /**
     * 是否登陆
     */
    public function isLogin()
    {
        return $this->user['uid'];
    }

    /**
     * 组合url参数
     */
    protected function _generalUrl($param = array())
    {
        $url = '';
        if ( !$param )
            return $url;
        foreach($param as $k=>$v)
        {
            $url .= "&{$k}={$v}";
        }
        return $url;
    }

    /**
     * 获取有效搜索字段参数
     */
    protected function _getValidParam($data, $valid)
    {
        $data = array_intersect_key($data, $valid);
        foreach ($data as $k=>$v)
        {
            if (trim($v) !== '')
            {
                $data[$k] = trim($v);
            }
            else
            {
                unset($data[$k]);
            }
        }
        return $data;
    }

    /**
     * 是否是异步请求
     */
    protected function _isAjaxRequest()
    {
        if ( isset($_SERVER["HTTP_X_REQUESTED_WITH"])
            && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest" )
        {
            return true;
        }
        return false;
    }

    /*输出模式json*/
    protected function _outputJSON($data, $config)
    {
        header("Content-type: application/json; charset=UTF-8");
        if ($config['encode'] == 'gbk')
        {
            echo "错误编码";
        }
        else
        {
            echo json_encode($data);
        }
        exit;
    }

    /*输出模式jsonp*/
    protected function _outputJSONP($data, $config)
    {
        header('Access-Control-Allow-Origin:*');
        header("Content-type: application/json; charset=UTF-8");
        if ($config['encode'] == 'gbk')
        {
            echo "错误编码";
        }
        else
        {
            echo $config['callback'] . "(" . json_encode($data) . ")";
        }
        die;
    }

    //登陆
    public function Login()
    {
        $uid = $this->user['uid']?$this->user['uid']:$this->checkLogin();
        //var_dump($uid);die;
        if($uid == false){
            //$this->_redirect($this->loginurl, '权限校验失败哦', 1);
            ci_redirect($this->loginurl,5,'权限校验失败哦');
            return;
        }
        //用户信息
        $userinfo = $this->user_model->getInfo(array('passport_id'=>$uid));
        if(!$userinfo || ($userinfo['status'] != 1)){
            $msg = $userinfo ? '用户账号被禁用或删除！' : '还未获取用户信息哟!';
            //$this->_redirect($this->loginurl, $msg, 1);
            ci_redirect($this->loginurl,5,$msg);
            return;
        }
        //最后登录时间
        $this->user_model->updateLogin($uid);
        //执行登陆
        foreach ($userinfo as $k=>$v)
        {
            setcookie($k, $v, time()+72000, '/');
        }
        ci_redirect('/home/');
    }
    //退出
    public function LogoutAction()
    {
        $login = new Lib_Login();
        $login->logout() && $this->_redirect($this->logouturl, '正在退出..', 0, 1);;
    }
    


    /*
     * 验证登陆状态
    * @var string 非新浪域下admin_permit是作为参数传过来的,新浪域下通过cookie获取不需要传这个参数。
    * @return 正确返回uid(passport_id字段),错误返回false
    */
    private function checkLogin()
    {

        $admin_permit = $this->input->get('admin_permit', '');
        $uid = $this->checkPermitCookie($this->projectKey, $admin_permit);
        if($uid)
        {
            return $uid;
        }
        return false;
    }

    /*
     * 检查用户登陆的cookie
     * @param string $key 项目私有key
     * @param string $str 非新浪域下admin_permit是作为参数传过来的,新浪域下通过cookie获取不需要传这个参数。
     * @return 正确返回uid(passport_id字段),错误返回false
     */
    private function checkPermitCookie($key, $str='')
    {
        $arr = array();
        if(!empty($str))
        {
            parse_str(urldecode($str),$arr);
        }

        $permit = count($arr) > 0 ? json_encode($arr) : $_COOKIE['admin_permit'];
        if(!empty($permit) && !empty($key))
        {
            //验证cookie有效性
            $permit = json_decode($permit,true);
            if(is_array($permit) && isset($permit['uid'])){
                $pro_key = md5($key.'-'.$permit['lt'].'-'.$permit['uid']);
                $key = substr($pro_key,2,1) . substr($pro_key,7,1) . substr($pro_key,17,1) . substr($pro_key,25,1) . substr($pro_key,31,1);
                $key_pos = strpos($permit['permit'],$key);
                if($key_pos !== false && ($key_pos % 5) == 0  && (time()-$permit['lt']) < 72000)
                {
                    
                    if(!isset($_COOKIE['admin_permit']) && !empty($str))
                    {
                        setcookie('admin_permit', json_encode($arr), time()+72000, '/');
                    }
                    return $permit['uid'];
                }
            }
        }
        return false;
    }


}
