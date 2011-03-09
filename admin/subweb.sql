/*
MyStep 网站系统数据库结构
14:05 2010-12-23 By Windy2000
*/

# ---------------------------------------------------------------------------------------------------------------

Create DataBase if not exists {db_name};
use {db_name};

# 新闻描述
CREATE TABLE `{pre}news_show` (
	`news_id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`cat_id` SMALLINT UNSIGNED NOT NULL,								#新闻类型索引
	`web_id` TINYINT DEFAULT 0,													#所属子站
	`subject` Char(120) NOT NULL,												#新闻标题
	`style` Char(40) NOT NULL,													#标题样式
	`views` MEDIUMINT UNSIGNED DEFAULT 0,								#浏览次数
	`describe` Char(255) DEFAULT '',										#新闻描述
	`original` Char(40) NOT NULL DEFAULT '',						#作者/出处
	`link` Char(255) DEFAULT '',												#跳转网址
	`tag` Char(120) NOT NULL DEFAULT '',								#相关索引
	`image` Char(100) NOT NULL DEFAULT '',							#相关图片
	`setop` SMALLINT UNSIGNED,													#置顶模式
	`pages` TINYINT UNSIGNED NOT NULL DEFAULT 1,				#新闻页数
	`add_user` Char(20) NOT NULL,												#录入人
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00',	#录入日期
	INDEX `catalog` (`web_id`, `cat_id`),
	PRIMARY KEY (`news_id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻描述';

# ---------------------------------------------------------------------------------------------------------------

# 新闻内容
CREATE TABLE `{pre}news_detail` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`cat_id` SMALLINT UNSIGNED NOT NULL,							#新闻类型索引
	`news_id` MEDIUMINT UNSIGNED NOT NULL,						#新闻索引
	`page` TINYINT UNSIGNED DEFAULT 1,								#分页索引
	`sub_title` Char(100) DEFAULT '',									#子标题
	`ctype` TINYINT UNSIGNED DEFAULT 1,								#内容类型(ubb, html)
	`content` TEXT NOT NULL,													#新闻内容
	INDEX (`news_id`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻内容';

# ---------------------------------------------------------------------------------------------------------------

# 新闻关键字（用于进行搜索统计排名）
CREATE TABLE `{pre}news_tag` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`tag` Char(120) NOT NULL,										#关键字
	`count` MEDIUMINT UNSIGNED DEFAULT 0,				#出现次数
	`click` MEDIUMINT UNSIGNED DEFAULT 0,				#点击次数
	`add_date` Char(15) DEFAULT 0,							#关键字添加日期（unixtimestamp）
	`update_date` Char(15) DEFAULT 0,						#关键字更新日期（unixtimestamp）
	INDEX (`count`),
	INDEX (`click`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻关键字';

# ---------------------------------------------------------------------------------------------------------------
