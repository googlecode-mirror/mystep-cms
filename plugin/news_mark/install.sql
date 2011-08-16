# 新闻评分
CREATE TABLE `{pre}news_mark` (
	`web_id` TINYINT UNSIGNED DEFAULT 0,						#网站索引
	`news_id` MEDIUMINT UNSIGNED,										#关联索引
	`cat_id` MEDIUMINT UNSIGNED NOT NULL,						#分类索引
	`subject` Char(120) NOT NULL,										#新闻标题
	`jump` SMALLINT DEFAULT 0,											#提升次数
	`jump_time` Char(10) DEFAULT '0',								#最近提升时间
	`rank_times` SMALLINT UNSIGNED DEFAULT 0,				#内容评分次数
	`rank_total` INT DEFAULT 0,											#内容评分总分
	`rank_time` Char(10) DEFAULT '0',								#最近评分时间
	UNIQUE INDEX `web_news` (`web_id`, `news_id`),
	INDEX (`jump`),
	INDEX (`rank_total`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻评分';