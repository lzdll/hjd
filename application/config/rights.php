<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
// 操作权限、菜单权限
$config['rights'] = array(
    '1' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'item',          // 类型 item菜单  folder目录
        'name'      => '首页',
        'url'       => '/home/index',
        'class'     => '',
        'icon'      => 'menu-icon fa fa-cog',
        'child' => array(
        ),
    ),
    '2' => array(
        'is_menu'   => 1,
        'type'      => 'folder',
        'folder'    => '/authority/',
        'name'      => '权限管理',
        'url'       => '/authority/admin/index',    // 如果包含子菜单，此值设定为子菜单所在目录
        'class'     => 'dropdown-toggle',
        'icon'      => 'menu-icon fa fa-lock',
        'child' => array(
            '2_1' => array(
                'is_menu'   => 1, 
                'type'      => 'item',
                'name'      => '用户管理', 
                'url'       => '/authority/admin/index',
                'child'     => array(
                    '2_1_1' => array('is_menu'=>0, 'name'=>'管理员列表', 'url'=>'/authority/admin/index'),
                    '2_1_2' => array('is_menu'=>0, 'name'=>'添加管理员', 'url'=>'/authority/admin/add'),
                    '2_1_3' => array('is_menu'=>0, 'name'=>'删除管理员', 'url'=>'/authority/admin/del'),
                    '2_1_4' => array('is_menu'=>0, 'name'=>'修改管理员', 'url'=>'/authority/admin/edit'),
                ),
            ),
            '2_2' => array(
                'is_menu'   => 1, 
                'type'      => 'item',
                'name'      => '角色管理', 
                'url'       => '/authority/role/index',
                'child'     => array(
                    '2_2_1' => array('is_menu'=>0, 'name'=>'角色列表', 'url'=>'/authority/role/index'),
                    '2_2_2' => array('is_menu'=>0, 'name'=>'添加角色', 'url'=>'/authority/role/add'),
                    '2_2_3' => array('is_menu'=>0, 'name'=>'修改角色', 'url'=>'/authority/role/edit'),
                    '2_2_4' => array('is_menu'=>0, 'name'=>'删除角色', 'url'=>'/authority/role/del'),
                    '2_2_5' => array('is_menu'=>0, 'name'=>'权限配置', 'url'=>'/authority/role/rights'),
                ),
            ),
        ),
    ),
    '3' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'folder',          // 类型 item菜单  folder目录
        'folder'    => '/zygw/',         // 类型 item菜单  folder目录
        'name'      => '流量主',
        'url'       => '/zygw/index/lists',
        'class'     => '',
        'icon'      => 'menu-icon fa fa-cog',
        'child' => array(
            '3_1' => array('is_menu'=>1, 'name'=>'置业顾问列表', 'url'=>'/zygw/index/lists'),
            '3_2' => array('is_menu'=>0, 'name'=>'楼盘变更通过', 'url'=>'/zygw/index/adopt'),
        ),
    ), 
    '4' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'folder',          // 类型 item菜单  folder目录
        'folder'    => '/reward/',         // 类型 item菜单  folder目录
        'name'      => '广告主',
        'url'       => '/reward/index/lists',
        'class'     => '',
        'icon'      => 'menu-icon fa fa-cog',
        'child' => array(
            '4_1' => array('is_menu'=>1, 'name'=>'专车奖励分配管理', 'url'=>'/reward/index/lists'),
            '4_2' => array('is_menu'=>1, 'name'=>'专车奖励分配单数', 'url'=>'/reward/index/record'),
        ),
    ),
    '5' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'folder',
        'folder'    => '/qamanage/',         // 类型 item菜单  folder目录
        'name'      => '广告管理',
        'url'       => '/ad/index/lists',
        'class'     => '',
        'icon'      => 'menu-icon fa fa-cog',
        'child' => array(
          
        
        ),
    ), 
    '6' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'item',          // 类型 item菜单  folder目录
        'name'      => 'SDK管理',
        'url'       => '/SDK/index/lists',
        'class'     => '',
        'icon'      => 'menu-icon fa fa-cog',
        'child' => array(
            
        ),
 
    ), 
 



    '7' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'folder',
        'folder'    => '/taskmanage/',         // 类型 item菜单  folder目录
        'name'      => '财务',
        'url'       => '/taskmanage/index/lists',
        'class'     => 'dropdown-toggle',
        'icon'      => 'menu-icon fa fa-lock',
        'child' => array(
            '7_1' => array(
                'is_menu'=>1,
                'type'      => 'item',
                'name'      => '充值',
                'url'       =>'/taskmanage/index/lists',
                'child'     => array(
                    '7_1_1' => array('is_menu'=>0, 'name'=>'修改任务管理列表', 'url'=>'/taskmanage/index/updates'),
                ),
            ),
            '7_2' => array(
                'is_menu'=>1,
                'type'      => 'item',
                'name'      => '开具发票',
                'url'       =>'/taskmanage/index/galalist',
                'child'     => array(
                    '7_2_1' => array('is_menu'=>0, 'name'=>'新增节日管理', 'url'=>'/taskmanage/index/addtask'),
                    '7_2_2' => array('is_menu'=>0, 'name'=>'编辑节日管理', 'url'=>'/taskmanage/index/addtask'),
                ),
            ),
            '7_3' => array(
                'is_menu'=>1,
                'type'      => 'item',
                'name'      => '提现管理',
                'url'       =>'/taskmanage/index/signinlist',
                'child'     => array(
                    '7_3_1' => array('is_menu'=>0, 'name'=>'新增签到文本', 'url'=>'/taskmanage/index/addsignin'),
                    '7_3_2' => array('is_menu'=>0, 'name'=>'下载模板', 'url'=>'/taskmanage/index/downtpl'),
                    '7_3_3' => array('is_menu'=>0, 'name'=>'导入签到文本', 'url'=>'/taskmanage/index/import'),
                ),
            ),
        ),
    ),
);