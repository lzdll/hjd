/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : money_ex

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2018-07-19 18:13:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wy_account
-- ----------------------------
DROP TABLE IF EXISTS `wy_account`;
CREATE TABLE `wy_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `code` char(32) NOT NULL COMMENT '账户编号',
  `owner` char(32) NOT NULL COMMENT '用户编号user.code',
  `credit` float NOT NULL COMMENT '广告主授信金额',
  `total_money` float NOT NULL COMMENT '资金总额 广告主(累计充值)/流量主(累计收入)',
  `money` float NOT NULL COMMENT '资金余额 广告主(可用投放总额)/流量主(可提现总额)',
  `quota` float NOT NULL COMMENT '每日限额',
  PRIMARY KEY (`id`),
  UNIQUE KEY `owner` (`owner`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='账户';

-- ----------------------------
-- Records of wy_account
-- ----------------------------

-- ----------------------------
-- Table structure for wy_ad
-- ----------------------------
DROP TABLE IF EXISTS `wy_ad`;
CREATE TABLE `wy_ad` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `code` int(32) NOT NULL COMMENT '广告编号',
  `owner` int(32) NOT NULL COMMENT '广告所有者user.code',
  `platform` enum('android','ios','H5','wechat') NOT NULL COMMENT '去向平台',
  `name` varchar(30) NOT NULL COMMENT '广告名称',
  `info` varchar(200) NOT NULL COMMENT '广告导语',
  `image` varchar(200) NOT NULL COMMENT '广告图',
  `banner` varchar(200) NOT NULL COMMENT '广告banner图',
  `icon` varchar(200) NOT NULL COMMENT '广告图标',
  `link` varchar(200) NOT NULL COMMENT '跳转链接',
  `appid` char(32) NOT NULL COMMENT '小程序appid',
  `ws_code` char(32) NOT NULL COMMENT 'SDK编号 wsdk.code',
  `status` tinyint(2) NOT NULL COMMENT '广告状态 0:上线 1:下线',
  `audit_status` tinyint(2) NOT NULL COMMENT '审核状态 0:等待审核 1:通过审核 3:未过审核',
  `created_time` int(10) NOT NULL COMMENT '创建时间',
  `updated_time` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `audit_status` (`audit_status`),
  KEY `owner` (`owner`),
  KEY `code` (`code`),
  KEY `ws_code` (`ws_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告信息';

-- ----------------------------
-- Records of wy_ad
-- ----------------------------

-- ----------------------------
-- Table structure for wy_admins
-- ----------------------------
DROP TABLE IF EXISTS `wy_admins`;
CREATE TABLE `wy_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(50) NOT NULL COMMENT '登录名',
  `password` char(32) NOT NULL,
  `real_name` varchar(50) NOT NULL COMMENT '真实姓名',
  `nick_name` varchar(50) NOT NULL COMMENT '昵称',
  `city_rights` text NOT NULL COMMENT '城市权限',
  `role_id` int(11) DEFAULT NULL COMMENT '角色id',
  `operate_rights` text NOT NULL COMMENT '操作权限',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 0-启用 1-关闭 ',
  `operator` int(11) NOT NULL COMMENT '操作人id ',
  `ctime` int(10) NOT NULL COMMENT '创建时间',
  `utime` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wy_admins
-- ----------------------------
INSERT INTO `wy_admins` VALUES ('1', 'admin', 'eb3c2321934e2be5a92a2b3e6dc9cf40', '123', '', '', '1', '1,2_1_1,2_1_2,2_1_3,2_1_4,2_2_1,2_2_2,2_2_3,2_2_4,2_2_5,3_1,3_2,4_1,4_2,5,6,2_1,2_2,2,3,4', '1', '1', '0', '1498716481');

-- ----------------------------
-- Table structure for wy_admins_role
-- ----------------------------
DROP TABLE IF EXISTS `wy_admins_role`;
CREATE TABLE `wy_admins_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `operate_rights` text COMMENT '操作权限',
  `type` tinyint(1) DEFAULT '1' COMMENT '0:广告主 1: 流量主 2:运营',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 0：关闭    1：正常 ',
  `admin_id` int(11) DEFAULT NULL COMMENT '操作人',
  `utime` int(10) DEFAULT NULL COMMENT '更新时间',
  `ctime` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of wy_admins_role
