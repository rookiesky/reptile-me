# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 192.168.10.10 (MySQL 5.7.24-0ubuntu0.18.04.1)
# Database: reptile-me
# Generation Time: 2019-05-16 13:11:25 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table links
# ------------------------------------------------------------

DROP TABLE IF EXISTS `links`;

CREATE TABLE `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(191) NOT NULL,
  `web_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '采集状态',
  PRIMARY KEY (`id`),
  KEY `web_id` (`web_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='链接';



# Dump of table web
# ------------------------------------------------------------

DROP TABLE IF EXISTS `web`;

CREATE TABLE `web` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(191) NOT NULL COMMENT '采集链接',
  `list_rule` text NOT NULL COMMENT '列表采集规则',
  `list_total` varchar(60) NOT NULL DEFAULT '0' COMMENT '列表数量',
  `mysql_type` varchar(45) NOT NULL COMMENT '数据库类型',
  `mysql_host` varchar(45) NOT NULL COMMENT '数据库地址',
  `mysql_table` varchar(45) NOT NULL COMMENT '数据库名称',
  `mysql_user` varchar(45) NOT NULL COMMENT '数据库用户名',
  `mysql_password` varchar(45) NOT NULL COMMENT '数据库密码',
  `mysql_prot` int(11) NOT NULL DEFAULT '3306' COMMENT '数据库端口',
  `mysql_prefix` varchar(45) DEFAULT NULL COMMENT '数据库前缀',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0：采集，1：维护',
  `content_title` text NOT NULL COMMENT '标题规则',
  `content_date` text COMMENT '时间规则',
  `content` text NOT NULL COMMENT '内容规则',
  `content_tag` text COMMENT '标签规则',
  `title` varchar(45) NOT NULL COMMENT '采集名称',
  `ruku_type` varchar(45) NOT NULL COMMENT '入库网站类型，如：typecho,wordpress',
  `ruku_id` varchar(191) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
