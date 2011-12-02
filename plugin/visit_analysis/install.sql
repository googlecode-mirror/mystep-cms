# 来源网址记录
CREATE TABLE `{pre}visit_analysis` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`host` Char(100) NOT NULL UNIQUE,											#来源主机
	`count` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,				#总来访次数
	`count_month` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,	#月来访次数
	`count_year` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,		#年来访次数
	`add_date` Char(15) DEFAULT 0,												#首次来访日期（unixtimestamp）
	`chg_date` Char(15) DEFAULT 0,												#最近来访日期（unixtimestamp）
	index (`host`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='来源网址记录';
INSERT INTO `{pre}visit_analysis` values(0, 'None', 0, 0, 0, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

# 来访关键字
CREATE TABLE `{pre}visit_keyword` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`keyword` Char(200) NOT NULL UNIQUE,									#关键字
	`count` SMALLINT DEFAULT 0,														#搜索次数
	`url` Char(200) DEFAULT "###" NOT NULL,								#访问网址
	`referer` Char(255) DEFAULT "" NOT NULL,							#最近来源网址
	`add_date` Char(15) DEFAULT 0,												#首次检索日期（unixtimestamp）
	`chg_date` Char(15) DEFAULT 0,												#最近检索日期（unixtimestamp）
	INDEX (`keyword`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='来访关键字';

/*
#2011.10.19
alter table ms_visit_analysis add `count_year` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL after `count`;
alter table ms_visit_analysis add `count_month` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL after `count`;
alter table ms_visit_keyword add `url` Char(200) DEFAULT "###" NOT NULL after `count`;
alter table ms_visit_keyword add `referer` Char(200) DEFAULT "" NOT NULL after `url`;
alter table ms_visit_keyword modify `keyword` Char(200) NOT NULL UNIQUE;
update  ms_visit_analysis set `count_month`=`count`, `count_year`=`count`;
*/