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
	`date` DATE NOT NULL UNIQUE,											#统计日期
	PRIMARY KEY (`date`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='搜索引擎统计';