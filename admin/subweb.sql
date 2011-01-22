/*
MyStep 网站系统数据库结构
14:05 2010-12-23 By Windy2000
*/

# ---------------------------------------------------------------------------------------------------------------

Create DataBase if not exists {db_name};
use {db_name};

# 新闻描述
CREATE TABLE if not exists `{pre}news_show` (
	`news_id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`cat_id` SMALLINT UNSIGNED NOT NULL,								#新闻类型索引
	`web_id` TINYINT DEFAULT 0,													#所属网站
	`subject` Char(120) NOT NULL,												#新闻标题
	`style` Char(40) NOT NULL,													#标题样式
	`views` MEDIUMINT UNSIGNED DEFAULT 0,								#浏览次数
	`describe` Char(255) DEFAULT '',										#新闻描述
	`original` Char(40) NOT NULL DEFAULT '',						#作者/出处
	`link` Char(255) DEFAULT '',												#跳转网址
	`tag` Char(120) NOT NULL DEFAULT '',								#相关索引
	`image` Char(100) NOT NULL DEFAULT '',							#相关图片
	`setop` TINYINT(3) UNSIGNED,												#置顶模式
	`pages` TINYINT UNSIGNED NOT NULL DEFAULT 1,				#新闻页数
	`add_user` Char(20) NOT NULL,												#录入人
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00',	#录入日期
	INDEX (`add_date`),
	PRIMARY KEY (`news_id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻描述';

# ---------------------------------------------------------------------------------------------------------------

# 新闻内容
CREATE TABLE if not exists `{pre}news_detail` (
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

# 内容展示
CREATE TABLE if not exists `{pre}info_show` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT DEFAULT 1,												#所属网站
	`subject` Char(100) NOT NULL,											#展示标题
	`content` TEXT NOT NULL,													#展示内容
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='内容展示';

# ---------------------------------------------------------------------------------------------------------------

# 新闻关键字（用于进行搜索统计排名）
CREATE TABLE if not exists `{pre}news_tag` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT DEFAULT 1,									#所属网站
	`tag` Char(120) NOT NULL,										#关键字
	`count` MEDIUMINT UNSIGNED DEFAULT 0,				#出现次数
	`click` MEDIUMINT UNSIGNED DEFAULT 0,				#点击次数
	`add_date` Char(15) DEFAULT 0,							#关键字添加日期（unixtimestamp）
	`update_date` Char(15) DEFAULT 0,						#关键字更新日期（unixtimestamp）
	INDEX (`count`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻关键字';

# ---------------------------------------------------------------------------------------------------------------

# 新闻附件（所有上传的附件都在此表记录）
CREATE TABLE if not exists `{pre}attachment` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`news_id` MEDIUMINT UNSIGNED,								#关联索引
	`web_id` TINYINT DEFAULT 1,									#所属网站
	`file_name` Char(150) NOT NULL,							#附件文件名
	`file_type` Char(40) NOT NULL,							#附件类型
	`file_size` MEDIUMINT UNSIGNED NOT NULL,		#附件大小
	`file_comment` Char(200) DEFAULT '',				#文件说明
	`file_time` Char(15) DEFAULT 0,							#附件上传时间（unixtimestamp）
	`file_count` MEDIUMINT UNSIGNED DEFAULT 0,	#附件下载次数
	`tag` Char(120),														#相关索引
	`add_user` Char(20) NOT NULL,								#附件添加人
	`watermark` BOOL NOT NULL DEFAULT 0,				#是否添加水印
	INDEX (`news_id`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻附件';

# ---------------------------------------------------------------------------------------------------------------

# 友情链接表
CREATE TABLE if not exists `{pre}links` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT DEFAULT 1,									#所属网站
	`link_name` Char(100) NOT NULL,							#链接名称
	`link_url` Char(100) NOT NULL,							#链接地址
	`image` Char(100),													#链接图形（空视为文字链接，大小固定 88 * 31）
	`level` TINYINT UNSIGNED DEFAULT 0,					#显示级别（0 为不显示）
	INDEX (`level`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='友情链接表';

# ---------------------------------------------------------------------------------------------------------------

# 访问统计
CREATE TABLE if not exists `{idx}_counter` (
	`date` DATE NOT NULL UNIQUE,											#统计日期
	`pv` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,				#页面访问量
	`iv` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,				#IP 访问量
	`online` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,		#最大在线人数
	PRIMARY KEY (`date`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='简单访问统计';

# ---------------------------------------------------------------------------------------------------------------
