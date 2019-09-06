/*
 Navicat Premium Data Transfer

 Source Server         : zhss
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : 152.136.129.13:13306
 Source Schema         : zhss

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 06/09/2019 18:10:31
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for Auth_DW_tb
-- ----------------------------
DROP TABLE IF EXISTS `Auth_DW_tb`;
CREATE TABLE `Auth_DW_tb` (
  `Auth_DW_id` int(22) NOT NULL AUTO_INCREMENT,
  `Auth_DW_name` varchar(255) NOT NULL,
  `Auth_DW_logo` varchar(255) NOT NULL,
  PRIMARY KEY (`Auth_DW_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of Auth_DW_tb
-- ----------------------------
BEGIN;
INSERT INTO `Auth_DW_tb` VALUES (1, 'TIM科技', 'http://pass.timkj.com/logo.png');
COMMIT;

-- ----------------------------
-- Table structure for Auth_GNJS_tb
-- ----------------------------
DROP TABLE IF EXISTS `Auth_GNJS_tb`;
CREATE TABLE `Auth_GNJS_tb` (
  `Auth_GNJS_id` int(22) NOT NULL,
  `Auth_GNJS_GN_id` int(22) NOT NULL,
  `Auth_GNJS_JS_id` int(22) NOT NULL,
  PRIMARY KEY (`Auth_GNJS_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of Auth_GNJS_tb
-- ----------------------------
BEGIN;
INSERT INTO `Auth_GNJS_tb` VALUES (1, 1, 1);
INSERT INTO `Auth_GNJS_tb` VALUES (2, 2, 2);
COMMIT;

-- ----------------------------
-- Table structure for Auth_GN_tb
-- ----------------------------
DROP TABLE IF EXISTS `Auth_GN_tb`;
CREATE TABLE `Auth_GN_tb` (
  `Auth_GN_id` int(22) NOT NULL AUTO_INCREMENT,
  `Auth_GN_DW_id` int(22) NOT NULL,
  `Auth_GN_name` varchar(255) DEFAULT NULL,
  `Auth_GN_type` int(5) DEFAULT NULL,
  PRIMARY KEY (`Auth_GN_id`),
  KEY `dwid` (`Auth_GN_DW_id`) USING BTREE,
  CONSTRAINT `Auth_GN_tb_ibfk_1` FOREIGN KEY (`Auth_GN_DW_id`) REFERENCES `Auth_DW_tb` (`Auth_DW_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of Auth_GN_tb
-- ----------------------------
BEGIN;
INSERT INTO `Auth_GN_tb` VALUES (1, 1, '首页功能', 1);
INSERT INTO `Auth_GN_tb` VALUES (2, 1, '系统管理功能', 999);
COMMIT;

-- ----------------------------
-- Table structure for Auth_JSQX_tb
-- ----------------------------
DROP TABLE IF EXISTS `Auth_JSQX_tb`;
CREATE TABLE `Auth_JSQX_tb` (
  `Auth_JSQX_id` int(22) NOT NULL AUTO_INCREMENT,
  `Auth_JSQX_JS_id` int(22) NOT NULL,
  `Auth_JSQX_QX_id` int(22) NOT NULL,
  PRIMARY KEY (`Auth_JSQX_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of Auth_JSQX_tb
-- ----------------------------
BEGIN;
INSERT INTO `Auth_JSQX_tb` VALUES (1, 1, 1);
INSERT INTO `Auth_JSQX_tb` VALUES (2, 1, 2);
INSERT INTO `Auth_JSQX_tb` VALUES (3, 1, 3);
INSERT INTO `Auth_JSQX_tb` VALUES (4, 2, 4);
INSERT INTO `Auth_JSQX_tb` VALUES (5, 2, 5);
COMMIT;

-- ----------------------------
-- Table structure for Auth_JSUSER_tb
-- ----------------------------
DROP TABLE IF EXISTS `Auth_JSUSER_tb`;
CREATE TABLE `Auth_JSUSER_tb` (
  `Auth_JSUSER_id` int(22) NOT NULL AUTO_INCREMENT,
  `Auth_JSUSER_User_id` int(22) NOT NULL,
  `Auth_JSUSER_DW_id` int(22) NOT NULL,
  `Auth_JSUSER_GN_id` int(22) NOT NULL,
  `Auth_JSUSER_JS_id` int(22) NOT NULL,
  PRIMARY KEY (`Auth_JSUSER_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of Auth_JSUSER_tb
-- ----------------------------
BEGIN;
INSERT INTO `Auth_JSUSER_tb` VALUES (1, 1, 1, 1, 1);
INSERT INTO `Auth_JSUSER_tb` VALUES (2, 1, 1, 2, 2);
COMMIT;

-- ----------------------------
-- Table structure for Auth_JS_tb
-- ----------------------------
DROP TABLE IF EXISTS `Auth_JS_tb`;
CREATE TABLE `Auth_JS_tb` (
  `Auth_JS_id` int(22) NOT NULL AUTO_INCREMENT,
  `Auth_JS_name` varchar(255) NOT NULL,
  PRIMARY KEY (`Auth_JS_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of Auth_JS_tb
-- ----------------------------
BEGIN;
INSERT INTO `Auth_JS_tb` VALUES (1, '首页通用角色');
INSERT INTO `Auth_JS_tb` VALUES (2, '系统超级管理');
COMMIT;

-- ----------------------------
-- Table structure for Auth_QX_tb
-- ----------------------------
DROP TABLE IF EXISTS `Auth_QX_tb`;
CREATE TABLE `Auth_QX_tb` (
  `Auth_QX_id` int(22) NOT NULL AUTO_INCREMENT,
  `Auth_QX_code` varchar(255) NOT NULL,
  `Auth_QX_SU_name` varchar(255) NOT NULL,
  `Auth_QX_title` varchar(255) NOT NULL,
  `Auth_QX_key` varchar(255) DEFAULT NULL,
  `Auth_QX_name` varchar(255) DEFAULT NULL,
  `Auth_QX_component` varchar(255) DEFAULT NULL,
  `Auth_QX_redirect` varchar(255) DEFAULT NULL,
  `Auth_QX_parentId` int(22) DEFAULT NULL,
  `Auth_QX_icon` varchar(255) DEFAULT NULL,
  `Auth_QX_show` int(1) DEFAULT NULL,
  PRIMARY KEY (`Auth_QX_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of Auth_QX_tb
-- ----------------------------
BEGIN;
INSERT INTO `Auth_QX_tb` VALUES (1, '10001', '仪表盘', '仪表盘', NULL, 'dashboard', 'RouteView', NULL, -1, 'dashboard', 1);
INSERT INTO `Auth_QX_tb` VALUES (2, '10002', '工作台', '工作台', 'workplace', 'workplace', 'Workplace', NULL, 1, NULL, 1);
INSERT INTO `Auth_QX_tb` VALUES (3, '10003', '个人设置', '个人设置', 'account', 'account', 'RouteView', NULL, -1, 'user', 1);
INSERT INTO `Auth_QX_tb` VALUES (4, '10004', '个人中心', '个人中心', 'BaseSettings', 'BaseSettings', 'BaseSetting', NULL, 3, NULL, 1);
COMMIT;

-- ----------------------------
-- Table structure for Auth_User_tb
-- ----------------------------
DROP TABLE IF EXISTS `Auth_User_tb`;
CREATE TABLE `Auth_User_tb` (
  `Auth_User_id` int(22) NOT NULL AUTO_INCREMENT,
  `Auth_User_name` varchar(255) NOT NULL,
  `Auth_User_num` varchar(50) NOT NULL,
  `Auth_User_pwd` varchar(50) NOT NULL,
  PRIMARY KEY (`Auth_User_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of Auth_User_tb
-- ----------------------------
BEGIN;
INSERT INTO `Auth_User_tb` VALUES (1, 'admin', 'admin', '8914de686ab28dc22f30d3d8e107ff6c');
COMMIT;

-- ----------------------------
-- Table structure for BindUser_tb
-- ----------------------------
DROP TABLE IF EXISTS `BindUser_tb`;
CREATE TABLE `BindUser_tb` (
  `uuid` int(20) NOT NULL AUTO_INCREMENT,
  `bind_type` int(2) DEFAULT NULL,
  `bind_num` varchar(255) DEFAULT NULL,
  `bind_password` varchar(255) DEFAULT NULL,
  `bind_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `aaa` (`bind_type`,`bind_num`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of BindUser_tb
-- ----------------------------
BEGIN;
INSERT INTO `BindUser_tb` VALUES (1, 1, '15999111', '123456', '2019-08-26 10:02:39');
INSERT INTO `BindUser_tb` VALUES (3, 1, '16180018', '123456', '2019-08-29 18:26:36');
COMMIT;

-- ----------------------------
-- Table structure for comment_tb
-- ----------------------------
DROP TABLE IF EXISTS `comment_tb`;
CREATE TABLE `comment_tb` (
  `comment_id` int(20) NOT NULL AUTO_INCREMENT,
  `comment_postid` int(20) NOT NULL,
  `comment_userid` int(20) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_time` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of comment_tb
-- ----------------------------
BEGIN;
INSERT INTO `comment_tb` VALUES (1, 5, 1, '哈哈', '2019-08-24 20:31:12');
INSERT INTO `comment_tb` VALUES (2, 22, 6, 'hahaa ', '2019-08-29 19:31:57');
COMMIT;

-- ----------------------------
-- Table structure for jbtx_tb
-- ----------------------------
DROP TABLE IF EXISTS `jbtx_tb`;
CREATE TABLE `jbtx_tb` (
  `jbtx_id` int(20) NOT NULL AUTO_INCREMENT,
  `jbtx_userid` int(20) DEFAULT NULL,
  `jbtx_cxlx` varchar(255) DEFAULT NULL,
  `jbtx_cxcc` varchar(255) DEFAULT NULL,
  `jbtx_wxh` text,
  `jbtx_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `jbtx_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`jbtx_id`),
  UNIQUE KEY `11` (`jbtx_userid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jbtx_tb
-- ----------------------------
BEGIN;
INSERT INTO `jbtx_tb` VALUES (5, 5, '0', 'D1771', '11111', '2019-08-30 00:00:00', NULL);
COMMIT;

-- ----------------------------
-- Table structure for like_tb
-- ----------------------------
DROP TABLE IF EXISTS `like_tb`;
CREATE TABLE `like_tb` (
  `like_id` int(20) NOT NULL AUTO_INCREMENT,
  `like_userid` int(20) NOT NULL,
  `like_postid` int(20) NOT NULL,
  `like_time` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`like_id`),
  UNIQUE KEY `1122` (`like_userid`,`like_postid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of like_tb
-- ----------------------------
BEGIN;
INSERT INTO `like_tb` VALUES (1, 1, 5, '2019-08-24 20:30:36');
INSERT INTO `like_tb` VALUES (5, 6, 22, '2019-08-29 19:23:40');
COMMIT;

-- ----------------------------
-- Table structure for post_tb
-- ----------------------------
DROP TABLE IF EXISTS `post_tb`;
CREATE TABLE `post_tb` (
  `post_id` int(20) NOT NULL AUTO_INCREMENT,
  `post_userid` int(20) NOT NULL,
  `post_content` text NOT NULL,
  `post_time` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of post_tb
-- ----------------------------
BEGIN;
INSERT INTO `post_tb` VALUES (23, 1, '{\"text\":\"%E6%AC%A2%E8%BF%8E2019%E7%BA%A7%E6%96%B0%E5%90%8C%E5%AD%A6%7E\",\"images\":[]}', '2019-08-29 19:50:35');
COMMIT;

-- ----------------------------
-- Table structure for user_tb
-- ----------------------------
DROP TABLE IF EXISTS `user_tb`;
CREATE TABLE `user_tb` (
  `user_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_num` varchar(30) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_headImg` varchar(255) DEFAULT 'https://synu.timkj.com/weapp/img/logo1.png',
  `user_xsh` varchar(255) DEFAULT NULL,
  `user_zymc` varchar(255) DEFAULT NULL,
  `user_lastLoginTime` datetime(6) DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `userid` (`user_num`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_tb
-- ----------------------------
BEGIN;
INSERT INTO `user_tb` VALUES (1, 'TIM科技', 'admin', 'dlkfqlib', 'https://synu.timkj.com/weapp/img/logo1.png', '产品研发部', '沈阳谛猫', '2019-08-29 17:33:16.392461');
INSERT INTO `user_tb` VALUES (5, '李鹍', '15999111', '123456', 'http://file.zhss.timkj.com/5/bd/60da7b191684e9886b937efe3a1d40.jpg', '软件学院', '计算机科学与技术', '2019-08-29 18:57:01.722116');
INSERT INTO `user_tb` VALUES (6, '田晓琛', '16180018', '123456', 'http://file.zhss.timkj.com/6/be/8f6512066eac808ec61ea6be66053a.jpg', '软件学院', '网络工程', '2019-08-29 18:58:44.982673');
COMMIT;

-- ----------------------------
-- View structure for Auth
-- ----------------------------
DROP VIEW IF EXISTS `Auth`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `Auth` AS select `Auth_DW_tb`.`Auth_DW_name` AS `Auth_DW_name`,`Auth_DW_tb`.`Auth_DW_logo` AS `Auth_DW_logo`,`Auth_GN_tb`.`Auth_GN_name` AS `Auth_GN_name`,`Auth_JS_tb`.`Auth_JS_name` AS `Auth_JS_name`,`Auth_JSQX_tb`.`Auth_JSQX_QX_id` AS `Auth_JSQX_QX_id`,`Auth_QX_tb`.`Auth_QX_id` AS `Auth_QX_id`,`Auth_QX_tb`.`Auth_QX_code` AS `Auth_QX_code`,`Auth_QX_tb`.`Auth_QX_SU_name` AS `Auth_QX_SU_name`,`Auth_QX_tb`.`Auth_QX_title` AS `Auth_QX_title`,`Auth_QX_tb`.`Auth_QX_key` AS `Auth_QX_key`,`Auth_QX_tb`.`Auth_QX_name` AS `Auth_QX_name`,`Auth_QX_tb`.`Auth_QX_component` AS `Auth_QX_component`,`Auth_QX_tb`.`Auth_QX_redirect` AS `Auth_QX_redirect`,`Auth_QX_tb`.`Auth_QX_parentId` AS `Auth_QX_parentId`,`Auth_QX_tb`.`Auth_QX_icon` AS `Auth_QX_icon` from (((((`Auth_DW_tb` join `Auth_GN_tb` on((`Auth_GN_tb`.`Auth_GN_DW_id` = `Auth_DW_tb`.`Auth_DW_id`))) join `Auth_GNJS_tb` on((`Auth_GNJS_tb`.`Auth_GNJS_GN_id` = `Auth_GN_tb`.`Auth_GN_id`))) join `Auth_JS_tb` on((`Auth_GNJS_tb`.`Auth_GNJS_JS_id` = `Auth_JS_tb`.`Auth_JS_id`))) join `Auth_JSQX_tb` on((`Auth_JS_tb`.`Auth_JS_id` = `Auth_JSQX_tb`.`Auth_JSQX_JS_id`))) join `Auth_QX_tb` on((`Auth_JSQX_tb`.`Auth_JSQX_QX_id` = `Auth_QX_tb`.`Auth_QX_id`)));

-- ----------------------------
-- View structure for Select_comment_v1
-- ----------------------------
DROP VIEW IF EXISTS `Select_comment_v1`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `Select_comment_v1` AS select `user_tb`.`user_name` AS `username`,`comment_tb`.`comment_text` AS `content`,`comment_tb`.`comment_userid` AS `uid`,`comment_tb`.`comment_postid` AS `comment_postid` from (`user_tb` join `comment_tb` on((`comment_tb`.`comment_userid` = `user_tb`.`user_id`)));

-- ----------------------------
-- View structure for Select_jbtx_v1
-- ----------------------------
DROP VIEW IF EXISTS `Select_jbtx_v1`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `Select_jbtx_v1` AS select `user_tb`.`user_name` AS `user_name`,`user_tb`.`user_headImg` AS `user_headImg`,`user_tb`.`user_xsh` AS `user_xsh`,`user_tb`.`user_zymc` AS `user_zymc`,`jbtx_tb`.`jbtx_id` AS `jbtx_id`,`jbtx_tb`.`jbtx_userid` AS `jbtx_userid`,`jbtx_tb`.`jbtx_cxlx` AS `jbtx_cxlx`,`jbtx_tb`.`jbtx_cxcc` AS `jbtx_cxcc`,`jbtx_tb`.`jbtx_wxh` AS `jbtx_wxh`,cast(`jbtx_tb`.`jbtx_date` as date) AS `jbtx_date`,`jbtx_tb`.`jbtx_time` AS `jbtx_time` from (`jbtx_tb` join `user_tb` on((`jbtx_tb`.`jbtx_userid` = `user_tb`.`user_id`)));

-- ----------------------------
-- View structure for Select_like_v1
-- ----------------------------
DROP VIEW IF EXISTS `Select_like_v1`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `Select_like_v1` AS select `like_tb`.`like_postid` AS `like_postid`,`like_tb`.`like_userid` AS `uid`,`user_tb`.`user_name` AS `username` from (`user_tb` join `like_tb` on((`like_tb`.`like_userid` = `user_tb`.`user_id`)));

-- ----------------------------
-- View structure for Select_Trends_v1
-- ----------------------------
DROP VIEW IF EXISTS `Select_Trends_v1`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `Select_Trends_v1` AS select `post_tb`.`post_content` AS `content`,`post_tb`.`post_time` AS `timestamp`,`post_tb`.`post_id` AS `post_id`,`user_tb`.`user_name` AS `username`,`user_tb`.`user_headImg` AS `header_image`,`user_tb`.`user_id` AS `uid` from (`user_tb` join `post_tb` on((`user_tb`.`user_id` = `post_tb`.`post_userid`)));

-- ----------------------------
-- View structure for V_AdminUserMenuList_v1
-- ----------------------------
DROP VIEW IF EXISTS `V_AdminUserMenuList_v1`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `V_AdminUserMenuList_v1` AS select `Auth_QX_tb`.`Auth_QX_id` AS `Auth_QX_id`,`Auth_QX_tb`.`Auth_QX_code` AS `Auth_QX_code`,`Auth_QX_tb`.`Auth_QX_SU_name` AS `Auth_QX_SU_name`,`Auth_QX_tb`.`Auth_QX_title` AS `Auth_QX_title`,`Auth_QX_tb`.`Auth_QX_key` AS `Auth_QX_key`,`Auth_QX_tb`.`Auth_QX_name` AS `Auth_QX_name`,`Auth_QX_tb`.`Auth_QX_component` AS `Auth_QX_component`,`Auth_QX_tb`.`Auth_QX_redirect` AS `Auth_QX_redirect`,`Auth_QX_tb`.`Auth_QX_parentId` AS `Auth_QX_parentId`,`Auth_QX_tb`.`Auth_QX_icon` AS `Auth_QX_icon`,`Auth_User_tb`.`Auth_User_id` AS `Auth_User_id`,`Auth_User_tb`.`Auth_User_num` AS `Auth_User_num`,`Auth_JSUSER_tb`.`Auth_JSUSER_DW_id` AS `Auth_JSUSER_DW_id`,`Auth_JSUSER_tb`.`Auth_JSUSER_GN_id` AS `Auth_JSUSER_GN_id`,`Auth_QX_tb`.`Auth_QX_show` AS `Auth_QX_show` from (((`Auth_User_tb` join `Auth_JSUSER_tb` on((`Auth_User_tb`.`Auth_User_id` = `Auth_JSUSER_tb`.`Auth_JSUSER_User_id`))) join `Auth_JSQX_tb` on((`Auth_JSUSER_tb`.`Auth_JSUSER_JS_id` = `Auth_JSQX_tb`.`Auth_JSQX_JS_id`))) join `Auth_QX_tb` on((`Auth_JSQX_tb`.`Auth_JSQX_QX_id` = `Auth_QX_tb`.`Auth_QX_id`)));

-- ----------------------------
-- View structure for V_AuthUserLogin
-- ----------------------------
DROP VIEW IF EXISTS `V_AuthUserLogin`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `V_AuthUserLogin` AS select `Auth_DW_tb`.`Auth_DW_name` AS `Auth_DW_name`,`Auth_DW_tb`.`Auth_DW_logo` AS `Auth_DW_logo`,`Auth_User_tb`.`Auth_User_name` AS `Auth_User_name`,`Auth_User_tb`.`Auth_User_num` AS `Auth_User_num`,`Auth_User_tb`.`Auth_User_pwd` AS `Auth_User_pwd`,`Auth_DW_tb`.`Auth_DW_id` AS `Auth_DW_id` from ((`Auth_User_tb` join `Auth_JSUSER_tb` on((`Auth_User_tb`.`Auth_User_id` = `Auth_JSUSER_tb`.`Auth_JSUSER_User_id`))) join `Auth_DW_tb` on((`Auth_JSUSER_tb`.`Auth_JSUSER_DW_id` = `Auth_DW_tb`.`Auth_DW_id`))) group by `Auth_DW_tb`.`Auth_DW_id`;

SET FOREIGN_KEY_CHECKS = 1;
