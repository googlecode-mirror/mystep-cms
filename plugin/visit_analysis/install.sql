# 来源网址记录
CREATE TABLE `{pre}visit_analysis` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`domain` Char(100) NOT NULL UNIQUE,								#ip地址
	`add_date` Char(15) DEFAULT 0,										#首次来访日期（unixtimestamp）
	`chg_date` Char(15) DEFAULT 0,										#最近来访日期（unixtimestamp）
	`count` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,		#来访次数
	index (`domain`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='来源网址记录';
INSERT INTO `{pre}visit_analysis` values(0, 'None', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), 0);

# 来访关键字
CREATE TABLE `{pre}visit_keyword` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`keyword` Char(80) NOT NULL UNIQUE,				#关键字
	`count` SMALLINT DEFAULT 0,								#搜索次数
	`add_date` Char(15) DEFAULT 0,						#首次检索日期（unixtimestamp）
	`chg_date` Char(15) DEFAULT 0,						#最近检索日期（unixtimestamp）
	INDEX (`keyword`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='来访关键字';