-- ----------------------------
INSERT INTO `wy_admins_role` VALUES ('1', '超级管理员', '1,2,3,4,5,6,7,2_1_1,2_1_2,2_1_3,2_1_4,2_2_1,2_2_2,2_2_3,2_2_4,2_2_5,3_1,3_2,4_1,4_2,2_1,2_2,7_1_1,7_2_1,7_2_2,7_3_1,7_3_2,7_3_3,7_1,7_2,7_3', '2', '1', '1', '1531995192', '1489999641');
INSERT INTO `wy_admins_role` VALUES ('2', '广告主', '1,2,3,4,5,6,2_1_1,2_1_2,2_1_3,2_1_4,2_2_1,2_2_2,2_2_3,2_2_4,2_2_5,3_1,3_2,4_1,4_2,2_1,2_2', '0', '1', '1', '1498011769', '1492496329');
INSERT INTO `wy_admins_role` VALUES ('3', '流量主', '1,2,3,4,5,6,2_1_1,2_1_2,2_1_3,2_1_4,2_2_1,2_2_2,2_2_3,2_2_4,2_2_5,3_1,3_2,4_1,4_2,2_1,2_2', '1', '1', '2147483647', '1499409547', '1498617603');

-- ----------------------------
-- Table structure for wy_ad_order
-- ----------------------------
DROP TABLE IF EXISTS `wy_ad_order`;
CREATE TABLE `wy_ad_order` (
  `id` int(10) NOT NULL COMMENT '自增主键',
  `code` char(32) NOT NULL COMMENT '订单编号',
  `created_time` int(10) NOT NULL COMMENT '成单时间',
  `st_platform` enum('android','ios','h5','wechat') NOT NULL COMMENT '槽位所在平台',
  `ad_platform` enum('android','ios','h5','wechat') NOT NULL COMMENT '广告去向平台',
  `province` varchar(20) NOT NULL COMMENT '省份',
  `city` varchar(20) NOT NULL COMMENT '城市',
  `uid` int(10) NOT NULL COMMENT '用户编号',
  `sex` tinyint(2) NOT NULL COMMENT '用户性别 0:男 1:女 2:其他',
  `type` tinyint(2) NOT NULL COMMENT '计费方式 0:CPC点击计费/ 1:CPM展示计费',
  `st_price` float NOT NULL COMMENT '槽位价格',
  `ad_price` float NOT NULL COMMENT '广告价格',
  `co_price` float NOT NULL COMMENT '佣金收入',
  `st_owner` char(32) NOT NULL COMMENT '槽位所有者st.owner',
  `st_code` char(32) NOT NULL COMMENT '槽位编号st.code',
  `st_name` varchar(30) NOT NULL COMMENT '槽位名称name.name',
  `ad_owner` char(32) NOT NULL COMMENT '广告投放者ad.owner',
  `ad_code` char(32) NOT NULL COMMENT '广告编号ad.code',
  `ad_name` varchar(30) NOT NULL COMMENT '广告名称ad.name',
  `extend` varchar(100) NOT NULL COMMENT '广告/槽位(价格)快照/json；用于排查问题和数据分析',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `created_time` (`created_time`),
  KEY `st_platform` (`st_platform`),
  KEY `ad_platform` (`ad_platform`),
  KEY `st_owner` (`st_owner`),
  KEY `st_code` (`st_code`),
  KEY `ad_owner` (`ad_owner`),
  KEY `ad_code` (`ad_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告订单';

-- ----------------------------
-- Records of wy_ad_order
-- ----------------------------

-- ----------------------------
-- Table structure for wy_ad_price
-- ----------------------------
DROP TABLE IF EXISTS `wy_ad_price`;
CREATE TABLE `wy_ad_price` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `user_code` char(32) NOT NULL COMMENT '用户编号user.code',
  `ad_code` char(32) NOT NULL COMMENT '广告编码ad.code',
  `type` tinyint(2) unsigned NOT NULL COMMENT '计费方式 CPC:点击计费 1:CPM展示计费',
  `code` char(32) NOT NULL COMMENT '广告报价编号',
  `price` float unsigned NOT NULL COMMENT '广告价格',
  `status` tinyint(2) unsigned NOT NULL COMMENT '广告状态 0:开启 1:关闭',
  `created_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `user_code` (`user_code`),
  KEY `ad_code` (`ad_code`),
  KEY `type` (`type`),
  KEY `code` (`code`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告报价表';

-- ----------------------------
-- Records of wy_ad_price
-- ----------------------------

-- ----------------------------
-- Table structure for wy_company
-- ----------------------------
DROP TABLE IF EXISTS `wy_company`;
CREATE TABLE `wy_company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `type` tinyint(2) unsigned NOT NULL COMMENT '公司类型 0:个人 1:企业',
  `code` char(32) NOT NULL COMMENT '公司编号，唯一',
  `name` varchar(100) NOT NULL COMMENT '姓名／公司名',
  `owner` char(32) NOT NULL COMMENT '用户编号 user.code',
  `bs_license_img` varchar(200) NOT NULL COMMENT '营业执照',
  `id_card_img_1` varchar(200) CHARACTER SET utf16 NOT NULL COMMENT '身份证照(正面)',
  `id_card_img_2` varchar(200) NOT NULL COMMENT '身份证照(反面)',
  `status` tinyint(2) unsigned NOT NULL COMMENT '状态 0:正常 1:封号',
  `audit_status` tinyint(2) unsigned NOT NULL COMMENT '0未审核 1审核未过 2审核通过',
  `created_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `updated_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `code` (`code`),
  KEY `status` (`status`),
  KEY `audit_status` (`audit_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公司表';

-- ----------------------------
-- Records of wy_company
-- ----------------------------

-- ----------------------------
-- Table structure for wy_finance
-- ----------------------------
DROP TABLE IF EXISTS `wy_finance`;
CREATE TABLE `wy_finance` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `code` char(32) NOT NULL COMMENT '唯一键',
  `operator` char(32) NOT NULL COMMENT '运营编号user.code (运营)',
  `owner` char(32) NOT NULL COMMENT '用户编号user.code (广告主/流量主)',
  `subject` tinyint(2) NOT NULL COMMENT '科目 0:提现 1:充值',
  `money` float NOT NULL COMMENT '充值/转账金额',
  `bank` varchar(100) CHARACTER SET utf16 NOT NULL COMMENT '银行名称',
  `cardid` varchar(20) NOT NULL COMMENT '银行卡号',
  `tradid` varchar(20) NOT NULL COMMENT '交易编号',
  `status` tinyint(2) NOT NULL COMMENT '财务状态   充值:0:已充值 1:未充值 提现: 0:已打款 1:未打款',
  `comment` varchar(100) NOT NULL COMMENT '财务备注',
  `created_time` int(10) NOT NULL COMMENT '申请提现/充值时间',
  `updated_time` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `operator` (`operator`),
  KEY `owner` (`owner`),
  KEY `subject` (`subject`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='财务';

-- ----------------------------
-- Records of wy_finance
-- ----------------------------

-- ----------------------------
-- Table structure for wy_invoice
-- ----------------------------
DROP TABLE IF EXISTS `wy_invoice`;
CREATE TABLE `wy_invoice` (
  `id` int(11) NOT NULL COMMENT '自增主键',
  `code` int(11) NOT NULL COMMENT '发票税号',
  `operator` int(11) NOT NULL COMMENT '运营编号user.code (运营)',
  `owner` int(11) NOT NULL COMMENT '用户编号user.code (广告主/流量主)',
  `title` int(11) NOT NULL COMMENT '发票抬头',
  `taxid` int(11) NOT NULL COMMENT '发票税号',
  `money` int(11) NOT NULL COMMENT '发票金额',
  `img` int(11) NOT NULL COMMENT '发票图片',
  `status` int(11) NOT NULL COMMENT '发票状态 1:已开 0:未开',
  `created_time` int(11) NOT NULL COMMENT '创建时间',
  `updated_time` int(11) NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `operator` (`operator`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发票';

-- ----------------------------
-- Records of wy_invoice
-- ----------------------------

-- ----------------------------
-- Table structure for wy_slot_price
-- ----------------------------
DROP TABLE IF EXISTS `wy_slot_price`;
CREATE TABLE `wy_slot_price` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `user_code` int(32) NOT NULL COMMENT '用户编号user.code',
  `st_code` int(32) NOT NULL COMMENT '槽位编码st.code',
  `type` tinyint(2) NOT NULL COMMENT '计费方式 CPC:点击计费 1:CPM展示计费',
  `code` char(32) NOT NULL COMMENT '槽位报价编号',
  `price` float NOT NULL COMMENT '槽位单价(指导价 )',
  `status` tinyint(2) NOT NULL COMMENT '槽位状态  0:开启 1:关闭',
  `created_time` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `user_code` (`user_code`),
  KEY `st_code` (`st_code`),
  KEY `type` (`type`),
  KEY `code` (`code`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='槽位报价';

-- ----------------------------
-- Records of wy_slot_price
-- ----------------------------

-- ----------------------------
-- Table structure for wy_st
-- ----------------------------
DROP TABLE IF EXISTS `wy_st`;
CREATE TABLE `wy_st` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `code` char(32) NOT NULL COMMENT '槽位编号',
  `owner` char(32) NOT NULL COMMENT '槽位所有者user.code',
  `name` varchar(100) NOT NULL COMMENT '槽位名称',
  `info` varchar(200) NOT NULL COMMENT '槽位简介',
  `icon` varchar(200) NOT NULL COMMENT '槽位图标',
  `callback` varchar(200) NOT NULL COMMENT '回调地址',
  `callback_status` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '0:不支持回调 1:支持回调',
  `secret` varchar(100) NOT NULL COMMENT '接口签名',
  `status` tinyint(2) unsigned NOT NULL COMMENT '槽位状态0:开启 1:关闭',
  `created_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `updated_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `owner` (`owner`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告槽位';

-- ----------------------------
-- Records of wy_st
-- ----------------------------

-- ----------------------------
-- Table structure for wy_user
-- ----------------------------
DROP TABLE IF EXISTS `wy_user`;
CREATE TABLE `wy_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `type` tinyint(2) unsigned NOT NULL COMMENT '0:广告主 1: 流量主 2:运营',
  `code` char(32) NOT NULL COMMENT '用户编号／唯一键',
  `login_name` varchar(16) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `role_id` int(11) DEFAULT '0' COMMENT '角色id',
  `operate_rights` varchar(255) DEFAULT NULL COMMENT '操作权限',
  `phone` int(10) unsigned NOT NULL COMMENT '手机号',
  `email` char(100) NOT NULL COMMENT '邮箱',
  `status` tinyint(2) unsigned NOT NULL COMMENT '用户状态：0:有效 1:无效',
  `created_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `updated_time` int(10) unsigned NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `code` (`code`) USING BTREE,
  KEY `type` (`type`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of wy_user
-- ----------------------------
INSERT INTO `wy_user` VALUES ('1', '2', '123', 'admin', 'eb3c2321934e2be5a92a2b3e6dc9cf40', '1', '1,2_1_1,2_1_2,2_1_3,2_1_4,2_2_1,2_2_2,2_2_3,2_2_4,2_2_5,3_1,3_2,4_1,4_2,5,6,2_1,2_2,2,3,4', '4294967295', 'liming10@leju.com', '1', '1498716481', '1498716481');

-- ----------------------------
-- Table structure for wy_wsdk
-- ----------------------------
DROP TABLE IF EXISTS `wy_wsdk`;
CREATE TABLE `wy_wsdk` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `code` char(32) NOT NULL COMMENT 'SDK编号',
  `operator` char(32) NOT NULL COMMENT '运营编号user.code (运营)',
  `name` char(30) NOT NULL COMMENT 'SDK名称',
  `url` char(100) NOT NULL COMMENT '跳转地址',
  `sappid` char(32) NOT NULL COMMENT '小程序原始appid',
  `appid` char(32) NOT NULL COMMENT 'appid',
  `app_secret` char(100) NOT NULL COMMENT '小程序AppSecret',
  `icon` char(200) NOT NULL COMMENT '小程序图标',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态 1:禁用 0:启用',
  `created_time` int(10) NOT NULL COMMENT '创建时间',
  `updated_time` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `operator` (`operator`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信小程序SDK';

-- ----------------------------
-- Records of wy_wsdk
-- ----------------------------
ssh ubuntu@106.75.33.230

20L 服务器器
1、web
IP：106.75.33.230 

 username : ubuntu password:JqMAA8u/K6HmKp82
2、db
IP:10.19.66.173 

 username : money-ex password:DzT292GYMez/ea9i
db:money_ex
3、oss
管理理地址：https://console.ucloud.cn/ufile/ufile 

 
加速域名：osv.ufile.ucloud.com.cn 

 访问域名：osv.cn-bj.ufileos.com 

 
UCLOUD_PROXY_SUFFIX = '.cn-bj.ufileos.com 

';
UCLOUD_PUBLIC_KEY = 'ucloudwuchuanchang@163.com14055813821394714674'; UCLOUD_PRIVATE_KEY = ‘3d14921cef317edc51463d6a22a09b23ddc18e5f';


 sdk : https://github.com/ufilesdk-dev/ufile-phpsdk 

 
3、域名解析
⼴广告平台域名：console.osv.cn 

备注：上线都⾛走https. 在负载均衡器器上设置ssl域名证书。
 
 
4、数据库管理理地址（需配置host）
106.75.33.230 

 db2018.osv.com 



数据库信息地址：10.19.33.173 

用户名：money-ex
密码：DzT292GYMez/ea9i

git地址：git.haojindu.com 

用户名：306298530@qq.com
密码：hjd2018
