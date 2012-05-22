# 计划任务规则设定
CREATE TABLE `{pre}crontab` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '索引',
	`name` Char(200) DEFAULT '' COMMENT '名称',
	`mode` TINYINT DEFAULT 0 COMMENT '计时模式',
	`describe` Char(100) NOT NULL DEFAULT '' COMMENT '计划描述',
	`schedule` Char(100) NOT NULL DEFAULT '' COMMENT '执行计划',
	`url` Char(200) NOT NULL DEFAULT '' COMMENT '连接地址',
	`exe_count` INT DEFAULT 0 COMMENT '执行次数',
	`exe_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '最近执行日期',
	`next_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '下次执行日期',
	`expire` DATE DEFAULT '0000-00-00' COMMENT '过期日期',
	`code` TEXT COMMENT '执行代码',
	INDEX `next_date` (`next_date`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='计划任务';

# ---------------------------------------------------------------------------------------------------------------