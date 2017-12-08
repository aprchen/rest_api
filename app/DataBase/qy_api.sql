/*
 Navicat Premium Data Transfer

 Source Server         : localhost-3306
 Source Server Type    : MySQL
 Source Server Version : 50720
 Source Host           : localhost
 Source Database       : qy_api

 Target Server Type    : MySQL
 Target Server Version : 50720
 File Encoding         : utf-8

 Date: 12/08/2017 19:47:16 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `sl_role`
-- ----------------------------
DROP TABLE IF EXISTS `sl_role`;
CREATE TABLE `sl_role` (
  `id` tinyint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '' COMMENT '角色名',
  `description` varchar(255) DEFAULT '' COMMENT '描述',
  `is_active` tinyint(4) DEFAULT '0' COMMENT '0不可用,1可用',
  `gmt_create` datetime DEFAULT CURRENT_TIMESTAMP,
  `gmt_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色表';

-- ----------------------------
--  Table structure for `sl_user`
-- ----------------------------
DROP TABLE IF EXISTS `sl_user`;
CREATE TABLE `sl_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nick_name` varchar(255) DEFAULT '' COMMENT '昵称',
  `user_name` varchar(255) DEFAULT '' COMMENT '用户名',
  `password` varchar(255) DEFAULT '' COMMENT '登录密码',
  `real_name` varchar(255) DEFAULT '' COMMENT '真实姓名',
  `mobile_phone` char(11) DEFAULT '' COMMENT '手机号',
  `is_active` tinyint(4) DEFAULT '0' COMMENT '0 未激活,1激活',
  `email` varchar(255) DEFAULT '' COMMENT '邮箱',
  `sex` tinyint(4) DEFAULT '0' COMMENT '0 女,1男',
  `money` decimal(10,0) DEFAULT '0',
  `frozen_money` decimal(10,0) DEFAULT '0',
  `is_email_verified` tinyint(4) DEFAULT '0' COMMENT '0未验证,1已验证',
  `is_mobile_phone_verified` tinyint(4) DEFAULT '0' COMMENT '0 未验证,1验证',
  `gmt_create` datetime DEFAULT CURRENT_TIMESTAMP,
  `gmt_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_email` (`email`) USING HASH,
  UNIQUE KEY `uk_mobile_phone` (`mobile_phone`) USING HASH,
  UNIQUE KEY `uk_user_name` (`user_name`) USING HASH,
  KEY `idx_nick_name` (`nick_name`) USING BTREE,
  KEY `idx_is_active` (`is_active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理用户表';

-- ----------------------------
--  Table structure for `sl_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `sl_user_role`;
CREATE TABLE `sl_user_role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL COMMENT '后台用户角色',
  `role_id` tinyint(4) NOT NULL,
  `gmt_create` datetime DEFAULT CURRENT_TIMESTAMP,
  `gmt_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
