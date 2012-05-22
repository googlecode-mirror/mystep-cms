# 新闻评论
CREATE TABLE `{pre}comment` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT UNSIGNED DEFAULT 0 COMMENT '网站索引',
	`news_id` MEDIUMINT UNSIGNED COMMENT '关联索引',
	`user_name` Char(40) NOT NULL COMMENT '用户名称',
	`ip` Char(24) NOT NULL COMMENT '用户 IP',
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '评论发表日期',
	`comment` TEXT NOT NULL COMMENT '评论内容',
	`agree` MEDIUMINT UNSIGNED DEFAULT 0 COMMENT '赞同',
	`oppose` MEDIUMINT UNSIGNED DEFAULT 0 COMMENT '反对',
	`report` MEDIUMINT UNSIGNED DEFAULT 0 COMMENT '举报',
	`rpt_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '举报日期',
	`quote` SMALLINT UNSIGNED DEFAULT 0 COMMENT '引用楼层',
	INDEX `idx` (`web_id`, `news_id`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻评论';

# ---------------------------------------------------------------------------------------------------------------

