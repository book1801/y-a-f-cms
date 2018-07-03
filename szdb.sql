/*
Navicat MySQL Data Transfer

Source Server         : MyComputer
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : szdb

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2018-06-25 22:41:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `app`
-- ----------------------------
DROP TABLE IF EXISTS `app`;
CREATE TABLE `app` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appcategoryid` int(11) unsigned DEFAULT '0',
  `categoryid` int(11) unsigned DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `appname` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `system` varchar(100) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `content` text,
  `views` int(11) DEFAULT NULL,
  `downs` int(11) DEFAULT NULL,
  `pcdowns` int(11) DEFAULT NULL,
  `mdowns` int(11) DEFAULT NULL,
  `pcdownlink` varchar(200) DEFAULT NULL,
  `pgdownlink` varchar(200) DEFAULT NULL,
  `azdownlink` varchar(200) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `pubdate` int(11) DEFAULT NULL,
  `recommend` int(11) DEFAULT NULL,
  `status` smallint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



-- ----------------------------
-- Table structure for `appcategory`
-- ----------------------------
DROP TABLE IF EXISTS `appcategory`;
CREATE TABLE `appcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `indexorder` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` text,
  `iscomment` int(1) DEFAULT NULL,
  `recommend` int(11) unsigned DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `pubdate` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `articlecategory`
-- ----------------------------
DROP TABLE IF EXISTS `articlecategory`;
CREATE TABLE `articlecategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `indexorder` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `comment`
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `typeid` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `comment` text,
  `pubdate` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `conversion`
-- ----------------------------
DROP TABLE IF EXISTS `conversion`;
CREATE TABLE `conversion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller` varchar(50) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `paraid` int(11) unsigned DEFAULT '0',
  `title` varchar(200) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `pubdate` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `indexorder` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `flink`
-- ----------------------------
DROP TABLE IF EXISTS `flink`;
CREATE TABLE `flink` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(50) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `indexorder` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `pubdate` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `menu`
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `text` varchar(50) DEFAULT NULL,
  `alt` varchar(200) DEFAULT NULL,
  `link` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `indexorder` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `page`
-- ----------------------------
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` text,
  `pubdate` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`,`pubdate`),
  UNIQUE KEY `name` (`name`) USING HASH
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

