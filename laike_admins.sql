/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : zygw_leju_com

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2018-07-19 15:41:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for laike_admins
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
-- Records of laike_admins
-- ----------------------------
INSERT INTO `wy_admins` VALUES ('1', 'admin', 'eb3c2321934e2be5a92a2b3e6dc9cf40', '123', '', '', '1', '1,2_1_1,2_1_2,2_1_3,2_1_4,2_2_1,2_2_2,2_2_3,2_2_4,2_2_5,3_1,3_2,4_1,4_2,5,6,2_1,2_2,2,3,4', '1', '1', '0', '1498716481');
