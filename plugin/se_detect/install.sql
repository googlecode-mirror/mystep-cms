# 搜索引擎记录
CREATE TABLE `{pre}se_detect` (
	`idx` Char(20) NOT NULL,													#搜索引擎索引
	`ip` Char(30) NOT NULL UNIQUE,										#ip地址
	`count` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,		#访问次数
	index (`idx`),
	INDEX (`ip`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='搜索引擎记录';

# 搜索引擎统计
CREATE TABLE `{pre}se_count` (
	`date` DATE NOT NULL UNIQUE,													#统计日期
	`其他` mediumint(8) unsigned NOT NULL default '0',		#其他引擎统计
	PRIMARY KEY (`date`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='搜索引擎统计';

alter table `{pre}se_count` add `谷歌` mediumint(8) unsigned NOT NULL default '0';
alter table `{pre}se_count` add `百度` mediumint(8) unsigned NOT NULL default '0';
alter table `{pre}se_count` add `有道` mediumint(8) unsigned NOT NULL default '0';
alter table `{pre}se_count` add `雅虎` mediumint(8) unsigned NOT NULL default '0';
alter table `{pre}se_count` add `搜搜` mediumint(8) unsigned NOT NULL default '0';
alter table `{pre}se_count` add `必应_msn` mediumint(8) unsigned NOT NULL default '0';
alter table `{pre}se_count` add `搜狗` mediumint(8) unsigned NOT NULL default '0';
alter table `{pre}se_count` add `必应_bing` mediumint(8) unsigned NOT NULL default '0';