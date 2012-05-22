# 搜索引擎记录
CREATE TABLE `{pre}se_detect` (
	`idx` Char(20) NOT NULL COMMENT '搜索引擎索引',
	`ip` Char(30) NOT NULL UNIQUE COMMENT 'ip地址',
	`count` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL COMMENT '访问次数',
	index (`idx`),
	INDEX (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='搜索引擎记录';

# 搜索引擎统计
CREATE TABLE `{pre}se_count` (
	`date` DATE NOT NULL UNIQUE COMMENT '统计日期',
	`其他` mediumint(8) unsigned NOT NULL default '0' COMMENT '其他引擎统计',
	PRIMARY KEY (`date`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='搜索引擎统计';

alter table `{pre}se_count` add `有道` mediumint(8) unsigned NOT NULL default '0' after `date`;
alter table `{pre}se_count` add `搜搜` mediumint(8) unsigned NOT NULL default '0' after `date`;
alter table `{pre}se_count` add `搜狗` mediumint(8) unsigned NOT NULL default '0' after `date`;
alter table `{pre}se_count` add `雅虎` mediumint(8) unsigned NOT NULL default '0' after `date`;
alter table `{pre}se_count` add `必应` mediumint(8) unsigned NOT NULL default '0' after `date`;
alter table `{pre}se_count` add `百度` mediumint(8) unsigned NOT NULL default '0' after `date`;
alter table `{pre}se_count` add `谷歌` mediumint(8) unsigned NOT NULL default '0' after `date`;