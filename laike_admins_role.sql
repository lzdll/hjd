/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : zygw_leju_com

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2018-07-19 15:41:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wy_admins_role
-- ----------------------------
DROP TABLE IF EXISTS `wy_admins_role`;
CREATE TABLE `laike_admins_role` (
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
-- Records of laike_admins_role
-- ----------------------------
INSERT INTO `wy_admins_role` VALUES ('1', '超级管理员', '1,2,3,4,5,6,2_1_1,2_1_2,2_1_3,2_1_4,2_2_1,2_2_2,2_2_3,2_2_4,2_2_5,3_1,3_2,4_1,4_2,2_1,2_2', '1', '1', '1', '1531981426', '1489999641');
INSERT INTO `wy_admins_role` VALUES ('2', '广告主', '4,12,3_1,3_2,3_3,3_4,3_5,3_6,3_7,3_8,3_9,3_10,3_11,4_1_1,4_2_1,5_1,11_1,11_2,11_3,4_1,4_2,12_1_1,12_2_1,12_1,12_2', '1', '1', '1', '1498011769', '1492496329');
INSERT INTO `wy_admins_role` VALUES ('3', '流量主', '2,14,2_1_1,2_1_2,2_1_3,2_1_4,2_2_1,2_2_2,2_2_3,2_2_4,2_2_5,2_1,2_2,14_1_1,14_1_2,14_1', '1', '1', '2147483647', '1499409547', '1498617603');
