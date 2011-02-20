# 新闻访问统计
CREATE TABLE `{pre}news_visit` (
	`web_id` TINYINT UNSIGNED DEFAULT 0,						#网站索引
	`news_id` MEDIUMINT UNSIGNED NOT NULL,					#文章索引
	`cat_id` MEDIUMINT UNSIGNED NOT NULL,						#分类索引
	`subject` Char(120) NOT NULL,										#新闻标题
	`views` MEDIUMINT UNSIGNED DEFAULT 0,						#总浏览次数
	`day_start` Char(10) DEFAULT '0',								#日统计起点
	`day_count` SMALLINT UNSIGNED DEFAULT 0,				#当日浏览
	`day_max_time` Char(10) DEFAULT '0',						#最大日浏览时间
	`day_max_count` SMALLINT UNSIGNED DEFAULT 0,		#最大日浏览数量
	`week_start` Char(10) DEFAULT '0',							#周统计起点
	`week_count` MEDIUMINT UNSIGNED DEFAULT 0,			#本周浏览
	`week_max_time` Char(10) DEFAULT '0',						#最大周浏览时间
	`week_max_count` MEDIUMINT UNSIGNED DEFAULT 0,	#最大周浏览数量
	`month_start` Char(10) DEFAULT '0',							#月统计起点
	`month_count` MEDIUMINT UNSIGNED DEFAULT 0,			#本月浏览
	`month_max_time` Char(10) DEFAULT '0',					#最大月浏览时间
	`month_max_count` MEDIUMINT UNSIGNED DEFAULT 0,	#最大月浏览数量
	`year_start` Char(10) DEFAULT '0',							#年统计起点
	`year_count` MEDIUMINT UNSIGNED DEFAULT 0,			#本年浏览
	`year_max_time` Char(10) DEFAULT '0',						#最大年浏览时间
	`year_max_count` MEDIUMINT UNSIGNED DEFAULT 0,	#最大年浏览数量
	UNIQUE INDEX `web_news` (`web_id`, `news_id`),
	INDEX (`cat_id`),
	INDEX `day` (`web_id`, `day_count`),
	INDEX `week` (`web_id`, `week_count`),
	INDEX `month` (`web_id`, `month_count`),
	INDEX `year` (`web_id`, `year_count`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='内容数据统计';