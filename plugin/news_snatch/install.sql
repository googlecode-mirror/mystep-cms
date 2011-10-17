# 新闻采集
CREATE TABLE `{pre}news_snatch` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`idx` Char(40) NOT NULL DEFAULT '',					#规则索引
	`url` Char(200) NOT NULL UNIQUE DEFAULT '',	#新闻网址
	`original` Char(100) NOT NULL DEFAULT '',		#来源网站
	`subject` Char(255) NOT NULL,								#新闻标题
	`item_1` Char(255) DEFAULT '',							#采集文本
	`item_2` Char(255) DEFAULT '',							#采集文本
	`item_3` Char(255) DEFAULT '',							#采集文本
	`item_4` Char(255) DEFAULT '',							#采集文本
	`item_5` Char(255) DEFAULT '',							#采集文本
	`item_6` Char(255) DEFAULT '',							#采集文本
	`item_7` Char(255) DEFAULT '',							#采集文本
	`item_8` Char(255) DEFAULT '',							#采集文本
	`item_9` Char(255) DEFAULT '',							#采集文本
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00',	#录入日期
	`content` MEDIUMTEXT NOT NULL,										#新闻内容
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻采集';