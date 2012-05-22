# 新闻评分
CREATE TABLE `{pre}news_mark` (
	`web_id` TINYINT UNSIGNED DEFAULT 0 COMMENT '网站索引',
	`news_id` MEDIUMINT UNSIGNED COMMENT '关联索引',
	`cat_id` MEDIUMINT UNSIGNED NOT NULL COMMENT '分类索引',
	`subject` Char(120) NOT NULL COMMENT '新闻标题',
	`jump` SMALLINT DEFAULT 0 COMMENT '提升次数',
	`jump_time` Char(10) DEFAULT '0' COMMENT '最近提升时间',
	`rank_times` SMALLINT UNSIGNED DEFAULT 0 COMMENT '内容评分次数',
	`rank_total` INT DEFAULT 0 COMMENT '内容评分总分',
	`rank_time` Char(10) DEFAULT '0' COMMENT '最近评分时间',
	UNIQUE INDEX `web_news` (`web_id`, `news_id`),
	INDEX (`jump`),
	INDEX (`rank_total`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻评分';