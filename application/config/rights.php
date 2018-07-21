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
        'folder'    => '/flow/',         // 类型 item菜单  folder目录
        'name'      => '流量主',
        'url'       => '/flow/index/lists',
        'class'     => '',
        'icon'      => 'menu-icon fa fa-cog',
        'child' => array(
            '3_1' => array('is_menu'=>0, 'name'=>'添加流量主', 'url'=>'/flow/index/add'),
            '3_2' => array('is_menu'=>0, 'name'=>'查看详情', 'url'=>'/flow/index/details'),
			'3_3' => array('is_menu'=>0, 'name'=>'重置密码', 'url'=>'/flow/index/resetpwd'),
        ),
    ), 
    '4' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'folder',          // 类型 item菜单  folder目录
        'folder'    => '/advertiser/',         // 类型 item菜单  folder目录
        'name'      => '广告主',
        'url'       => '/advertiser/index/lists',
        'class'     => '',
        'icon'      => 'menu-icon fa fa-cog',
        'child' => array(
		 '4_1' => array('is_menu'=>0, 'name'=>'添加广告主', 'url'=>'/advertiser/index/add'),
		 '4_2' => array('is_menu'=>0, 'name'=>'查看详情', 'url'=>'/advertiser/index/details'),
		 '4_3' => array('is_menu'=>0, 'name'=>'重置密码', 'url'=>'/flow/index/resetpwd'),
        ),
    ),
    '5' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'folder',
        'folder'    => '/advert/',         // 类型 item菜单  folder目录
        'name'      => '广告管理',
        'url'       => '/advert/index/lists',
        'class'     => '',
        'icon'      => 'menu-icon fa fa-cog',
        'child' => array(
           '5_1' => array('is_menu'=>0, 'name'=>'待审核', 'url'=>'/advert/index/adopt'),
		   '5_2' => array('is_menu'=>0, 'name'=>'添加小程序', 'url'=>'/advert/index/adopt'),
        
        ),
    ), 
    '6' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'folder',          // 类型 item菜单  folder目录
        'name'      => 'SDK管理',
        'url'       => '/sdk/index/lists',
        'class'     => '',
        'icon'      => 'menu-icon fa fa-cog',
        'child' => array(
            '6_1' => array('is_menu'=>0, 'name'=>'添加SDK', 'url'=>'/sdk/index/add'),
			'6_2' => array('is_menu'=>0, 'name'=>'操作SDK', 'url'=>'/sdk/index/cancel'),
        ),
 
    ), 
 
    '7' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'folder',
        'folder'    => '/finance/',         // 类型 item菜单  folder目录
        'name'      => '财务',
        'url'       => '/finance/index/lists',
        'class'     => 'dropdown-toggle',
        'icon'      => 'menu-icon fa fa-lock',
        'child' => array(
            '7_1' => array(
                'is_menu'=>1,
                'type'      => 'item',
                'name'      => '充值',
                'url'       =>'/finance/index/lists',
                'child'     => array(
                    '7_1_1' => array('is_menu'=>0, 'name'=>'充值', 'url'=>'/finance/index/add'),
                ),
            ),
            '7_2' => array(
                'is_menu'=>1,
                'type'      => 'item',
                'name'      => '开具发票',
                'url'       =>'/finance/index/invoice',
                'child'     => array(
                    '7_2_1' => array('is_menu'=>0, 'name'=>'开票', 'url'=>'/finance/index/add_invoice'),
                    '7_2_2' => array('is_menu'=>0, 'name'=>'查看发票', 'url'=>'/finance/index/seeinv'),
                ),
            ),
            '7_3' => array(
                'is_menu'=>1,
                'type'      => 'item',
                'name'      => '提现管理',
                'url'       =>'/finance/index/present',
                'child'     => array(
                    '7_3_1' => array('is_menu'=>0, 'name'=>'标记', 'url'=>'/finance/index/unexecuted'),
                ),
            ),
			'7_4' => array(
                'is_menu'=>1,
                'type'      => 'item',
                'name'      => '开具发票',
                'url'       =>'/finance/index/adinvoice',
                'child'     => array(
                    '7_4_1' => array('is_menu'=>0, 'name'=>'开票', 'url'=>'/finance/index/add_adinvoice'),
                ),
            ),
			'7_5' => array(
                'is_menu'=>1,
                'type'      => 'item',
                'name'      => '充值',
                'url'       =>'/finance/index/listrecord',
            ),

        ),
    ),


	'8' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'folder',          // 类型 item菜单  folder目录
        'folder'    => '/ad/',         // 类型 item菜单  folder目录
        'name'      => '广告',
        'url'       => '/ad/index/lists',
        'class'     => '',
        'icon'      => 'menu-icon fa fa-cog',
        'child' => array(
            '8_1' => array('is_menu'=>0, 'name'=>'添加广告', 'url'=>'/ad/index/add'),
            '8_2' => array('is_menu'=>0, 'name'=>'查看详情', 'url'=>'/ad/index/details'),
        ),
    ),
	
	'9' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'folder',
        'folder'    => '/member/',         // 类型 item菜单  folder目录
        'name'      => '个人中心',
        'url'       => '/member/index/lists',
        'class'     => 'dropdown-toggle',
        'icon'      => 'menu-icon fa fa-lock',
        'child' => array(
            '9_1' => array(
                'is_menu'=>1,
                'type'      => 'item',
                'name'      => '用户资料',
                'url'       =>'/member/index/lists',
                'child'     => array(
                 
                ),
            ),
            '9_2' => array(
                'is_menu'=>1,
                'type'      => 'item',
                'name'      => '修改密码',
                'url'       =>'/member/index/edit',
                'child'     => array(
                 
                ),
            ),
            
        ),
    ),

	'10' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'folder',          // 类型 item菜单  folder目录
        'folder'    => '/myad/',         // 类型 item菜单  folder目录
        'name'      => '我的广告位',
        'url'       => '/myad/index/lists',
        'class'     => '',
        'icon'      => 'menu-icon fa fa-cog',
        'child' => array(
            '10_1' => array('is_menu'=>0, 'name'=>'添加广告', 'url'=>'/myad/index/add'),
            '10_2' => array('is_menu'=>0, 'name'=>'查看详情', 'url'=>'/myad/index/details'),
			'10_3' => array('is_menu'=>0, 'name'=>'设置', 'url'=>'/myad/index/intercalate'),
        ),
    ),
);