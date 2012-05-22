# 新闻专题
CREATE TABLE `{pre}topic` (
	`topic_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '专题索引',
	`topic_name` Char(60) NOT NULL COMMENT '专题名称',
	`topic_idx` Char(20) DEFAULT '' COMMENT '专题索引',
	`topic_image` Char(200) DEFAULT '' COMMENT '专题图示',
	`topic_link` Char(200) DEFAULT '' COMMENT '专题链接',
	`topic_cat` Char(200) DEFAULT '' COMMENT '链接分类',
	`topic_keyword` Char(255) DEFAULT '' COMMENT '链接关键字',
	`topic_intro` TEXT COMMENT '专题介绍',
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '录入日期',
	PRIMARY KEY (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻专题';

# ---------------------------------------------------------------------------------------------------------------

# 新闻专题链接
CREATE TABLE `{pre}topic_link` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '链接索引',
	`topic_id` SMALLINT UNSIGNED NOT NULL COMMENT '专题索引',
	`link_name` Char(100) DEFAULT '' COMMENT '链接名称',
	`link_url` Char(200) DEFAULT  '' UNIQUE COMMENT '链接地址',
	`link_cat` TINYINT UNSIGNED COMMENT '链接分类',
	`link_order` TINYINT UNSIGNED COMMENT '链接排序',
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '添加日期',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻专题链接';