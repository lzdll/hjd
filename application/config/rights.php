<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
// 操作权限、菜单权限
$config['rights'] = array(
     //运营平台权限
    '1' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'item',          // 类型 item菜单  folder目录
        'name'      => '首页',            //运营平台
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
            '3_4' => array('is_menu'=>0, 'name'=>'封号操作', 'url'=>'/flow/index/sealoff'),
            '3_5' => array('is_menu'=>0, 'name'=>'更新广告价格', 'url'=>'/flow/index/setslotmoney'),
            '3_6' => array('is_menu'=>0, 'name'=>'开启广告位', 'url'=>'/flow/index/updateslotprice'),
            '3_7' => array('is_menu'=>0, 'name'=>'关闭广告位', 'url'=>'/flow/index/updateslotprice'),
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
		 '4_3' => array('is_menu'=>0, 'name'=>'重置密码', 'url'=>'/advertiser/index/resetpwd'),
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
		   '5_2' => array('is_menu'=>0, 'name'=>'绑定', 'url'=>'/advert/index/binding'),
		   '5_3' => array('is_menu'=>0, 'name'=>'修改cmp', 'url'=>'/advert/index/editcmp'),
		   '5_4' => array('is_menu'=>0, 'name'=>'上线', 'url'=>'/advert/index/online'),
		   '5_5' => array('is_menu'=>0, 'name'=>'广告详情', 'url'=>'/advert/index/details'),
		   '5_6' => array('is_menu'=>0, 'name'=>'审核', 'url'=>'/advert/index/adopts'),
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
			'6_3' => array('is_menu'=>0, 'name'=>'上传图片', 'url'=>'/sdk/index/setimg'),
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
		

        ),
    ),
	//11-19广告主权限
	'11' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'item',          // 类型 item菜单  folder目录
        'name'      => '首页',            //广告主
        'url'       => '/ad/index/index',
        'class'     => '',
        'icon'      => 'menu-icon fa fa-cog',
        'child' => array(
            '11_1' => array('is_menu'=>0, 'name'=>'限额修改', 'url'=>'/ad/index/editquota'),
        ),
    ),
	'12' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'folder',          // 类型 item菜单  folder目录
        'folder'    => '/ad/',         // 类型 item菜单  folder目录
        'name'      => '广告',
        'url'       => '/ad/index/lists',
        'class'     => '',
        'icon'      => 'menu-icon fa fa-cog',
        'child' => array(
            '12_1' => array('is_menu'=>0, 'name'=>'添加广告', 'url'=>'/ad/index/add'),
            '12_2' => array('is_menu'=>0, 'name'=>'查看详情', 'url'=>'/ad/index/details'),
            '12_3' => array('is_menu'=>0, 'name'=>'广告编辑', 'url'=>'/ad/index/edit'),
            '12_4' => array('is_menu'=>0, 'name'=>'图片上传', 'url'=>'/ad/index/setimg'),
        ),
    ),
	//广告主
	'13' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'folder',
        'folder'    => '/finance/',         // 类型 item菜单  folder目录
        'name'      => '财务',
        'url'       => '/finance/index/listrecord',
        'class'     => 'dropdown-toggle',
        'icon'      => 'menu-icon fa fa-lock',
        'child' => array(
			'13_1' => array(
                'is_menu'=>1,
                'type'      => 'item',
                'name'      => '充值',
                'url'       =>'/finance/index/listrecord',
            ),
            '13_2' => array(
                'is_menu'=>1,
                'type'      => 'item',
                'name'      => '开具发票',
                'url'       =>'/finance/index/adinvoice',
                'child'     => array(
                    '13_1_1' => array('is_menu'=>0, 'name'=>'开票', 'url'=>'/finance/index/add_adinvoice'),
                ),
            ),
        ),
    ),
	'14' => array(
        'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
        'type'      => 'folder',
        'folder'    => '/member/',         // 类型 item菜单  folder目录
        'name'      => '个人中心',
        'url'       => '/member/index/lists',
        'class'     => 'dropdown-toggle',
        'icon'      => 'menu-icon fa fa-lock',
        'child' => array(
            '14_1' => array(
                'is_menu'=>1,
                'type'      => 'item',
                'name'      => '用户资料',
                'url'       =>'/member/index/lists',
                'child'     => array(
                 
                ),
            ),
            '14_2' => array(
                'is_menu'=>1,
                'type'      => 'item',
                'name'      => '修改密码',
                'url'       =>'/member/index/edit',
                'child'     => array(
                 
                ),
            ),
            
        ),
    ),

  //以下全是流量主权限
	'20' => array(
		'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
		'type'      => 'item',          // 类型 item菜单  folder目录
		'name'      => '首页',            //流量主
		'url'       => '/slot/index/index',
		'class'     => '',
		'icon'      => 'menu-icon fa fa-cog',
		'child' => array(
		),
	),
	'21' => array(
		'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
		'type'      => 'folder',          // 类型 item菜单  folder目录
		'folder'    => '/myad/',         // 类型 item菜单  folder目录
		'name'      => '我的广告位',
		'url'       => '/myad/index/lists',
		'class'     => '',
		'icon'      => 'menu-icon fa fa-cog',
		'child' => array(
			'21_1' => array('is_menu'=>0, 'name'=>'添加广告', 'url'=>'/myad/index/add'),
			'21_2' => array('is_menu'=>0, 'name'=>'查看详情', 'url'=>'/myad/index/details'),
			'21_3' => array('is_menu'=>0, 'name'=>'设置', 'url'=>'/myad/index/intercalate'),
		),
	),
	'22' => array(
			'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
			'type'      => 'folder',
			'folder'    => '/withdraw/',         // 类型 item菜单  folder目录
			'name'      => '提现管理',
			'url'       => '/withdraw/index/lists',
			'class'     => 'dropdown-toggle',
			'icon'      => 'menu-icon fa fa-lock',
			'child' => array(
				'22_1' => array(
					'is_menu'=>0,
					'type'      => 'item',
					'name'      => '提现申请',
					'url'       =>'/withdraw/index/apply',
				),
				
			),
		),
	'23' => array(
		'is_menu'   => 1,               // 是否是菜单(是否显示为菜单)
		'type'      => 'folder',
		'folder'    => '/myad/',         // 类型 item菜单  folder目录
		'name'      => '个人中心',
		'url'       => '/member/index/lists',
		'class'     => 'dropdown-toggle',
		'icon'      => 'menu-icon fa fa-lock',
		'child' => array(
			'23_1' => array(
				'is_menu'=>1,
				'type'      => 'item',
				'name'      => '用户资料',
				'url'       =>'/member/index/lists',
				'child'     => array(
				),
			),
			'23_2' => array(
			    'is_menu'=>1,
			    'type'      => 'item',
			    'name'      => '修改密码',
			    'url'       =>'/member/index/edit',
			    'child'     => array(
				),
			),
			
		),
	),
);